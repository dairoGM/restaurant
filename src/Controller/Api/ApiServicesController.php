<?php

namespace App\Controller\Api;

use App\Entity\Restaurant\Contactenos;
use App\Entity\Restaurant\Perfil;
use App\Form\Restaurant\ContactenosApiType;
use App\Form\Restaurant\PerfilApiType;
use App\Form\Restaurant\PerfilType;
use App\Repository\Configuracion\CateringRepository;
use App\Repository\Configuracion\DatosContactoRepository;
use App\Repository\Configuracion\EspacioRedesSocialesRepository;
use App\Repository\Configuracion\EspacioRepository;
use App\Repository\Configuracion\EventoRepository;
use App\Repository\Configuracion\ExperienciaCulinariaRepository;
use App\Repository\Configuracion\ExperienciaGastronomicaRepository;
use App\Repository\Configuracion\MaridajeRepository;
use App\Repository\Configuracion\MenuRepository;
use App\Repository\Configuracion\PortadaRepository;
use App\Repository\Configuracion\ReservaRepository;
use App\Repository\Configuracion\ServicioRepository;
use App\Repository\Configuracion\SobreRepository;
use App\Repository\Estructura\CategoriaEstructuraRepository;
use App\Repository\Estructura\EstructuraRepository;
use App\Repository\Institucion\InstitucionEditorialRepository;
use App\Repository\Institucion\InstitucionRepository;
use App\Repository\Institucion\InstitucionRevistaCientificaRepository;
use App\Repository\Restaurant\ContactenosRepository;
use App\Repository\Restaurant\PerfilRepository;
use App\Services\Utils;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ApiServicesController extends AbstractController
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
        try {
            $result = $eventoRepository->listarEventos(['activo'=>true]);
            return $this->json(['messaje' => 'OK', 'data' => $result]);
        } catch (Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }

    /**
     * @Route("/maridaje/listar", name="api_maridajes_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param MaridajeRepository $maridajeRepository
     * @return JsonResponse
     */
    public function listarMaridajes(MaridajeRepository $maridajeRepository)
    {
        try {
            $result = $maridajeRepository->listarMaridajes(['activo'=>true]);
            return $this->json(['messaje' => 'OK', 'data' => $result]);
        } catch (Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }

    /**
     * @Route("/catering/listar", name="api_catering_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param CateringRepository $cateringRepository
     * @return JsonResponse
     */
    public function listarCatering(CateringRepository $cateringRepository)
    {
        try {
            $result = $cateringRepository->listarCatering(['activo'=>true]);
            return $this->json(['messaje' => 'OK', 'data' => $result]);
        } catch (Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }

    /**
     * @Route("/servicio/listar", name="api_servicio_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param ServicioRepository $servicioRepository
     * @return JsonResponse
     */
    public function listarServiciosPublicos(ServicioRepository $servicioRepository)
    {
        try {
            $result = $servicioRepository->listarServicios(['publico'=>true, 'activo'=>true]);
            $response = [];
            if (is_array($result)) {
                foreach ($result as $value) {
                    $value['imagenPortada'] = $this->baseUrl . "/uploads/images/servicio/imagenPortada/" . $value['imagenPortada'];
                    $value['imagenDetallada'] = $this->baseUrl . "/uploads/images/servicio/imagenDetallada/" . $value['imagenDetallada'];
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
            $result = $portadaRepository->listarPortadas(['publico'=>true, 'activo'=>true]);
            $response = [];
            if (is_array($result)) {
                foreach ($result as $value) {
                    $value['imagen'] = $this->baseUrl . "/uploads/images/portada?web/imagen/" . $value['imagen'];
                    $response[] = $value;
                }
            }
            return $this->json(['messaje' => 'OK', 'data' => $response]);
        } catch (Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }


    /**
     * @Route("/experiencia_gastronomica/publicos/listar", name="api_experiencia_gastronomica_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param ExperienciaGastronomicaRepository $experienciaGastronomicaRepository
     * @return JsonResponse
     */
    public function listarExperienciaGastronomica(ExperienciaGastronomicaRepository $experienciaGastronomicaRepository)
    {
        try {
            $result = $experienciaGastronomicaRepository->listarExperienciaGastronomica(['publico'=>true]);
            return $this->json(['messaje' => 'OK', 'data' => $result]);
        } catch (Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }

    /**
     * @Route("/experiencia_culinaria/publicos/listar", name="api_experiencia_culinaria_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param ExperienciaCulinariaRepository $experienciaCulinariaRepository
     * @return JsonResponse
     */
    public function listarExperienciaCulinaria(ExperienciaCulinariaRepository $experienciaCulinariaRepository)
    {
        try {
            $result = $experienciaCulinariaRepository->listarExperienciaCulinaria(['publico'=>true]);
            return $this->json(['messaje' => 'OK', 'data' => $result]);
        } catch (Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => null], Response::HTTP_BAD_GATEWAY);
        }
    }


    /**
     * @Route("/menu/listar", name="api_menu_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param MenuRepository $menuRepository
     * @return JsonResponse
     */
    public function listarMenu(MenuRepository $menuRepository)
    {
        try {
            $result = $menuRepository->listarMenus(['publico' => true]);
            return $this->json(['messaje' => 'OK', 'data' => $result]);
        } catch (Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
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
     * @Route("/espacio/listar", name="api_espacio_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param EspacioRepository $espacioRepository
     * @param EspacioRedesSocialesRepository $espacioRedesSocialesRepository
     * @return JsonResponse
     */
    public function listarEspacios(EspacioRepository $espacioRepository, EspacioRedesSocialesRepository $espacioRedesSocialesRepository)
    {
        try {
            $result = $espacioRepository->listarEspaciosPublicos(['publico' => true, 'activo' => true]);
            $response = [];
            if (is_array($result)) {
                foreach ($result as $value) {
                    $value['redes_sociales'] = $espacioRedesSocialesRepository->listarRedesSocialesEspacios(['e.id' => $value['id']]);
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
}
