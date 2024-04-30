<?php

namespace App\Controller\Configuracion;

use App\Entity\Configuracion\TipoEvento;
use App\Entity\Security\User;
use App\Form\Configuracion\TipoEventoType;
use App\Repository\Configuracion\TipoEventoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/configuracion/tipo_evento")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CATDOC")
 */
class TipoEventoController extends AbstractController
{

    /**
     * @Route("/", name="app_tipo_evento_index", methods={"GET"})
     * @param TipoEventoRepository $tipoEventoRepository
     * @return Response
     */
    public function index(TipoEventoRepository $tipoEventoRepository)
    {
        return $this->render('modules/configuracion/tipo_evento/index.html.twig', [
            'registros' => $tipoEventoRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
        ]);
    }

    /**
     * @Route("/registrar", name="app_tipo_evento_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param TipoEventoRepository $tipoEventoRepository
     * @return Response
     */
    public function registrar(Request $request, TipoEventoRepository $tipoEventoRepository, SerializerInterface $serializer)
    {
        try {
            $catDocenteEntity = new TipoEvento();
            $form = $this->createForm(TipoEventoType::class, $catDocenteEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $tipoEventoRepository->add($catDocenteEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_evento_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/tipo_evento/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_evento_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_tipo_evento_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $tipoEvento
     * @param TipoEventoRepository $tipoEventoRepository
     * @return Response
     */
    public function modificar(Request $request, TipoEvento $tipoEvento, TipoEventoRepository $tipoEventoRepository)
    {
        try {
            $form = $this->createForm(TipoEventoType::class, $tipoEvento, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $tipoEventoRepository->edit($tipoEvento);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_evento_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/tipo_evento/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_evento_modificar', ['id' => $tipoEvento], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/detail", name="app_tipo_evento_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param User $tipoEvento
     * @param TipoEventoRepository $tipoEventoRepository
     * @return Response
     */
    public function detail(Request $request, TipoEvento $tipoEvento)
    {
        return $this->render('modules/configuracion/tipo_evento/detail.html.twig', [
            'item' => $tipoEvento,
        ]);
    }

    /**
     * @Route("/{id}/eliminar", name="app_tipo_evento_eliminar", methods={"GET"})
     * @param Request $request
     * @param TipoEvento $tipoEvento
     * @param TipoEventoRepository $tipoEventoRepository
     * @return Response
     */
    public function eliminar(Request $request, TipoEvento $tipoEvento, TipoEventoRepository $tipoEventoRepository)
    {
        try {
            if ($tipoEventoRepository->find($tipoEvento) instanceof TipoEvento) {
                $tipoEventoRepository->remove($tipoEvento, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_evento_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_tipo_evento_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_evento_index', [], Response::HTTP_SEE_OTHER);
        }
    }

}
