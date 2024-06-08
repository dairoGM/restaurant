<?php

namespace App\Controller\Api;

use App\Entity\Restaurant\Contactenos;
use App\Entity\Restaurant\Perfil;
use App\Entity\Restaurant\ReservacionMesa;
use App\Entity\Security\User;
use App\Form\Restaurant\ContactenosApiType;
use App\Form\Restaurant\PerfilApiType;
use App\Form\Restaurant\ReservacionMesaType;
use App\Repository\Configuracion\CateringRepository;
use App\Repository\Configuracion\ComentarioEspacioRepository;
use App\Repository\Configuracion\ConocenosRedesSocialesRepository;
use App\Repository\Configuracion\ConocenosRepository;
use App\Repository\Configuracion\DatosContactoRepository;
use App\Repository\Configuracion\EspacioRedesSocialesRepository;
use App\Repository\Configuracion\EspacioRepository;
use App\Repository\Configuracion\EventoRepository;
use App\Repository\Configuracion\ExperienciaCulinariaRepository;
use App\Repository\Configuracion\ExperienciaGastronomicaRepository;
use App\Repository\Configuracion\MaridajeRepository;
use App\Repository\Configuracion\MenuPlatoRepository;
use App\Repository\Configuracion\MenuRepository;
use App\Repository\Configuracion\PlatoRepository;
use App\Repository\Configuracion\PortadaRepository;
use App\Repository\Configuracion\ReservaRepository;
use App\Repository\Configuracion\SeccionServicioRepository;
use App\Repository\Configuracion\ServicioRepository;
use App\Repository\Configuracion\SobreRepository;
use App\Repository\Configuracion\TerminosCondicionesRepository;
use App\Repository\Restaurant\ContactenosRepository;
use App\Repository\Restaurant\PerfilRepository;
use App\Repository\Restaurant\ReservacionMesaRepository;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\Utils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/service")
 */
class ApiWithoutAuthorizationController extends AbstractController
{
    private $requestStack;
    private $baseUrl;
    private UserPasswordHasherInterface $hasher;

    public function __construct(RequestStack $requestStack, UserPasswordHasherInterface $hasher)
    {
        $this->requestStack = $requestStack;
        $request = $this->requestStack->getCurrentRequest();

        // Obtener la URL base
        $this->baseUrl = $request->getSchemeAndHttpHost() . $request->getBasePath();
        $this->hasher = $hasher;
    }

