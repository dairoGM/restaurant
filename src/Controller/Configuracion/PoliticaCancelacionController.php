<?php

namespace App\Controller\Configuracion;

use App\Form\Configuracion\DatosContactoType;
use App\Repository\Configuracion\DatosContactoRepository;
use App\Repository\Configuracion\PoliticaCancelacionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuracion/politica_cancelacion")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class PoliticaCancelacionController extends AbstractController
{

    /**
     * @Route("/", name="app_politica_cancelacion_index", methods={"GET"})
     * @param PoliticaCancelacionRepository $politicaCancelacionRepository
     * @return Response
     */
    public function index(PoliticaCancelacionRepository $politicaCancelacionRepository)
    {
        $registros = $politicaCancelacionRepository->findAll();
        return $this->render('modules/configuracion/politica_cancelacion/index.html.twig', [
            'registros' => $registros,
            'descripcion' => isset($registros[0]) ? $registros[0]->getDescripcion() : null
        ]);
    }

    /**
     * @Route("/politica_cancelacion/guardar", name="app_politica_cancelacion_guardar", methods={"GET", "POST"})
     * @param Request $request
     * @param PoliticaCancelacionRepository $politicaCancelacionRepository
     * @return Response
     */
    public function guardarPoliticaCancelacion(Request $request, PoliticaCancelacionRepository $politicaCancelacionRepository)
    {
        try {
            $allPost = $request->request->All();
            $fieldToUpdate = 'set' . ucwords($allPost['campo']);

            $entidad = $politicaCancelacionRepository->find($allPost['id']);
            $entidad->$fieldToUpdate($allPost['valor']);
            $politicaCancelacionRepository->edit($entidad, true);
            return $this->json('OK');
        } catch (\Exception $exception) {
            return $this->json(null);
        }
    }
}
