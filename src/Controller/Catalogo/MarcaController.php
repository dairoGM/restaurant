<?php

namespace App\Controller\Catalogo;

use App\Entity\Catalogo\Marca;
use App\Entity\Security\User;
use App\Form\Catalogo\MarcaType;
use App\Repository\Catalogo\MarcaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/catalogo/marca")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CEDIS")
 */
class MarcaController extends AbstractController
{

    /**
     * @Route("/", name="app_marca_index", methods={"GET"})
     * @param MarcaRepository $marcaRepository
     * @return Response
     */
    public function index(MarcaRepository $marcaRepository)
    {
        try {
            return $this->render('modules/catalogo/marca/index.html.twig', [
                'registros' => $marcaRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_marca_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_marca_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param MarcaRepository $marcaRepository
     * @return Response
     */
    public function registrar(Request $request, MarcaRepository $marcaRepository)
    {
        try {
            $newEntity = new Marca();
            $form = $this->createForm(MarcaType::class, $newEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $marcaRepository->add($newEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_marca_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/marca/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_marca_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_marca_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $marca
     * @param MarcaRepository $marcaRepository
     * @return Response
     */
    public function modificar(Request $request, Marca $marca, MarcaRepository $marcaRepository)
    {
        try {
            $form = $this->createForm(MarcaType::class, $marca, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $marcaRepository->edit($marca);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_marca_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/marca/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_marca_modificar', ['id' => $marca], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_marca_eliminar", methods={"GET"})
     * @param Request $request
     * @param Marca $marca
     * @param MarcaRepository $marcaRepository
     * @return Response
     */
    public function eliminar(Request $request, Marca $marca, MarcaRepository $marcaRepository)
    {
        try {
            if ($marcaRepository->find($marca) instanceof Marca) {
                $marcaRepository->remove($marca, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_marca_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_marca_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_marca_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_marca_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param Marca $marca
     * @return Response
     */
    public function detail(Request $request, Marca $marca)
    {
        return $this->render('modules/catalogo/marca/detail.html.twig', [
            'item' => $marca,
        ]);
    }
}
