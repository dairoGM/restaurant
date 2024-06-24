<?php

namespace App\Controller\Configuracion;

use App\Entity\Configuracion\TipoMoneda;
use App\Entity\Security\User;
use App\Form\Configuracion\TipoMonedaType;
use App\Repository\Configuracion\TipoMonedaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/configuracion/tipo_moneda")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CATDOC")
 */
class TipoMonedaController extends AbstractController
{

    /**
     * @Route("/", name="app_tipo_moneda_index", methods={"GET"})
     * @param TipoMonedaRepository $tipoMonedaRepository
     * @return Response
     */
    public function index(TipoMonedaRepository $tipoMonedaRepository)
    {
        return $this->render('modules/configuracion/tipo_moneda/index.html.twig', [
            'registros' => $tipoMonedaRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
        ]);
    }

    /**
     * @Route("/registrar", name="app_tipo_moneda_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param TipoMonedaRepository $tipoMonedaRepository
     * @return Response
     */
    public function registrar(Request $request, TipoMonedaRepository $tipoMonedaRepository, SerializerInterface $serializer)
    {
        try {
            $catDocenteEntity = new TipoMoneda();
            $form = $this->createForm(TipoMonedaType::class, $catDocenteEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $tipoMonedaRepository->add($catDocenteEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_moneda_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/tipo_moneda/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_moneda_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_tipo_moneda_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $tipoMoneda
     * @param TipoMonedaRepository $tipoMonedaRepository
     * @return Response
     */
    public function modificar(Request $request, TipoMoneda $tipoMoneda, TipoMonedaRepository $tipoMonedaRepository)
    {
        try {
            $form = $this->createForm(TipoMonedaType::class, $tipoMoneda, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $tipoMonedaRepository->edit($tipoMoneda);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_moneda_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/tipo_moneda/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_moneda_modificar', ['id' => $tipoMoneda], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/detail", name="app_tipo_moneda_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param User $tipoMoneda
     * @param TipoMonedaRepository $tipoMonedaRepository
     * @return Response
     */
    public function detail(Request $request, TipoMoneda $tipoMoneda)
    {
        return $this->render('modules/configuracion/tipo_moneda/detail.html.twig', [
            'item' => $tipoMoneda,
        ]);
    }

    /**
     * @Route("/{id}/eliminar", name="app_tipo_moneda_eliminar", methods={"GET"})
     * @param Request $request
     * @param TipoMoneda $tipoMoneda
     * @param TipoMonedaRepository $tipoMonedaRepository
     * @return Response
     */
    public function eliminar(Request $request, TipoMoneda $tipoMoneda, TipoMonedaRepository $tipoMonedaRepository)
    {
        try {
            if ($tipoMonedaRepository->find($tipoMoneda) instanceof TipoMoneda) {
                $tipoMonedaRepository->remove($tipoMoneda, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_moneda_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_tipo_moneda_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_moneda_index', [], Response::HTTP_SEE_OTHER);
        }
    }

}
