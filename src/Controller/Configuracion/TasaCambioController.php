<?php

namespace App\Controller\Configuracion;

use App\Form\Configuracion\TasaCambioType;
use App\Repository\Configuracion\TasaCambioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuracion/tasa_cambio")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class TasaCambioController extends AbstractController
{

    /**
     * @Route("/", name="app_tasa_cambio_index", methods={"GET"})
     * @param TasaCambioRepository $tasaCambioRepository
     * @return Response
     */
    public function index(TasaCambioRepository $tasaCambioRepository)
    {
        return $this->render('modules/configuracion/tasa_cambio/index.html.twig', [
            'registros' => $tasaCambioRepository->findAll()
        ]);
    }

    /**
     * @Route("/tasa_cambio_guardar", name="app_tasa_cambio_guardar", methods={"GET", "POST"})
     * @param Request $request
     * @param TasaCambioRepository $tasaCambioRepository
     * @return Response
     */
    public function guardarTasaCambio(Request $request, TasaCambioRepository $tasaCambioRepository)
    {
        try {
            $allPost = $request->request->All();
            $fieldToUpdate = 'set' . ucwords($allPost['campo']);

            $tasaCambio = $tasaCambioRepository->find($allPost['id']);
            $tasaCambio->$fieldToUpdate($allPost['valor']);
            $tasaCambioRepository->edit($tasaCambio, true);
            return $this->json('OK');
        } catch (\Exception $exception) {
            return $this->json(null);
        }
    }
}
