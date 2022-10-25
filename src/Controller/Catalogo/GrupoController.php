<?php

namespace App\Controller\Catalogo;

use App\Entity\Catalogo\Grupo;
use App\Entity\Security\User;
use App\Form\Catalogo\GrupoType;
use App\Repository\Catalogo\GrupoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/catalogo/grupo")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class GrupoController extends AbstractController
{

    /**
     * @Route("/", name="app_grupo_index", methods={"GET"})
     * @param GrupoRepository $grupoRepository
     * @return Response
     */
    public function index(GrupoRepository $grupoRepository)
    {
        try {
            return $this->render('modules/catalogo/grupo/index.html.twig', [
                'registros' => $grupoRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_grupo_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_grupo_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param GrupoRepository $grupoRepository
     * @return Response
     */
    public function registrar(Request $request, GrupoRepository $grupoRepository)
    {
        try {
            $newEntity = new Grupo();
            $form = $this->createForm(GrupoType::class, $newEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $grupoRepository->add($newEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_grupo_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/grupo/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_grupo_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_grupo_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $grupo
     * @param GrupoRepository $grupoRepository
     * @return Response
     */
    public function modificar(Request $request, Grupo $grupo, GrupoRepository $grupoRepository)
    {
//        try {
            $form = $this->createForm(GrupoType::class, $grupo, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $grupoRepository->edit($grupo);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_grupo_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/grupo/edit.html.twig', [
                'form' => $form->createView(),
            ]);
//        } catch (\Exception $exception) {
//            $this->addFlash('error', $exception->getMessage());
//            return $this->redirectToRoute('app_grupo_modificar', ['id' => $grupo], Response::HTTP_SEE_OTHER);
//        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_grupo_eliminar", methods={"GET"})
     * @param Request $request
     * @param Grupo $grupo
     * @param GrupoRepository $grupoRepository
     * @return Response
     */
    public function eliminar(Request $request, Grupo $grupo, GrupoRepository $grupoRepository)
    {
        try {
            if ($grupoRepository->find($grupo) instanceof Grupo) {
                $grupoRepository->remove($grupo, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_grupo_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_grupo_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_grupo_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_grupo_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param Grupo $grupo
     * @return Response
     */
    public function detail(Request $request, Grupo $grupo)
    {
        return $this->render('modules/catalogo/grupo/detail.html.twig', [
            'item' => $grupo,
        ]);
    }
}
