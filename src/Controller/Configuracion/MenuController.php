<?php

namespace App\Controller\Configuracion;

use App\Entity\Configuracion\Menu;
use App\Entity\Security\User;
use App\Form\Configuracion\MenuType;
use App\Repository\Configuracion\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/configuracion/menu")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CATDOC")
 */
class MenuController extends AbstractController
{

    /**
     * @Route("/", name="app_menu_index", methods={"GET"})
     * @param MenuRepository $menuRepository
     * @return Response
     */
    public function index(MenuRepository $menuRepository)
    {
        return $this->render('modules/configuracion/menu/index.html.twig', [
            'registros' => $menuRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
        ]);
    }

    /**
     * @Route("/registrar", name="app_menu_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param MenuRepository $menuRepository
     * @return Response
     */
    public function registrar(Request $request, MenuRepository $menuRepository)
    {
        try {
            $catDocenteEntity = new Menu();
            $form = $this->createForm(MenuType::class, $catDocenteEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $menuRepository->add($catDocenteEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/menu/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_menu_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $menu
     * @param MenuRepository $menuRepository
     * @return Response
     */
    public function modificar(Request $request, Menu $menu, MenuRepository $menuRepository)
    {
        try {
            $form = $this->createForm(MenuType::class, $menu, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $menuRepository->edit($menu);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/menu/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_menu_modificar', ['id' => $menu], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/detail", name="app_menu_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param User $menu
     * @param MenuRepository $menuRepository
     * @return Response
     */
    public function detail(Request $request, Menu $menu)
    {
        return $this->render('modules/configuracion/menu/detail.html.twig', [
            'item' => $menu,
        ]);
    }

    /**
     * @Route("/{id}/eliminar", name="app_menu_eliminar", methods={"GET"})
     * @param Menu $menu
     * @param MenuRepository $menuRepository
     * @return Response
     */
    public function eliminar(Menu $menu, MenuRepository $menuRepository)
    {
        try {
            if ($menuRepository->find($menu) instanceof Menu) {
                $menuRepository->remove($menu, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/publicar", name="app_menu_publicar", methods={"GET"})
     * @param Menu $menu
     * @param MenuRepository $menuRepository
     * @return Response
     */
    public function publicar(Menu $menu, MenuRepository $menuRepository)
    {
        try {
            if ($menuRepository->find($menu) instanceof Menu) {
                $menu->setPublico(!$menu->getPublico());
                $menuRepository->edit($menu, true);

                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
        }
    }
}