    /**
     * @Route("/contactenos/crear", name="api_contactenos_crear",methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param Request $request
     * @param ContactenosRepository $contactenosRepository
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function crearContactenos(Request $request, ContactenosRepository $contactenosRepository, EntityManagerInterface $em)
    {
        try {
            $jsonParams = json_decode($request->getContent(), true);

            if (isset($jsonParams['correo']) && !empty($jsonParams['correo']) && isset($jsonParams['nombre']) && !empty($jsonParams['nombre'])
                && isset($jsonParams['mensaje']) && !empty($jsonParams['mensaje'])) {

                $contactenos = new Contactenos();
                $form = $this->createForm(ContactenosApiType::class, $contactenos);
                $form->submit($jsonParams);
                if ($form->isSubmitted() && $form->isValid()) {
                    $contactenos->setNombre($jsonParams['nombre']);
                    $contactenos->setCorreo($jsonParams['correo']);
                    $contactenos->setMensaje($jsonParams['mensaje']);

                    $em->persist($contactenos);
                    $em->flush();

                    return $this->json(['messaje' => 'OK', 'data' => $contactenosRepository->listarContactenos(['id' => $contactenos->getId()], ['id' => 'desc'], 1)]);
                }
                return $this->json(['messaje' => $form->getErrors(), 'data' => []], Response::HTTP_BAD_REQUEST);
            }
            return $this->json(['messaje' => 'Incorrect Parameter', 'data' => []], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }


    /**
     * @Route("/servicio/listar", name="api_servicio_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param ServicioRepository $servicioRepository
     * @return JsonResponse
     */
    public function listarServiciosPublicos(Request $request, ServicioRepository $servicioRepository, SeccionServicioRepository $seccionServicioRepository)
    {
        try {
            $jsonParams = json_decode($request->getContent(), true);
            $idTipoServicio = $jsonParams['idTipoServicio'] ?? null;
            $filtros['publico'] = true;
            $filtros['activo'] = true;
            if (!empty($idTipoServicio)) {
                $filtros['tipoServicio'] = $idTipoServicio;
            }
            $result = $servicioRepository->listarServicios($filtros);
            $response = [];
            if (is_array($result)) {
                foreach ($result as $value) {
                    $value['imagenPortada'] = !empty($value['imagenPortada']) ? $this->baseUrl . "/uploads/images/servicio/imagenPortada/" . $value['imagenPortada'] : null;
                    $value['imagenDetallada'] = !empty($value['imagenDetallada']) ? $this->baseUrl . "/uploads/images/servicio/imagenDetallada/" . $value['imagenDetallada'] : null;
                    $seccion = $seccionServicioRepository->listarSeccionServicio(['s.id' => $value['id']]);
                    $seccionAss = [];
                    foreach ($seccion as $v) {
                        $v['imagen'] = !empty($v['imagen']) ? $this->baseUrl . "/uploads/images/servicio/seccion/imagen/" . $v['imagen'] : null;
                        $seccionAss[] = $v;
                    }
                    $value['secciones'] = $seccionAss;
                    $response[] = $value;
                }
            }
            return $this->json(['messaje' => 'OK', 'data' => $response]);
        } catch (Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }

    /**
     * @Route("/portada/listar", name="api_portada_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param PortadaRepository $portadaRepository
     * @return JsonResponse
     */
    public function listarPortadas(PortadaRepository $portadaRepository)
    {
        try {
            $result = $portadaRepository->listarPortadas(['publico' => true, 'activo' => true]);
            $response = [];
            if (is_array($result)) {
                foreach ($result as $value) {
                    $value['imagen'] = !empty($value['imagen']) ? $this->baseUrl . "/uploads/images/portada_web/imagen/" . $value['imagen'] : null;
                    $value['imagen2'] = !empty($value['imagen2']) ? $this->baseUrl . "/uploads/images/portada_web/imagen2/" . $value['imagen2'] : null;
                    $value['imagen3'] = !empty($value['imagen3']) ? $this->baseUrl . "/uploads/images/portada_web/imagen3/" . $value['imagen3'] : null;
                    $value['imagen4'] = !empty($value['imagen4']) ? $this->baseUrl . "/uploads/images/portada_web/imagen4/" . $value['imagen4'] : null;
                    $response[] = $value;
                }
            }
            return $this->json(['messaje' => 'OK', 'data' => $response]);
        } catch (Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }


    /**
     * @Route("/menu/listar", name="api_menu_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param MenuRepository $menuRepository
     * @return JsonResponse
     */
    public function listarMenu(MenuRepository $menuRepository, MenuPlatoRepository $menuPlatoRepository)
    {
        try {
            $response = [];
            $result = $menuRepository->listarMenus(['publico' => true]);
            if (is_array($result)) {
                foreach ($result as $value) {
                    $precio = $menuPlatoRepository->getPrecioMenu($value['id']);
                    $value['precio'] = $precio[0]['precio'] ?? 0;
                    $value['imagenEspacio'] = !empty($value['imagenEspacio']) ? $this->baseUrl . '/uploads/images/espacio/imagenPortada/' . $value['imagenEspacio'] : null;
                    $response[] = $value;
                }
            }
            return $this->json(['messaje' => 'OK', 'data' => $response]);
        } catch (Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY, ['Access-Control-Allow-Origin' => '*', 'Content-Type' => 'application/json']);
        }
    }

    /**
     * @Route("/perfil/listar", name="api_perfil_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param PerfilRepository $perfilRepository
     * @return JsonResponse
     */
    public function listarPerfiles(Request $request, PerfilRepository $perfilRepository)
    {
        try {
            $jsonParams = json_decode($request->getContent(), true);
            $filtros = [];
            $usuario = $jsonParams['usuario'] ?? null;
            if (!empty($usuario)) {
                $filtros['usuario'] = $usuario;
            }
            $result = $perfilRepository->listarPerfiles($filtros);
            return $this->json(['messaje' => 'OK', 'data' => $result]);
        } catch (Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }

    /**
     * @Route("/perfil/crear", name="api_perfil_crear",methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param Request $request
     * @param PerfilRepository $perfilRepository
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function crearPerfil(Request $request, PerfilRepository $perfilRepository, EntityManagerInterface $em, Utils $utils)
    {
        try {
            $jsonParams = json_decode($request->getContent(), true);
            if (isset($jsonParams['email']) && !empty($jsonParams['email']) && isset($jsonParams['password']) && !empty($jsonParams['password'])) {
                $perfil = $perfilRepository->findOneBy(['email' => $jsonParams['email']]);

                if (!$perfil instanceof Perfil) {
                    $perfil = new Perfil();
                }
                $form = $this->createForm(PerfilApiType::class, $perfil);
                $form->submit($jsonParams);
                if ($form->isSubmitted() && $form->isValid()) {
                    $perfil->setNombre($perfil->getEmail());
                    $perfil->setActivo(true);

                    $user = new User();
                    $user->setEmail($jsonParams['email']);
                    $user->setRole('ROLE_CLIENT');
                    $password = $this->hasher->hashPassword($user, $jsonParams['password']);
                    $user->setPassword($password);
                    $em->persist($user);

                    $perfil->setUser($user);
                    $em->persist($perfil);

                    $em->flush();

                    $token = $utils->getToken($jsonParams['email'], $jsonParams['password']);
                    return $this->json(['messaje' => 'OK', 'token' => $token, 'data' => $perfilRepository->listarPerfiles(['email' => $jsonParams['email']], ['id' => 'desc'], 1)]);
                }
                return $this->json(['messaje' => $form->getErrors(), 'token' => null, 'data' => []], Response::HTTP_BAD_REQUEST);
            }
            return $this->json(['messaje' => 'Incorrect Parameter', 'token' => null, 'data' => []], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'token' => null, 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }


    /**
     * @Route("/perfil/editar", name="api_perfil_editar", methods={"PUT"}, defaults={"_format":"json"})
     * @param Request $request
     * @param PerfilRepository $perfilRepository
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function editarPerfil(Request $request, PerfilRepository $perfilRepository, EntityManagerInterface $em)
    {
        try {
            $jsonParams = json_decode($request->getContent(), true);
            if (isset($jsonParams['email']) && !empty($jsonParams['email']) && isset($jsonParams['password']) && !empty($jsonParams['password'])) {
                $perfil = $perfilRepository->findOneBy(['email' => $jsonParams['email']]);
                if ($perfil instanceof Perfil) {
                    $form = $this->createForm(PerfilApiType::class, $perfil);
                    $form->submit($jsonParams);
                    $em->persist($perfil);
                    $em->flush();
                    return $this->json(['messaje' => 'OK', 'data' => $perfilRepository->listarPerfiles(['email' => $jsonParams['email']], ['id' => 'desc'], 1)[0]]);
                }
                return $this->json(['messaje' => 'Item no found', 'data' => []], Response::HTTP_NOT_FOUND);
            }
            return $this->json(['messaje' => 'Incorrect Parameter', 'data' => []], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }

    }

    /**
     * @Route("/perfil/eliminar", name="api_perfil_eliminar", methods={"POST"}, defaults={"_format":"json"})
     * @param Request $request
     * @param PerfilRepository $perfilRepository
     * @return JsonResponse
     */
    public function eliminarPerfil(Request $request, PerfilRepository $perfilRepository, EntityManagerInterface $em)
    {
        try {
            $jsonParams = json_decode($request->getContent(), true);
            if (isset($jsonParams['email']) && !empty($jsonParams['email'])) {
                $perfil = $perfilRepository->findBy(['email' => $jsonParams['email']]);
                if (isset($perfil[0])) {
                    $em->remove($perfil[0]);
                    $em->flush();
                }
                return $this->json(['messaje' => 'Elemento eliminado satisfactoriamente.', 'data' => []]);
            }
            return $this->json(['messaje' => 'Incorrect Parameter', 'data' => []], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }

    /**
     * @Route("/autenticar", name="api_autenticar", methods={"POST"}, defaults={"_format":"json"})
     * @param Request $request
     * @param PerfilRepository $perfilRepository
     * @return JsonResponse
     */
    public function autenticar(Request $request, PerfilRepository $perfilRepository, Utils $utils)
    {
        try {
            $jsonParams = json_decode($request->getContent(), true);
            if (isset($jsonParams['email']) && !empty($jsonParams['email']) && isset($jsonParams['password']) && !empty($jsonParams['password'])) {
                $perfil = $perfilRepository->listarPerfiles(['email' => $jsonParams['email'], 'password' => $jsonParams['password']]);
                $token = $utils->getToken($jsonParams['email'], $jsonParams['password']);

                return $this->json(['messaje' => isset($perfil[0]) ? 'Usuario autenticado' : 'Usuario o clave incorrecto', 'token' => $token, 'data' => $perfil[0] ?? [], 'autenticado' => isset($perfil[0])]);
            }

            return $this->json(['messaje' => 'Incorrect Parameter', 'token' => null, 'data' => [], 'autenticado' => false], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'token' => null, 'data' => [], 'autenticado' => false], Response::HTTP_BAD_GATEWAY);
        }
    }


    /**
     * @Route("/datos_contacto/listar", name="api_datos_contacto_crear", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param DatosContactoRepository $datosContactoRepository
     * @return JsonResponse
     */
    public function listarDatosContacto(DatosContactoRepository $datosContactoRepository)
    {
        try {
            return $this->json(['messaje' => 'OK', 'data' => $datosContactoRepository->findAll()]);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }

    /**
     * @Route("/sobre/listar", name="api_sobre_crear", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param SobreRepository $sobreRepository
     * @return JsonResponse
     */
    public function listarSobre(SobreRepository $sobreRepository)
    {
        try {
            return $this->json(['messaje' => 'OK', 'data' => $sobreRepository->findAll()]);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }


    /**
     * @Route("/terminos_condiciones/listar", name="api_terminos_condiciones_crear", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param TerminosCondicionesRepository $terminosCondicionesRepository
     * @return JsonResponse
     */
    public function listarTerminosCondiciones(TerminosCondicionesRepository $terminosCondicionesRepository)
    {
        try {
            return $this->json(['messaje' => 'OK', 'data' => $terminosCondicionesRepository->findAll()]);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }

    /**
     * @Route("/espacio/listar", name="api_espacio_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param EspacioRepository $espacioRepository
     * @param EspacioRedesSocialesRepository $espacioRedesSocialesRepository
     * @return JsonResponse
     */
    public function listarEspacios(EspacioRepository $espacioRepository, EspacioRedesSocialesRepository $espacioRedesSocialesRepository, ComentarioEspacioRepository $comentarioEspacioRepository)
    {
        try {
            $result = $espacioRepository->listarEspacios(['publico' => true, 'activo' => true]);
            $response = [];
            if (is_array($result)) {
                foreach ($result as $value) {
                    $value['imagenPortada'] = !empty($value['imagenPortada']) ? $this->baseUrl . '/uploads/images/espacio/imagenPortada/' . $value['imagenPortada'] : null;
                    $value['imagenDetallada'] = !empty($value['imagenDetallada']) ? $this->baseUrl . '/uploads/images/espacio/imagenDetallada/' . $value['imagenDetallada'] : null;
                    $value['imagenBanner'] = !empty($value['imagenBanner']) ? $this->baseUrl . '/uploads/images/espacio/imagenBanner/' . $value['imagenBanner'] : null;
                    $value['imagenMovil'] = !empty($value['imagenMovil']) ? $this->baseUrl . '/uploads/images/espacio/imagenMovil/' . $value['imagenMovil'] : null;
                    $value['redesSociales'] = $espacioRedesSocialesRepository->listarRedesSocialesEspacios(['e.id' => $value['id']]);

                    $comentarios = $comentarioEspacioRepository->listarComentariosEspacios(['e.id' => $value['id']]);
                    $comentariosAsignados = [];
                    foreach ($comentarios as $v) {
                        $v['imagen'] = !empty($v['imagen']) ? $this->baseUrl . "/uploads/images/espacio/comentario/imagen/" . $v['imagen'] : null;
                        $comentariosAsignados[] = $v;
                    }

                    $value['comentarios'] = $comentariosAsignados;
                    $response[] = $value;
                }
            }
            return $this->json(['messaje' => 'OK', 'data' => $response]);
        } catch (Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }


    /**
     * @Route("/item_reserva/listar", name="api_item_reserva_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param ReservaRepository $reservaRepository
     * @return JsonResponse
     */
    public function listarItemReserva(ReservaRepository $reservaRepository)
    {
        try {
            $result = $reservaRepository->listarItemReserva(['activo' => true]);
            return $this->json(['messaje' => 'OK', 'data' => $result]);
        } catch (Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }

    /**
     * @Route("/plato/listar", name="api_plato_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param Request $request
     * @param MenuPlatoRepository $menuPlatoRepository
     * @param Utils $utils
     * @return JsonResponse
     */
    public function listarPlatos(Request $request, MenuPlatoRepository $menuPlatoRepository, Utils $utils)
    {
        try {
            $jsonParams = json_decode($request->getContent(), true);
            $idEspacio = $jsonParams['id_espacio'] ?? -1;

            $response = $utils->listarPlatos($menuPlatoRepository, $this->baseUrl, false, $idEspacio);
            return $this->json(['messaje' => 'OK', 'data' => $response]);
        } catch (Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }

    /**
     * @Route("/plato/listar-sugerencia-chef", name="api_plato_listar-sugerencia-chef", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param MenuPlatoRepository $menuPlatoRepository
     * @param Utils $utils
     * @return JsonResponse
     */
    public function listarPlatosSugerenciaChef(MenuPlatoRepository $menuPlatoRepository, Utils $utils)
    {
        try {
            $response = $utils->listarPlatos($menuPlatoRepository, $this->baseUrl, true, -1);
            return $this->json(['messaje' => 'OK', 'data' => $response]);
        } catch (Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }


    /**
     * @Route("/conocenos/listar", name="api_conocenos_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param ConocenosRepository $conocenosRepository
     * @param ConocenosRedesSocialesRepository $conocenosRedesSocialesRepository
     * @return JsonResponse
     */
    public function listarConocenos(ConocenosRepository $conocenosRepository, ConocenosRedesSocialesRepository $conocenosRedesSocialesRepository)
    {
        try {
            $result = $conocenosRepository->listarConocenos(['publico' => true]);
            $response = [];
            if (is_array($result)) {
                foreach ($result as $value) {
                    $value['redes_sociales'] = $conocenosRedesSocialesRepository->listarRedesSocialesEspacios(['c.id' => $value['id']]);
                    $value['imagen'] = !empty($value['imagenPortada']) ? $this->baseUrl . '/uploads/images/conocenos/imagen/' . $value['imagen'] : null;
                    $response[] = $value;
                }
            }
            return $this->json(['messaje' => 'OK', 'data' => $response]);
        } catch (Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }


    /**
     * @Route("/enviar-datos-contacto", name="enviar-datos-contacto", methods={"POST", "OPTIONS"} )
     * @param Request $request
     * @param MailerInterface $mailer
     * @return JsonResponse
     * @throws GuzzleException
     * @throws TransportExceptionInterface
     */
    public function enviarDatosContacto(Request $request, MailerInterface $mailer)
    {
        try {
            $body = '<p>Se esta solicitando comunicación con BIPAY desde el sitio con los siguientes datos de contacto: <br>
                         
                          <b>Correo: </b>' . "asdasdasd" . '<br>
                        </p><br>';


            $email = (new Email())
                ->from(new Address('dairoroberto2014@gmail.com'))
                ->to(new Address('restaurat.reserva@gmail.com'))
                ->subject('Holaaa')
                ->html($body);
            $mailer->send($email);

            return $this->json('Datos enviados y guardados satisfactoriamente.');


        } catch (Exception $exc) {
            pr($exc->getMessage());
            return $this->json($exc->getMessage());
        }
    }


    /**
     * @Route("/reservar/mesa/crear", name="api_reservar_mesa_crear",methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param Request $request
     * @param EspacioRepository $espacioRepository
     * @param PerfilRepository $perfilRepository
     * @param EntityManagerInterface $em
     * @param ReservacionMesaRepository $reservacionMesaRepository
     * @return JsonResponse
     */
    public function reservarMesa(Request $request, EspacioRepository $espacioRepository, PerfilRepository $perfilRepository, EntityManagerInterface $em, ReservacionMesaRepository $reservacionMesaRepository)
    {
        try {
            $jsonParams = json_decode($request->getContent(), true);

            if (isset($jsonParams['email']) && !empty($jsonParams['email'])
                && isset($jsonParams['fechaReservacion']) && !empty($jsonParams['fechaReservacion'])
                && isset($jsonParams['cantidadMesa']) && !empty($jsonParams['cantidadMesa'])
                && isset($jsonParams['nombreCompleto']) && !empty($jsonParams['nombreCompleto'])
                && isset($jsonParams['celular']) && !empty($jsonParams['celular'])
                && isset($jsonParams['dni']) && !empty($jsonParams['dni'])
                && isset($jsonParams['espacio']) && !empty($jsonParams['espacio'])) {

                $reservacionMesa = new ReservacionMesa();
                $form = $this->createForm(ReservacionMesaType::class, $reservacionMesa);
                $form->submit($jsonParams);
                if ($form->isSubmitted() && $form->isValid()) {
                    $espacio = $espacioRepository->find($jsonParams['espacio']);
                    $mesasEspacio = $espacio->getCantidadMesa();
                    $fecha = explode(' ', $jsonParams['fechaReservacion'])[0];
                    $reservacionesRealizadas = $reservacionMesaRepository->getCantidadReservaciones($fecha);

                    if (intval($jsonParams['cantidadMesa']) <= $mesasEspacio) {
                        if (($mesasEspacio - $reservacionesRealizadas) >= $jsonParams['cantidadMesa']) {
                            $perfil = $perfilRepository->findBy(['email' => $jsonParams['email']]);
                            if (isset($perfil[0])) {
                                $reservacionMesa->setTicket(uniqid('RESERV_'));
                                $reservacionMesa->setPerfil($perfil[0]);
                                $reservacionMesa->setEspacio($espacio);
                                $reservacionMesa->setEstado('Activa');
                                $reservacionMesa->setFechaReservacion(\DateTime::createFromFormat('Y-m-d H:i:s', $jsonParams['fechaReservacion']));

                                $em->persist($reservacionMesa);
                                $em->flush();

                                return $this->json(['messaje' => 'OK', 'data' => ['ticked' => $reservacionMesa->getTicket()]]);
                            }
                            return $this->json(['messaje' => "Usuario no válido", 'data' => []], Response::HTTP_BAD_REQUEST);
                        }
                        return $this->json(['messaje' => "La disponibilidad de mesas es insuficiente", 'data' => []], Response::HTTP_BAD_REQUEST);
                    }
                    return $this->json(['messaje' => "La cantidad de mesas solicitada es superior a las mesas del espacio seleccionado", 'data' => []], Response::HTTP_BAD_REQUEST);
                }
                return $this->json(['messaje' => $form->getErrors(), 'data' => []], Response::HTTP_BAD_REQUEST);
            }
            return $this->json(['messaje' => 'Incorrect Parameter', 'data' => []], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }

    /**
     * @Route("/espacio/disponibilidad", name="api_espacio_disponibilidad", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param Request $request
     * @param EspacioRepository $espacioRepository
     * @param ReservacionMesaRepository $reservacionMesaRepository
     * @return JsonResponse
     */
    public function getDisponibilidadEspacio(Request $request, EspacioRepository $espacioRepository, ReservacionMesaRepository $reservacionMesaRepository)
    {
        try {
            $jsonParams = json_decode($request->getContent(), true);
            $date = $jsonParams['fecha'] ?? date('Y-m-d');
            $espacios = $espacioRepository->findAll();
            $response = [];
            foreach ($espacios as $value) {
                $reservaciones = $reservacionMesaRepository->getCantidadReservaciones($date, $value->getId());
                $disponibilidadEspacio = $value->getCantidadMesa();
                $item['idEspacio'] = $value->getId();
                $item['nombreCorto'] = $value->getNombreCorto();
                $item['cantidadMesa'] = intval($disponibilidadEspacio);
                $item['reservaciones'] = intval($reservaciones);
                $item['disponibilidad'] = ($disponibilidadEspacio - $reservaciones) > 0 ? ($disponibilidadEspacio - $reservaciones) : 0;
                $item['fecha'] = $date;
                $response[] = $item;
            }
            return $this->json(['messaje' => 'OK', 'data' => $response]);
        } catch (Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }

}
