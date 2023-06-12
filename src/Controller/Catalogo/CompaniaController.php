<?php

namespace App\Controller\Catalogo;

use App\Entity\Catalogo\Compania;
use App\Entity\Security\User;
use App\Form\Catalogo\CompaniaType;
use App\Repository\Catalogo\CompaniaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/catalogo/compania")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CEDIS")
 */
class CompaniaController extends AbstractController
{

    /**
     * @Route("/", name="app_compania_index", methods={"GET"})
     * @param CompaniaRepository $companiaRepository
     * @return Response
     */
    public function index(CompaniaRepository $companiaRepository)
    {
        try {
            return $this->render('modules/catalogo/compania/index.html.twig', [
                'registros' => $companiaRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_compania_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_compania_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param CompaniaRepository $companiaRepository
     * @return Response
     */
    public function registrar(Request $request, CompaniaRepository $companiaRepository)
    {
        try {
            $newEntity = new Compania();
            $form = $this->createForm(CompaniaType::class, $newEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $companiaRepository->add($newEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_compania_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/compania/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_compania_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_compania_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $compania
     * @param CompaniaRepository $companiaRepository
     * @return Response
     */
    public function modificar(Request $request, Compania $compania, CompaniaRepository $companiaRepository)
    {
        try {
            $form = $this->createForm(CompaniaType::class, $compania, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $companiaRepository->edit($compania);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_compania_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/compania/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_compania_modificar', ['id' => $compania], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_compania_eliminar", methods={"GET"})
     * @param Request $request
     * @param Compania $compania
     * @param CompaniaRepository $companiaRepository
     * @return Response
     */
    public function eliminar(Request $request, Compania $compania, CompaniaRepository $companiaRepository)
    {
        try {
            if ($companiaRepository->find($compania) instanceof Compania) {
                $companiaRepository->remove($compania, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_compania_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_compania_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_compania_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_compania_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param Compania $compania
     * @return Response
     */
    public function detail(Request $request, Compania $compania)
    {
        return $this->render('modules/catalogo/compania/detail.html.twig', [
            'item' => $compania,
        ]);
    }
}
