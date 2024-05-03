<?php

namespace App\Controller\Configuracion;

use App\Form\Configuracion\DatosContactoType;
use App\Repository\Configuracion\DatosContactoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuracion/datos_contacto")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class DatosContactoController extends AbstractController
{

    /**
     * @Route("/", name="app_datos_contacto_index", methods={"GET"})
     * @param DatosContactoRepository $datosContactoRepository
     * @return Response
     */
    public function index(DatosContactoRepository $datosContactoRepository)
    {
        return $this->render('modules/configuracion/datos_contacto/index.html.twig', [
            'registros' => $datosContactoRepository->findAll()
        ]);
    }

    /**
     * @Route("/datos_contacto_guardar", name="app_datos_contacto_guardar", methods={"GET", "POST"})
     * @param Request $request
     * @param DatosContactoRepository $datosContactoRepository
     * @return Response
     */
    public function guardarDatosContacto(Request $request, DatosContactoRepository $datosContactoRepository)
    {
        try {
            $allPost = $request->request->All();
            $fieldToUpdate = 'set' . ucwords($allPost['campo']);

            $datosContacto = $datosContactoRepository->find($allPost['id']);
            $datosContacto->$fieldToUpdate($allPost['valor']);
            $datosContactoRepository->edit($datosContacto, true);
            return $this->json('OK');
        } catch (\Exception $exception) {
            return $this->json(null);
        }
    }
}
