<?php

namespace App\Controller\Catalogo;

use App\Entity\Catalogo\Sucursal;
use App\Entity\Security\User;
use App\Form\Catalogo\SucursalType;
use App\Repository\Catalogo\SucursalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/catalogo/sucursal")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CEDIS")
 */
class SucursalController extends AbstractController
{

    /**
     * @Route("/", name="app_sucursal_index", methods={"GET"})
     * @param SucursalRepository $sucursalRepository
     * @return Response
     */
    public function index(SucursalRepository $sucursalRepository)
    {
        try {
            return $this->render('modules/catalogo/sucursal/index.html.twig', [
                'registros' => $sucursalRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_sucursal_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_sucursal_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param SucursalRepository $sucursalRepository
     * @return Response
     */
    public function registrar(Request $request, SucursalRepository $sucursalRepository)
    {
//        try {
            $newEntity = new Sucursal();
            $form = $this->createForm(SucursalType::class, $newEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $sucursalRepository->add($newEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_sucursal_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/sucursal/new.html.twig', [
                'form' => $form->createView(),
            ]);
//        } catch (\Exception $exception) {
//            $this->addFlash('error', $exception->getMessage());
//            return $this->redirectToRoute('app_sucursal_registrar', [], Response::HTTP_SEE_OTHER);
//        }
    }


    /**
     * @Route("/{id}/modificar", name="app_sucursal_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $sucursal
     * @param SucursalRepository $sucursalRepository
     * @return Response
     */
    public function modificar(Request $request, Sucursal $sucursal, SucursalRepository $sucursalRepository)
    {
        try {
            $form = $this->createForm(SucursalType::class, $sucursal, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $sucursalRepository->edit($sucursal);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_sucursal_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/sucursal/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_sucursal_modificar', ['id' => $sucursal], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_sucursal_eliminar", methods={"GET"})
     * @param Request $request
     * @param Sucursal $sucursal
     * @param SucursalRepository $sucursalRepository
     * @return Response
     */
    public function eliminar(Request $request, Sucursal $sucursal, SucursalRepository $sucursalRepository)
    {
        try {
            if ($sucursalRepository->find($sucursal) instanceof Sucursal) {
                $sucursalRepository->remove($sucursal, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_sucursal_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_sucursal_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_sucursal_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_sucursal_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param Sucursal $sucursal
     * @return Response
     */
    public function detail(Request $request, Sucursal $sucursal)
    {
        return $this->render('modules/catalogo/sucursal/detail.html.twig', [
            'item' => $sucursal,
        ]);
    }
}
