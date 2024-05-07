<?php

namespace App\Controller\Configuracion;

use App\Form\Configuracion\DatosContactoType;
use App\Repository\Configuracion\DatosContactoRepository;
use App\Repository\Configuracion\TerminosCondicionesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuracion/terminos_condiciones")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class TerminosCondicionesController extends AbstractController
{

    /**
     * @Route("/", name="app_terminos_condiciones_index", methods={"GET"})
     * @param TerminosCondicionesRepository $terminosCondicionesRepository
     * @return Response
     */
    public function index(TerminosCondicionesRepository $terminosCondicionesRepository)
    {
        return $this->render('modules/configuracion/terminos_condiciones/index.html.twig', [
            'registros' => $terminosCondicionesRepository->findAll()
        ]);
    }

    /**
     * @Route("/terminos_condiciones/guardar", name="app_terminos_condiciones_guardar", methods={"GET", "POST"})
     * @param Request $request
     * @param TerminosCondicionesRepository $terminosCondicionesRepository
     * @return Response
     */
    public function guardarTerminosCondiciones(Request $request, TerminosCondicionesRepository $terminosCondicionesRepository)
    {
        try {
            $allPost = $request->request->All();
            $fieldToUpdate = 'set' . ucwords($allPost['campo']);

            $datosContacto = $terminosCondicionesRepository->find($allPost['id']);
            $datosContacto->$fieldToUpdate($allPost['valor']);
            $terminosCondicionesRepository->edit($datosContacto, true);
            return $this->json('OK');
        } catch (\Exception $exception) {
            return $this->json(null);
        }
    }
}
