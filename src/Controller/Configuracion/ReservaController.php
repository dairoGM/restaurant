<?php

namespace App\Controller\Configuracion;

use App\Controller\Configuracion\CategoriaDocenteRepository;
use App\Entity\Configuracion\Reserva;
use App\Form\Configuracion\ReservaType;
use App\Repository\Configuracion\ReservaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuracion/reserva")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class ReservaController extends AbstractController
{

    /**
     * @Route("/", name="app_reserva_index", methods={"GET"})
     * @param ReservaRepository $reservaRepository
     * @return Response
     */
    public function index(ReservaRepository $reservaRepository)
    {
        try {
            return $this->render('modules/configuracion/reserva/index.html.twig', [
                'registros' => $reservaRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_reserva_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_reserva_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param ReservaRepository $reservaRepository
     * @return Response
     */
    public function registrar(Request $request, ReservaRepository $reservaRepository)
    {
//        try {
            $entidad = new Reserva();
            $form = $this->createForm(ReservaType::class, $entidad, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $reservaRepository->add($entidad, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_reserva_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/reserva/new.html.twig', [
                'form' => $form->createView(),
            ]);
//        } catch (\Exception $exception) {
//            $this->addFlash('error', $exception->getMessage());
//            return $this->redirectToRoute('app_reserva_index', [], Response::HTTP_SEE_OTHER);
//        }
    }


    /**
     * @Route("/{id}/modificar", name="app_reserva_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param Reserva $reserva
     * @param ReservaRepository $reservaRepository
     * @return Response
     */
    public function modificar(Request $request, Reserva $reserva, ReservaRepository $reservaRepository)
    {
        try {
            $form = $this->createForm(ReservaType::class, $reserva, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $reservaRepository->edit($reserva);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_reserva_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/reserva/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_reserva_modificar', ['id' => $reserva], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_reserva_eliminar", methods={"GET"})
     * @param Reserva $reserva
     * @param ReservaRepository $reservaRepository
     * @return Response
     */
    public function eliminar(Reserva $reserva, ReservaRepository $reservaRepository)
    {
        try {
            if ($reservaRepository->find($reserva) instanceof Reserva) {
                $reservaRepository->remove($reserva, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_reserva_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_reserva_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_reserva_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_reserva_detail", methods={"GET", "POST"})
     * @param Reserva $reserva
     * @return Response
     */
    public function detail(Reserva $reserva)
    {
        return $this->render('modules/configuracion/reserva/detail.html.twig', [
            'item' => $reserva,
        ]);
    }
}
