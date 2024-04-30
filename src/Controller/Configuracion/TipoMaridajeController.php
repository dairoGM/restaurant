<?php

namespace App\Controller\Configuracion;

use App\Entity\Configuracion\TipoMaridaje;
use App\Entity\Security\User;
use App\Form\Configuracion\TipoMaridajeType;
use App\Repository\Configuracion\TipoMaridajeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/configuracion/tipo_maridaje")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CATDOC")
 */
class TipoMaridajeController extends AbstractController
{

    /**
     * @Route("/", name="app_tipo_maridaje_index", methods={"GET"})
     * @param TipoMaridajeRepository $tipoMaridajeRepository
     * @return Response
     */
    public function index(TipoMaridajeRepository $tipoMaridajeRepository)
    {
        return $this->render('modules/configuracion/tipo_maridaje/index.html.twig', [
            'registros' => $tipoMaridajeRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
        ]);
    }

    /**
     * @Route("/registrar", name="app_tipo_maridaje_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param TipoMaridajeRepository $tipoMaridajeRepository
     * @return Response
     */
    public function registrar(Request $request, TipoMaridajeRepository $tipoMaridajeRepository, SerializerInterface $serializer)
    {
        try {
            $catDocenteEntity = new TipoMaridaje();
            $form = $this->createForm(TipoMaridajeType::class, $catDocenteEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $tipoMaridajeRepository->add($catDocenteEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_maridaje_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/tipo_maridaje/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_maridaje_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_tipo_maridaje_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $tipoMaridaje
     * @param TipoMaridajeRepository $tipoMaridajeRepository
     * @return Response
     */
    public function modificar(Request $request, TipoMaridaje $tipoMaridaje, TipoMaridajeRepository $tipoMaridajeRepository)
    {
        try {
            $form = $this->createForm(TipoMaridajeType::class, $tipoMaridaje, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $tipoMaridajeRepository->edit($tipoMaridaje);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_maridaje_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/tipo_maridaje/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_maridaje_modificar', ['id' => $tipoMaridaje], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/detail", name="app_tipo_maridaje_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param User $tipoMaridaje
     * @param TipoMaridajeRepository $tipoMaridajeRepository
     * @return Response
     */
    public function detail(Request $request, TipoMaridaje $tipoMaridaje)
    {
        return $this->render('modules/configuracion/tipo_maridaje/detail.html.twig', [
            'item' => $tipoMaridaje,
        ]);
    }

    /**
     * @Route("/{id}/eliminar", name="app_tipo_maridaje_eliminar", methods={"GET"})
     * @param Request $request
     * @param TipoMaridaje $tipoMaridaje
     * @param TipoMaridajeRepository $tipoMaridajeRepository
     * @return Response
     */
    public function eliminar(Request $request, TipoMaridaje $tipoMaridaje, TipoMaridajeRepository $tipoMaridajeRepository)
    {
        try {
            if ($tipoMaridajeRepository->find($tipoMaridaje) instanceof TipoMaridaje) {
                $tipoMaridajeRepository->remove($tipoMaridaje, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_maridaje_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_tipo_maridaje_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_maridaje_index', [], Response::HTTP_SEE_OTHER);
        }
    }

}
