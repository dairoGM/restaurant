<?php

namespace App\Controller\Configuracion;

use App\Form\Configuracion\DatosContactoType;
use App\Repository\Configuracion\DatosContactoRepository;
use App\Repository\Configuracion\PoliticaReservacionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuracion/politica_reservacion")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class PoliticaReservacionController extends AbstractController
{

    /**
     * @Route("/", name="app_politica_reservacion_index", methods={"GET"})
     * @param PoliticaReservacionRepository $politicaReservacionRepository
     * @return Response
     */
    public function index(PoliticaReservacionRepository $politicaReservacionRepository)
    {
        $registros = $politicaReservacionRepository->findAll();
        return $this->render('modules/configuracion/politica_reservacion/index.html.twig', [
            'registros' => $registros,
            'descripcion' => isset($registros[0]) ? $registros[0]->getDescripcion() : null
        ]);
    }

    /**
     * @Route("/politica_reservacion/guardar", name="app_politica_reservacion_guardar", methods={"GET", "POST"})
     * @param Request $request
     * @param PoliticaReservacionRepository $politicaReservacionRepository
     * @return Response
     */
    public function guardarPoliticaReservacion(Request $request, PoliticaReservacionRepository $politicaReservacionRepository)
    {
        try {
            $allPost = $request->request->All();
            $fieldToUpdate = 'set' . ucwords($allPost['campo']);

            $entidad = $politicaReservacionRepository->find($allPost['id']);
            $entidad->$fieldToUpdate($allPost['valor']);
            $politicaReservacionRepository->edit($entidad, true);
            return $this->json('OK');
        } catch (\Exception $exception) {
            return $this->json(null);
        }
    }
}
