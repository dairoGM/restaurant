<?php

namespace App\Controller\Api;

use App\Entity\Restaurant\Contactenos;
use App\Entity\Restaurant\Perfil;
use App\Form\Restaurant\ContactenosApiType;
use App\Form\Restaurant\PerfilApiType;
use App\Repository\Configuracion\CateringRepository;
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
use App\Repository\Configuracion\ServicioRepository;
use App\Repository\Configuracion\SobreRepository;
use App\Repository\Configuracion\TerminosCondicionesRepository;
use App\Repository\Restaurant\ContactenosRepository;
use App\Repository\Restaurant\PerfilRepository;
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
use Symfony\Component\Routing\Annotation\Route;
use App\Services\Utils;

/**
 * @Route("/services")
 */
class ApiWithoutAuthorizationController extends AbstractController
{
    private $requestStack;
    private $baseUrl;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $request = $this->requestStack->getCurrentRequest();

        // Obtener la URL base
        $this->baseUrl = $request->getSchemeAndHttpHost() . $request->getBasePath();
    }

    /**
     * @Route("/eventos/listar", name="api_eventos_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param EventoRepository $eventoRepository
     * @return JsonResponse
     */
    public function listarEventos(EventoRepository $eventoRepository)
    {
//        try {
//            $result = $eventoRepository->listarEventos(['activo' => true]);
//            return $this->json(['messaje' => 'OK', 'data' => $result]);
//        } catch (Exception $exc) {
//            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
//        }
    }

    /**
     * @Route("/maridaje/listar", name="api_maridajes_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param MaridajeRepository $maridajeRepository
     * @return JsonResponse
     */
    public function listarMaridajes(MaridajeRepository $maridajeRepository)
    {
//        try {
//            $result = $maridajeRepository->listarMaridajes(['activo' => true]);
//            return $this->json(['messaje' => 'OK', 'data' => $result]);
//        } catch (Exception $exc) {
//            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
//        }
    }

    /**
     * @Route("/catering/listar", name="api_catering_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param CateringRepository $cateringRepository
     * @return JsonResponse
     */
    public function listarCatering(CateringRepository $cateringRepository)
    {
//        try {
//            $result = $cateringRepository->listarCatering(['activo' => true]);
//            return $this->json(['messaje' => 'OK', 'data' => $result]);
//        } catch (Exception $exc) {
//            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
//        }
    }

    /**
     * @Route("/servicio/listar", name="api_servicio_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param ServicioRepository $servicioRepository
     * @return JsonResponse
     */
    public function listarServiciosPublicos(ServicioRepository $servicioRepository)
    {
        try {
            $result = $servicioRepository->listarServicios(['publico' => true, 'activo' => true]);
            $response = [];
            if (is_array($result)) {
                foreach ($result as $value) {
                    $value['imagenPortada'] = !empty($value['imagenPortada']) ? $this->baseUrl . "/uploads/images/servicio/imagenPortada/" . $value['imagenPortada'] : null;
                    $value['imagenDetallada'] = !empty($value['imagenDetallada']) ? $this->baseUrl . "/uploads/images/servicio/imagenDetallada/" . $value['imagenDetallada'] : null;
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
     * @Route("/experiencia_gastronomica/listar", name="api_experiencia_gastronomica_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param ExperienciaGastronomicaRepository $experienciaGastronomicaRepository
     * @return JsonResponse
     */
    public function listarExperienciaGastronomica(ExperienciaGastronomicaRepository $experienciaGastronomicaRepository)
    {
//        try {
//            $result = $experienciaGastronomicaRepository->listarExperienciaGastronomica(['publico' => true]);
//            return $this->json(['messaje' => 'OK', 'data' => $result]);
//        } catch (Exception $exc) {
//            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
//        }
    }

    /**
     * @Route("/experiencia_culinaria/listar", name="api_experiencia_culinaria_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param ExperienciaCulinariaRepository $experienciaCulinariaRepository
     * @return JsonResponse
     */
    public function listarExperienciaCulinaria(ExperienciaCulinariaRepository $experienciaCulinariaRepository)
    {
//        try {
//            $result = $experienciaCulinariaRepository->listarExperienciaCulinaria(['publico' => true]);
//            return $this->json(['messaje' => 'OK', 'data' => $result]);
//        } catch (Exception $exc) {
//            return $this->json(['messaje' => $exc->getMessage(), 'data' => null], Response::HTTP_BAD_GATEWAY);
//        }
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
            return $this->json(['messaje' => 'OK', 'data' => $response], Response::HTTP_OK, ['Mc-Validation-Verify' => '811aee8a7996eb12a7e600a489b7b27f', 'Access-Control-Allow-Origin' => '*', 'Content-Type' => 'application/json']);
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
    public function crearPerfil(Request $request, PerfilRepository $perfilRepository, EntityManagerInterface $em)
    {
        try {
            $jsonParams = json_decode($request->getContent(), true);

            if (isset($jsonParams['usuario']) && !empty($jsonParams['usuario']) && isset($jsonParams['clave']) && !empty($jsonParams['clave'])) {
                $perfil = $perfilRepository->findOneBy(['usuario' => $jsonParams['usuario']]);

                if (!$perfil instanceof Perfil) {
                    $perfil = new Perfil();
                }
                $form = $this->createForm(PerfilApiType::class, $perfil);
                $form->submit($jsonParams);
                if ($form->isSubmitted() && $form->isValid()) {
                    $perfil->setNombre($perfil->getUsuario());
                    $perfil->setActivo(true);
                    $em->persist($perfil);
                    $em->flush();

                    return $this->json(['messaje' => 'OK', 'data' => $perfilRepository->listarPerfiles(['usuario' => $jsonParams['usuario']], ['id' => 'desc'], 1)]);
                }
                return $this->json(['messaje' => $form->getErrors(), 'data' => []], Response::HTTP_BAD_REQUEST);
            }
            return $this->json(['messaje' => 'Incorrect Parameter', 'data' => []], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
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
            if (isset($jsonParams['usuario']) && !empty($jsonParams['usuario']) && isset($jsonParams['clave']) && !empty($jsonParams['clave'])) {
                $perfil = $perfilRepository->findOneBy(['usuario' => $jsonParams['registrationKey']]);
                if ($perfil instanceof Perfil) {
                    $form = $this->createForm(PerfilApiType::class, $perfil);
                    $form->submit($jsonParams);
                    $em->persist($perfil);
                    $em->flush();
                    return $this->json(['messaje' => 'OK', 'data' => $perfilRepository->listarPerfiles(['usuario' => $jsonParams['usuario']], ['id' => 'desc'], 1)[0]]);
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
            if (isset($jsonParams['usuario']) && !empty($jsonParams['usuario'])) {
                $perfil = $perfilRepository->findBy(['usuario' => $jsonParams['usuario']]);
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
    public function autenticar(Request $request, PerfilRepository $perfilRepository, EntityManagerInterface $em)
    {
        try {
            $jsonParams = json_decode($request->getContent(), true);
            if (isset($jsonParams['usuario']) && !empty($jsonParams['usuario']) && isset($jsonParams['clave']) && !empty($jsonParams['clave'])) {
                $perfil = $perfilRepository->listarPerfiles(['usuario' => $jsonParams['usuario'], 'clave' => $jsonParams['clave']]);
                return $this->json(['messaje' => isset($perfil[0]) ? 'Usuario autenticado' : 'Usuario o clave incorrecto', 'data' => $perfil[0] ?? []]);
            }
            return $this->json(['messaje' => 'Incorrect Parameter', 'data' => []], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
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
    public function listarEspacios(EspacioRepository $espacioRepository, EspacioRedesSocialesRepository $espacioRedesSocialesRepository)
    {
        try {
            $result = $espacioRepository->listarEspacios(['publico' => true, 'activo' => true]);
            $response = [];
            if (is_array($result)) {
                foreach ($result as $value) {
                    $value['imagenPortada'] = !empty($value['imagenPortada']) ? $this->baseUrl . '/uploads/images/espacio/imagenPortada/' . $value['imagenPortada'] : null;
                    $value['imagenDetallada'] = !empty($value['imagenDetallada']) ? $this->baseUrl . '/uploads/images/espacio/imagenDetallada/' . $value['imagenDetallada'] : null;
                    $value['redesSociales'] = $espacioRedesSocialesRepository->listarRedesSocialesEspacios(['e.id' => $value['id']]);
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
     * @param PlatoRepository $platoRepository
     * @return JsonResponse
     */
    public function listarPlatos(PlatoRepository $platoRepository, Utils $utils)
    {
        try {
            $response = $utils->listarPlatos($platoRepository, $this->baseUrl);
            return $this->json(['messaje' => 'OK', 'data' => $response]);
        } catch (Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }

    /**
     * @Route("/plato/listar-sugerencia-chef", name="api_plato_listar-sugerencia-chef", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param PlatoRepository $platoRepository
     * @return JsonResponse
     */
    public function listarPlatosSugerenciaChef(PlatoRepository $platoRepository, Utils $utils)
    {
        try {
            $response = $utils->listarPlatos($platoRepository, $this->baseUrl, true);
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
}
