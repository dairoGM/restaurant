<?php

namespace App\Controller\Catalogo;

use App\Entity\Catalogo\Mecanica;
use App\Entity\Security\User;
use App\Form\Catalogo\MecanicaType;
use App\Repository\Catalogo\MecanicaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/catalogo/mecanica")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CEDIS")
 */
class MecanicaController extends AbstractController
{

    /**
     * @Route("/", name="app_mecanica_index", methods={"GET"})
     * @param MecanicaRepository $mecanicaRepository
     * @return Response
     */
    public function index(MecanicaRepository $mecanicaRepository)
    {
        try {
            return $this->render('modules/catalogo/mecanica/index.html.twig', [
                'registros' => $mecanicaRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_mecanica_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_mecanica_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param MecanicaRepository $mecanicaRepository
     * @return Response
     */
    public function registrar(Request $request, MecanicaRepository $mecanicaRepository)
    {
        try {
            $newEntity = new Mecanica();
            $form = $this->createForm(MecanicaType::class, $newEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $mecanicaRepository->add($newEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_mecanica_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/mecanica/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_mecanica_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_mecanica_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $mecanica
     * @param MecanicaRepository $mecanicaRepository
     * @return Response
     */
    public function modificar(Request $request, Mecanica $mecanica, MecanicaRepository $mecanicaRepository)
    {
        try {
            $form = $this->createForm(MecanicaType::class, $mecanica, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $mecanicaRepository->edit($mecanica);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_mecanica_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/mecanica/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_mecanica_modificar', ['id' => $mecanica], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_mecanica_eliminar", methods={"GET"})
     * @param Request $request
     * @param Mecanica $mecanica
     * @param MecanicaRepository $mecanicaRepository
     * @return Response
     */
    public function eliminar(Request $request, Mecanica $mecanica, MecanicaRepository $mecanicaRepository)
    {
        try {
            if ($mecanicaRepository->find($mecanica) instanceof Mecanica) {
                $mecanicaRepository->remove($mecanica, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_mecanica_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_mecanica_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_mecanica_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_mecanica_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param Mecanica $mecanica
     * @return Response
     */
    public function detail(Request $request, Mecanica $mecanica)
    {
        return $this->render('modules/catalogo/mecanica/detail.html.twig', [
            'item' => $mecanica,
        ]);
    }
}
