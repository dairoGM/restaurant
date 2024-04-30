<?php

namespace App\Controller\Api;

use App\Repository\Configuracion\CateringRepository;
use App\Repository\Configuracion\EventoRepository;
use App\Repository\Configuracion\MaridajeRepository;
use App\Repository\Configuracion\PortadaRepository;
use App\Repository\Configuracion\ServicioRepository;
use App\Repository\Estructura\CategoriaEstructuraRepository;
use App\Repository\Estructura\EstructuraRepository;
use App\Repository\Institucion\InstitucionEditorialRepository;
use App\Repository\Institucion\InstitucionRepository;
use App\Repository\Institucion\InstitucionRevistaCientificaRepository;
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
            $result = $eventoRepository->listarEventos();
            return $this->json($result);
        } catch (Exception $exc) {
            return $this->json($exc->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * @Route("/maridajes/listar", name="api_maridajes_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param MaridajeRepository $maridajeRepository
     * @return JsonResponse
     */
    public function listarMaridajes(MaridajeRepository $maridajeRepository)
    {
        try {
            $result = $maridajeRepository->listarMaridajes();
            return $this->json($result);
        } catch (Exception $exc) {
            return $this->json($exc->getMessage(), Response::HTTP_FORBIDDEN);
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
            $result = $cateringRepository->listarCatering();
            return $this->json($result);
        } catch (Exception $exc) {
            return $this->json($exc->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * @Route("/servicios/publicos/listar", name="api_servicios_publicos_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param ServicioRepository $servicioRepository
     * @return JsonResponse
     */
    public function listarServiciosPublicos(ServicioRepository $servicioRepository)
    {
        try {
            $result = $servicioRepository->listarServiciosPublicos();
            $response = [];
            if (is_array($result)) {
                foreach ($result as $value) {
                    $value['imagenPortada'] = $this->baseUrl . "/uploads/images/servicio/imagenPortada/" . $value['imagenPortada'];
                    $value['imagenDetallada'] = $this->baseUrl . "/uploads/images/servicio/imagenDetallada/" . $value['imagenDetallada'];
                    $response[] = $value;
                }
            }
            return $this->json($response);
        } catch (Exception $exc) {
            return $this->json($exc->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * @Route("/portada/listar", name="api_portada_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param ServicioRepository $portadaRepository
     * @return JsonResponse
     */
    public function listarPortadas(PortadaRepository $portadaRepository)
    {
        try {
            $result = $portadaRepository->listarPortadas();
            $response = [];
            if (is_array($result)) {
                foreach ($result as $value) {
                    $value['imagen'] = $this->baseUrl . "/uploads/images/portada?web/imagen/" . $value['imagen'];
                    $response[] = $value;
                }
            }
            return $this->json($response);
        } catch (Exception $exc) {
            return $this->json($exc->getMessage(), Response::HTTP_FORBIDDEN);
        }
    }
}
