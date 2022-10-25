<?php

namespace App\Controller\Catalogo;

use App\Entity\Catalogo\Cedis;
use App\Entity\Security\User;
use App\Form\Catalogo\CedisType;
use App\Repository\Catalogo\CedisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/catalogo/cedis")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CEDIS")
 */
class CedisController extends AbstractController
{

    /**
     * @Route("/", name="app_cedis_index", methods={"GET"})
     * @param CedisRepository $cedisRepository
     * @return Response
     */
    public function index(CedisRepository $cedisRepository)
    {
        try {
            return $this->render('modules/catalogo/cedis/index.html.twig', [
                'registros' => $cedisRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_cedis_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_cedis_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param CedisRepository $cedisRepository
     * @return Response
     */
    public function registrar(Request $request, CedisRepository $cedisRepository)
    {
        try {
            $newEntity = new Cedis();
            $form = $this->createForm(CedisType::class, $newEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $cedisRepository->add($newEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_cedis_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/cedis/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_cedis_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_cedis_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $cedis
     * @param CedisRepository $cedisRepository
     * @return Response
     */
    public function modificar(Request $request, Cedis $cedis, CedisRepository $cedisRepository)
    {
        try {
            $form = $this->createForm(CedisType::class, $cedis, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $cedisRepository->edit($cedis);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_cedis_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/cedis/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_cedis_modificar', ['id' => $cedis], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_cedis_eliminar", methods={"GET"})
     * @param Request $request
     * @param Cedis $cedis
     * @param CedisRepository $cedisRepository
     * @return Response
     */
    public function eliminar(Request $request, Cedis $cedis, CedisRepository $cedisRepository)
    {
        try {
            if ($cedisRepository->find($cedis) instanceof Cedis) {
                $cedisRepository->remove($cedis, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_cedis_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_cedis_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_cedis_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_cedis_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param Cedis $cedis
     * @return Response
     */
    public function detail(Request $request, Cedis $cedis)
    {
        return $this->render('modules/catalogo/cedis/detail.html.twig', [
            'item' => $cedis,
        ]);
    }
}
