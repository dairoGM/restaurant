<?php

namespace App\Controller\Configuracion;

use App\Form\Configuracion\DatosContactoType;
use App\Repository\Configuracion\DatosContactoRepository;
use App\Repository\Configuracion\SobreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuracion/sobre")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class SobreController extends AbstractController
{

    /**
     * @Route("/", name="app_sobre_index", methods={"GET"})
     * @param SobreRepository $sobreRepository
     * @return Response
     */
    public function index(SobreRepository $sobreRepository)
    {
        $registros = $sobreRepository->findAll();
        return $this->render('modules/configuracion/sobre/index.html.twig', [
            'registros' => $sobreRepository->findAll(),
            'descripcion' => $registros[0]->getDescripcion() ?? null
        ]);
    }

    /**
     * @Route("/sobre/guardar", name="app_sobre_guardar", methods={"GET", "POST"})
     * @param Request $request
     * @param SobreRepository $sobreRepository
     * @return Response
     */
    public function guardarSobre(Request $request, SobreRepository $sobreRepository)
    {
        try {
            $allPost = $request->request->All();
            $fieldToUpdate = 'set' . ucwords($allPost['campo']);

            $datosContacto = $sobreRepository->find($allPost['id']);
            $datosContacto->$fieldToUpdate($allPost['valor']);
            $sobreRepository->edit($datosContacto, true);
            return $this->json('OK');
        } catch (\Exception $exception) {
            return $this->json(null);
        }
    }
}
