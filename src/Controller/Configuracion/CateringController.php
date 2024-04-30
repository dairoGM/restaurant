<?php

namespace App\Controller\Configuracion;

use App\Controller\Configuracion\CategoriaDocenteRepository;
use App\Entity\Configuracion\Catering;
use App\Form\Configuracion\CateringType;
use App\Repository\Configuracion\CateringRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuracion/catering")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class CateringController extends AbstractController
{

    /**
     * @Route("/", name="app_catering_index", methods={"GET"})
     * @param CateringRepository $cateringRepository
     * @return Response
     */
    public function index(CateringRepository $cateringRepository)
    {
        try {
            return $this->render('modules/configuracion/catering/index.html.twig', [
                'registros' => $cateringRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_catering_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_catering_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param CateringRepository $cateringRepository
     * @return Response
     */
    public function registrar(Request $request, CateringRepository $cateringRepository)
    {
//        try {
            $entidad = new Catering();
            $form = $this->createForm(CateringType::class, $entidad, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $cateringRepository->add($entidad, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_catering_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/catering/new.html.twig', [
                'form' => $form->createView(),
            ]);
//        } catch (\Exception $exception) {
//            $this->addFlash('error', $exception->getMessage());
//            return $this->redirectToRoute('app_catering_index', [], Response::HTTP_SEE_OTHER);
//        }
    }


    /**
     * @Route("/{id}/modificar", name="app_catering_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param Catering $catering
     * @param CateringRepository $cateringRepository
     * @return Response
     */
    public function modificar(Request $request, Catering $catering, CateringRepository $cateringRepository)
    {
        try {
            $form = $this->createForm(CateringType::class, $catering, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $cateringRepository->edit($catering);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_catering_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/catering/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_catering_modificar', ['id' => $catering], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_catering_eliminar", methods={"GET"})
     * @param Catering $catering
     * @param CateringRepository $cateringRepository
     * @return Response
     */
    public function eliminar(Catering $catering, CateringRepository $cateringRepository)
    {
        try {
            if ($cateringRepository->find($catering) instanceof Catering) {
                $cateringRepository->remove($catering, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_catering_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_catering_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_catering_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_catering_detail", methods={"GET", "POST"})
     * @param Catering $catering
     * @return Response
     */
    public function detail(Catering $catering)
    {
        return $this->render('modules/configuracion/catering/detail.html.twig', [
            'item' => $catering,
        ]);
    }
}
