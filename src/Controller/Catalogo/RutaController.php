<?php

namespace App\Controller\Catalogo;

use App\Entity\Catalogo\Ruta;
use App\Entity\Security\User;
use App\Form\Catalogo\RutaType;
use App\Repository\Catalogo\RutaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/catalogo/ruta")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_RUTA")
 */
class RutaController extends AbstractController
{

    /**
     * @Route("/", name="app_ruta_index", methods={"GET"})
     * @param RutaRepository $rutaRepository
     * @return Response
     */
    public function index(RutaRepository $rutaRepository)
    {
        try {
            return $this->render('modules/catalogo/ruta/index.html.twig', [
                'registros' => $rutaRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_ruta_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_ruta_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param RutaRepository $rutaRepository
     * @return Response
     */
    public function registrar(Request $request, RutaRepository $rutaRepository)
    {
        try {
            $newEntity = new Ruta();
            $form = $this->createForm(RutaType::class, $newEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $rutaRepository->add($newEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_ruta_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/ruta/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_ruta_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_ruta_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $ruta
     * @param RutaRepository $rutaRepository
     * @return Response
     */
    public function modificar(Request $request, Ruta $ruta, RutaRepository $rutaRepository)
    {
        try {
            $form = $this->createForm(RutaType::class, $ruta, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $rutaRepository->edit($ruta);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_ruta_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/ruta/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_ruta_modificar', ['id' => $ruta], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_ruta_eliminar", methods={"GET"})
     * @param Request $request
     * @param Ruta $ruta
     * @param RutaRepository $rutaRepository
     * @return Response
     */
    public function eliminar(Request $request, Ruta $ruta, RutaRepository $rutaRepository)
    {
        try {
            if ($rutaRepository->find($ruta) instanceof Ruta) {
                $rutaRepository->remove($ruta, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_ruta_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_ruta_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_ruta_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_ruta_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param Ruta $ruta
     * @return Response
     */
    public function detail(Request $request, Ruta $ruta)
    {
        return $this->render('modules/catalogo/ruta/detail.html.twig', [
            'item' => $ruta,
        ]);
    }
}
