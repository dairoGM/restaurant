<?php

namespace App\Controller\Configuracion;

use App\Controller\Configuracion\CategoriaDocenteRepository;
use App\Entity\Configuracion\Evento;
use App\Form\Configuracion\EventoType;
use App\Repository\Configuracion\EventoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuracion/evento")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class EventoController extends AbstractController
{

    /**
     * @Route("/", name="app_evento_index", methods={"GET"})
     * @param EventoRepository $eventoRepository
     * @return Response
     */
    public function index(EventoRepository $eventoRepository)
    {
        try {
            return $this->render('modules/configuracion/evento/index.html.twig', [
                'registros' => $eventoRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_evento_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_evento_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param EventoRepository $eventoRepository
     * @return Response
     */
    public function registrar(Request $request, EventoRepository $eventoRepository)
    {
        try {
            $entidad = new Evento();
            $form = $this->createForm(EventoType::class, $entidad, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $eventoRepository->add($entidad, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_evento_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/evento/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_evento_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_evento_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param Evento $evento
     * @param EventoRepository $eventoRepository
     * @return Response
     */
    public function modificar(Request $request, Evento $evento, EventoRepository $eventoRepository)
    {
        try {
            $form = $this->createForm(EventoType::class, $evento, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $eventoRepository->edit($evento);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_evento_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/evento/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_evento_modificar', ['id' => $evento], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_evento_eliminar", methods={"GET"})
     * @param Evento $evento
     * @param EventoRepository $eventoRepository
     * @return Response
     */
    public function eliminar(Evento $evento, EventoRepository $eventoRepository)
    {
        try {
            if ($eventoRepository->find($evento) instanceof Evento) {
                $eventoRepository->remove($evento, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_evento_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_evento_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_evento_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_evento_detail", methods={"GET", "POST"})
     * @param Evento $evento
     * @return Response
     */
    public function detail(Evento $evento)
    {
        return $this->render('modules/configuracion/evento/detail.html.twig', [
            'item' => $evento,
        ]);
    }
}
