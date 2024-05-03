<?php

namespace App\Controller\Configuracion;

use App\Entity\Configuracion\Menu;
use App\Entity\Configuracion\MenuPlato;
use App\Entity\Security\User;
use App\Form\Configuracion\MenuType;
use App\Repository\Configuracion\MenuPlatoRepository;
use App\Repository\Configuracion\MenuRepository;
use App\Repository\Configuracion\PlatoRepository;
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
    public function registrar(Request $request, MenuRepository $menuRepository, PlatoRepository $platoRepository, MenuPlatoRepository $menuPlatoRepository)
    {
        try {
            $entity = new Menu();
            $form = $this->createForm(MenuType::class, $entity, ['action' => 'registrar']);
            $form->handleRequest($request);
            $allPost = $request->request->All();

            if ($form->isSubmitted() && $form->isValid()) {
                $menuRepository->add($entity, true);
                if (isset($allPost['menu']['plato']) && is_array($allPost['menu']['plato'])) {
                    foreach ($allPost['menu']['plato'] as $value) {
                        $menuPlato = new MenuPlato();
                        $menuPlato->setMenu($entity);
                        $menuPlato->setPlato($platoRepository->find($value));
                        $menuPlatoRepository->add($menuPlato, true);
                    }
                }
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
    public function modificar(Request $request, Menu $menu, MenuRepository $menuRepository, PlatoRepository $platoRepository, MenuPlatoRepository $menuPlatoRepository)
    {
        try {
            $form = $this->createForm(MenuType::class, $menu, ['action' => 'modificar']);
            $form->handleRequest($request);
            $allPost = $request->request->All();
            $allMenuPlato = $menuPlatoRepository->findBy(['menu' => $menu->getId()]);

            if ($form->isSubmitted() && $form->isValid()) {
                $menuRepository->edit($menu);

                if (isset($allPost['menu']['plato']) && is_array($allPost['menu']['plato'])) {
                    if (is_array($allMenuPlato)) {
                        foreach ($allMenuPlato as $value) {
                            $menuPlatoRepository->remove($value, true);
                        }
                    }
                    foreach ($allPost['menu']['plato'] as $value) {
                        $menuPlato = new MenuPlato();
                        $menuPlato->setMenu($menu);
                        $menuPlato->setPlato($platoRepository->find($value));
                        $menuPlatoRepository->add($menuPlato, true);
                    }
                }

                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
            }
            $platosAsociados = [];
            if (is_array($allMenuPlato)) {
                foreach ($allMenuPlato as $value) {
                    $platosAsociados[] = $value->getPlato()->getId();
                }
            }

            return $this->render('modules/configuracion/menu/edit.html.twig', [
                'form' => $form->createView(),
                'platosAsociados' => implode(',', $platosAsociados)
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_menu_modificar', ['id' => $menu->getId()], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/detail", name="app_menu_detail", methods={"GET", "POST"})
     * @param Menu $menu
     * @return Response
     */
    public function detail(Menu $menu)
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
