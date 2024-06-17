<?php

namespace App\Controller\Configuracion;

use App\Entity\Configuracion\Tiempo;
use App\Form\Configuracion\DatosContactoType;
use App\Repository\Configuracion\DatosContactoRepository;
use App\Repository\Configuracion\TiempoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuracion/tiempo_reserva")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class TiempoController extends AbstractController
{

    /**
     * @Route("/", name="app_tiempo_index", methods={"GET"})
     * @param TiempoRepository $tiempoRepository
     * @return Response
     */
    public function index(TiempoRepository $tiempoRepository)
    {
        $registros = $tiempoRepository->findAll();
        return $this->render('modules/configuracion/tiempo/index.html.twig', [
            'tiempo' => isset($registros[0]) ? $registros[0]->getTiempo() : null
        ]);
    }

    /**
     * @Route("/tiempo/guardar", name="app_tiempo_guardar", methods={"GET", "POST"})
     * @param Request $request
     * @param TiempoRepository $tiempoRepository
     * @return Response
     */
    public function guardarTiempo(Request $request, TiempoRepository $tiempoRepository)
    {
        try {
            $allPost = $request->request->All();
            $all = $tiempoRepository->findAll();
            $new = new Tiempo();
            if (isset($all[0])) {
                $new = $all[0];
            }
            $new->setTiempo(intval($allPost['tiempo']) > 24 ? 24 : intval($allPost['tiempo']));
            $tiempoRepository->edit($new, true);
            return $this->json('OK');
        } catch (\Exception $exception) {
            return $this->json(null);
        }
    }
}
