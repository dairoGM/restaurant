<?php

namespace App\Controller\Catalogo;

use App\Entity\Catalogo\TipoIdentificadorFiscal;
use App\Entity\Security\User;
use App\Form\Catalogo\TipoIdentificadorFiscalType;
use App\Repository\Catalogo\TipoIdentificadorFiscalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/catalogo/tipoIdentificadorFiscal")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class TipoIdentificadorFiscalController extends AbstractController
{

    /**
     * @Route("/", name="app_tipo_identificador_fiscal_index", methods={"GET"})
     * @param TipoIdentificadorFiscalRepository $tipoIdentificadorFiscalRepository
     * @return Response
     */
    public function index(TipoIdentificadorFiscalRepository $tipoIdentificadorFiscalRepository)
    {
        try {
            return $this->render('modules/catalogo/tipoIdentificadorFiscal/index.html.twig', [
                'registros' => $tipoIdentificadorFiscalRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_identificador_fiscal_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_tipo_identificador_fiscal_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param TipoIdentificadorFiscalRepository $tipoIdentificadorFiscalRepository
     * @return Response
     */
    public function registrar(Request $request, TipoIdentificadorFiscalRepository $tipoIdentificadorFiscalRepository)
    {
//        try {
            $newEntity = new TipoIdentificadorFiscal();
            $form = $this->createForm(TipoIdentificadorFiscalType::class, $newEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $tipoIdentificadorFiscalRepository->add($newEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_identificador_fiscal_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/tipoIdentificadorFiscal/new.html.twig', [
                'form' => $form->createView(),
            ]);
//        } catch (\Exception $exception) {
//            $this->addFlash('error', $exception->getMessage());
//            return $this->redirectToRoute('app_tipo_identificador_fiscal_registrar', [], Response::HTTP_SEE_OTHER);
//        }
    }


    /**
     * @Route("/{id}/modificar", name="app_tipo_identificador_fiscal_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $tipoIdentificadorFiscal
     * @param TipoIdentificadorFiscalRepository $tipoIdentificadorFiscalRepository
     * @return Response
     */
    public function modificar(Request $request, TipoIdentificadorFiscal $tipoIdentificadorFiscal, TipoIdentificadorFiscalRepository $tipoIdentificadorFiscalRepository)
    {
        try {
            $form = $this->createForm(TipoIdentificadorFiscalType::class, $tipoIdentificadorFiscal, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $tipoIdentificadorFiscalRepository->edit($tipoIdentificadorFiscal);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_identificador_fiscal_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/tipoIdentificadorFiscal/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_identificador_fiscal_modificar', ['id' => $tipoIdentificadorFiscal], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_tipo_identificador_fiscal_eliminar", methods={"GET"})
     * @param Request $request
     * @param TipoIdentificadorFiscal $tipoIdentificadorFiscal
     * @param TipoIdentificadorFiscalRepository $tipoIdentificadorFiscalRepository
     * @return Response
     */
    public function eliminar(Request $request, TipoIdentificadorFiscal $tipoIdentificadorFiscal, TipoIdentificadorFiscalRepository $tipoIdentificadorFiscalRepository)
    {
        try {
            if ($tipoIdentificadorFiscalRepository->find($tipoIdentificadorFiscal) instanceof TipoIdentificadorFiscal) {
                $tipoIdentificadorFiscalRepository->remove($tipoIdentificadorFiscal, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_identificador_fiscal_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_tipo_identificador_fiscal_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_identificador_fiscal_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_tipo_identificador_fiscal_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param TipoIdentificadorFiscal $tipoIdentificadorFiscal
     * @return Response
     */
    public function detail(Request $request, TipoIdentificadorFiscal $tipoIdentificadorFiscal)
    {
        return $this->render('modules/catalogo/tipoIdentificadorFiscal/detail.html.twig', [
            'item' => $tipoIdentificadorFiscal,
        ]);
    }
}
