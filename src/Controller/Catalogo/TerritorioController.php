<?php

namespace App\Controller\Catalogo;

use App\Entity\Catalogo\Territorio;
use App\Entity\Security\User;
use App\Form\Catalogo\TerritorioType;
use App\Repository\Catalogo\TerritorioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/catalogo/territorio")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_TERRITORIO")
 */
class TerritorioController extends AbstractController
{

    /**
     * @Route("/", name="app_territorio_index", methods={"GET"})
     * @param TerritorioRepository $territorioRepository
     * @return Response
     */
    public function index(TerritorioRepository $territorioRepository)
    {
        try {
            return $this->render('modules/catalogo/territorio/index.html.twig', [
                'registros' => $territorioRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_territorio_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_territorio_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param TerritorioRepository $territorioRepository
     * @return Response
     */
    public function registrar(Request $request, TerritorioRepository $territorioRepository)
    {
        try {
            $newEntity = new Territorio();
            $form = $this->createForm(TerritorioType::class, $newEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $territorioRepository->add($newEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_territorio_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/territorio/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_territorio_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_territorio_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $territorio
     * @param TerritorioRepository $territorioRepository
     * @return Response
     */
    public function modificar(Request $request, Territorio $territorio, TerritorioRepository $territorioRepository)
    {
        try {
            $form = $this->createForm(TerritorioType::class, $territorio, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $territorioRepository->edit($territorio);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_territorio_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/territorio/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_territorio_modificar', ['id' => $territorio], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_territorio_eliminar", methods={"GET"})
     * @param Request $request
     * @param Territorio $territorio
     * @param TerritorioRepository $territorioRepository
     * @return Response
     */
    public function eliminar(Request $request, Territorio $territorio, TerritorioRepository $territorioRepository)
    {
        try {
            if ($territorioRepository->find($territorio) instanceof Territorio) {
                $territorioRepository->remove($territorio, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_territorio_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_territorio_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_territorio_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_territorio_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param Territorio $territorio
     * @return Response
     */
    public function detail(Request $request, Territorio $territorio)
    {
        return $this->render('modules/catalogo/territorio/detail.html.twig', [
            'item' => $territorio,
        ]);
    }
}
