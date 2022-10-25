<?php

namespace App\Controller\Catalogo;

use App\Entity\Catalogo\Region;
use App\Entity\Security\User;
use App\Form\Catalogo\RegionType;
use App\Repository\Catalogo\RegionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/catalogo/region")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_REGION")
 */
class RegionController extends AbstractController
{

    /**
     * @Route("/", name="app_region_index", methods={"GET"})
     * @param RegionRepository $regionRepository
     * @return Response
     */
    public function index(RegionRepository $regionRepository)
    {
        try {
            return $this->render('modules/catalogo/region/index.html.twig', [
                'registros' => $regionRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_region_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_region_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param RegionRepository $regionRepository
     * @return Response
     */
    public function registrar(Request $request, RegionRepository $regionRepository)
    {
        try {
            $newEntity = new Region();
            $form = $this->createForm(RegionType::class, $newEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $regionRepository->add($newEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_region_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/region/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_region_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_region_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $region
     * @param RegionRepository $regionRepository
     * @return Response
     */
    public function modificar(Request $request, Region $region, RegionRepository $regionRepository)
    {
        try {
            $form = $this->createForm(RegionType::class, $region, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $regionRepository->edit($region);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_region_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/region/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_region_modificar', ['id' => $region], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_region_eliminar", methods={"GET"})
     * @param Request $request
     * @param Region $region
     * @param RegionRepository $regionRepository
     * @return Response
     */
    public function eliminar(Request $request, Region $region, RegionRepository $regionRepository)
    {
        try {
            if ($regionRepository->find($region) instanceof Region) {
                $regionRepository->remove($region, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_region_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_region_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_region_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_region_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param Region $region
     * @return Response
     */
    public function detail(Request $request, Region $region)
    {
        return $this->render('modules/catalogo/region/detail.html.twig', [
            'item' => $region,
        ]);
    }
}
