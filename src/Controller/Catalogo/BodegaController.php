<?php

namespace App\Controller\Catalogo;

use App\Entity\Catalogo\Bodega;
use App\Entity\Security\User;
use App\Form\Catalogo\BodegaType;
use App\Repository\Catalogo\BodegaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/catalogo/bodega")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CEDIS")
 */
class BodegaController extends AbstractController
{

    /**
     * @Route("/", name="app_bodega_index", methods={"GET"})
     * @param BodegaRepository $bodegaRepository
     * @return Response
     */
    public function index(BodegaRepository $bodegaRepository)
    {
        try {
            return $this->render('modules/catalogo/bodega/index.html.twig', [
                'registros' => $bodegaRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_bodega_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_bodega_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param BodegaRepository $bodegaRepository
     * @return Response
     */
    public function registrar(Request $request, BodegaRepository $bodegaRepository)
    {
        try {
            $newEntity = new Bodega();
            $form = $this->createForm(BodegaType::class, $newEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $bodegaRepository->add($newEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_bodega_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/bodega/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_bodega_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_bodega_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $bodega
     * @param BodegaRepository $bodegaRepository
     * @return Response
     */
    public function modificar(Request $request, Bodega $bodega, BodegaRepository $bodegaRepository)
    {
        try {
            $form = $this->createForm(BodegaType::class, $bodega, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $bodegaRepository->edit($bodega);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_bodega_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/bodega/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_bodega_modificar', ['id' => $bodega], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_bodega_eliminar", methods={"GET"})
     * @param Request $request
     * @param Bodega $bodega
     * @param BodegaRepository $bodegaRepository
     * @return Response
     */
    public function eliminar(Request $request, Bodega $bodega, BodegaRepository $bodegaRepository)
    {
        try {
            if ($bodegaRepository->find($bodega) instanceof Bodega) {
                $bodegaRepository->remove($bodega, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_bodega_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_bodega_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_bodega_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_bodega_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param Bodega $bodega
     * @return Response
     */
    public function detail(Request $request, Bodega $bodega)
    {
        return $this->render('modules/catalogo/bodega/detail.html.twig', [
            'item' => $bodega,
        ]);
    }
}
