<?php

namespace App\Controller\Catalogo;

use App\Entity\Catalogo\Banco;
use App\Entity\Security\User;
use App\Form\Catalogo\BancoType;
use App\Repository\Catalogo\BancoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/catalogo/banco")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CEDIS")
 */
class BancoController extends AbstractController
{

    /**
     * @Route("/", name="app_banco_index", methods={"GET"})
     * @param BancoRepository $bancoRepository
     * @return Response
     */
    public function index(BancoRepository $bancoRepository)
    {
        try {
            return $this->render('modules/catalogo/banco/index.html.twig', [
                'registros' => $bancoRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_banco_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_banco_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param BancoRepository $bancoRepository
     * @return Response
     */
    public function registrar(Request $request, BancoRepository $bancoRepository)
    {
//        try {
            $newEntity = new Banco();
            $form = $this->createForm(BancoType::class, $newEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $bancoRepository->add($newEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_banco_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/banco/new.html.twig', [
                'form' => $form->createView(),
            ]);
//        } catch (\Exception $exception) {
//            $this->addFlash('error', $exception->getMessage());
//            return $this->redirectToRoute('app_banco_registrar', [], Response::HTTP_SEE_OTHER);
//        }
    }


    /**
     * @Route("/{id}/modificar", name="app_banco_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $banco
     * @param BancoRepository $bancoRepository
     * @return Response
     */
    public function modificar(Request $request, Banco $banco, BancoRepository $bancoRepository)
    {
        try {
            $form = $this->createForm(BancoType::class, $banco, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $bancoRepository->edit($banco);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_banco_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/banco/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_banco_modificar', ['id' => $banco], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_banco_eliminar", methods={"GET"})
     * @param Request $request
     * @param Banco $banco
     * @param BancoRepository $bancoRepository
     * @return Response
     */
    public function eliminar(Request $request, Banco $banco, BancoRepository $bancoRepository)
    {
        try {
            if ($bancoRepository->find($banco) instanceof Banco) {
                $bancoRepository->remove($banco, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_banco_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_banco_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_banco_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_banco_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param Banco $banco
     * @return Response
     */
    public function detail(Request $request, Banco $banco)
    {
        return $this->render('modules/catalogo/banco/detail.html.twig', [
            'item' => $banco,
        ]);
    }
}
