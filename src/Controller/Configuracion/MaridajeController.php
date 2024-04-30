<?php

namespace App\Controller\Configuracion;

use App\Controller\Configuracion\CategoriaDocenteRepository;
use App\Entity\Configuracion\Maridaje;
use App\Form\Configuracion\MaridajeType;
use App\Repository\Configuracion\MaridajeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuracion/maridaje")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class MaridajeController extends AbstractController
{

    /**
     * @Route("/", name="app_maridaje_index", methods={"GET"})
     * @param MaridajeRepository $maridajeRepository
     * @return Response
     */
    public function index(MaridajeRepository $maridajeRepository)
    {
        try {
            return $this->render('modules/configuracion/maridaje/index.html.twig', [
                'registros' => $maridajeRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_maridaje_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_maridaje_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param MaridajeRepository $maridajeRepository
     * @return Response
     */
    public function registrar(Request $request, MaridajeRepository $maridajeRepository)
    {
        try {
            $entidad = new Maridaje();
            $form = $this->createForm(MaridajeType::class, $entidad, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $maridajeRepository->add($entidad, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_maridaje_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/maridaje/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_maridaje_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_maridaje_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param Maridaje $maridaje
     * @param MaridajeRepository $maridajeRepository
     * @return Response
     */
    public function modificar(Request $request, Maridaje $maridaje, MaridajeRepository $maridajeRepository)
    {
        try {
            $form = $this->createForm(MaridajeType::class, $maridaje, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $maridajeRepository->edit($maridaje);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_maridaje_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/maridaje/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_maridaje_modificar', ['id' => $maridaje], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_maridaje_eliminar", methods={"GET"})
     * @param Maridaje $maridaje
     * @param MaridajeRepository $maridajeRepository
     * @return Response
     */
    public function eliminar(Maridaje $maridaje, MaridajeRepository $maridajeRepository)
    {
        try {
            if ($maridajeRepository->find($maridaje) instanceof Maridaje) {
                $maridajeRepository->remove($maridaje, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_maridaje_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_maridaje_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_maridaje_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_maridaje_detail", methods={"GET", "POST"})
     * @param Maridaje $maridaje
     * @return Response
     */
    public function detail(Maridaje $maridaje)
    {
        return $this->render('modules/configuracion/maridaje/detail.html.twig', [
            'item' => $maridaje,
        ]);
    }
}
