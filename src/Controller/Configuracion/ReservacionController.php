<?php

namespace App\Controller\Configuracion;


use App\Entity\Restaurant\Contactenos;
use App\Entity\Restaurant\Reservacion;
use App\Repository\Restaurant\ContactenosRepository;
use App\Repository\Restaurant\ReservacionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuracion/reservacion")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class ReservacionController extends AbstractController
{

    /**
     * @Route("/", name="app_reservacion_mesa_index", methods={"GET"})
     * @param ReservacionRepository $reservacionRepository
     * @return Response
     */
    public function index(ReservacionRepository $reservacionRepository)
    {
        try {
            $reservaciones = $reservacionRepository->getReservaciones();
            $response = [];
            foreach ($reservaciones as $value) {
                $fechaReservacion = new \DateTime($value['fechaReservacion'] . ' ' . $value['horaFin']);
                if ($fechaReservacion < date('Y-m-d H:i:s')) {
                    $reserva = $reservacionRepository->find($value['id']);
                    $reserva->setEstado('Expirada');
                    $reservacionRepository->edit($reserva, true);
                    $value['estado'] = 'Expirada';
                }
                $response[] = $value;
            }

            return $this->render('modules/reservacion/mesa/index.html.twig', [
                'registros' => $response,
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_reservacion_mesa_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/eliminar", name="app_reservacion_mesa_eliminar", methods={"GET"})
     * @param Reservacion $reservacion
     * @param ReservacionRepository $reservacionMesaRepository
     * @return Response
     */
    public function eliminar(Reservacion $reservacion, ReservacionRepository $reservacionMesaRepository)
    {
        try {
            if ($reservacionMesaRepository->find($reservacion) instanceof Reservacion) {
                $reservacionMesaRepository->remove($reservacion, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_reservacion_mesa_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_reservacion_mesa_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_reservacion_mesa_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/terminar", name="app_reservacion_mesa_terminar", methods={"GET"})
     * @param Reservacion $reservacion
     * @param ReservacionRepository $reservacionRepository
     * @return Response
     */
    public function terminar(Reservacion $reservacion, ReservacionRepository $reservacionRepository)
    {
        try {
            if ($reservacionRepository->find($reservacion) instanceof Reservacion) {
                $reservacion->setEstado('Ejecutada');
                $reservacionRepository->edit($reservacion, true);
                $this->addFlash('success', 'El elemento ha sido modificado satisfactoriamente.');
                return $this->redirectToRoute('app_reservacion_mesa_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_reservacion_mesa_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_reservacion_mesa_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/confirmar", name="app_reservacion_mesa_confirmar", methods={"GET"})
     * @param Request $request
     * @param Reservacion $reservacion
     * @param ReservacionRepository $reservacionRepository
     * @return Response
     */
    public function confirmar(Request $request, Reservacion $reservacion, ReservacionRepository $reservacionRepository)
    {
        try {
            $numeroTransferencia = $request->query->get('numeroTransferencia');

            if ($reservacionRepository->find($reservacion) instanceof Reservacion) {
                if (strtolower($numeroTransferencia) == strtolower($reservacion->getNumeroTransferencia())) {
                    $reservacion->setEstado('Confirmada');
                    $reservacionRepository->edit($reservacion, true);
                    $this->addFlash('success', 'El elemento ha sido modificado satisfactoriamente.');
                    return $this->redirectToRoute('app_reservacion_mesa_index', [], Response::HTTP_SEE_OTHER);
                }
                $this->addFlash('error', 'El número de la transferencia no coincide con el enviado por el cliente.');
                return $this->redirectToRoute('app_reservacion_mesa_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_reservacion_mesa_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_reservacion_mesa_index', [], Response::HTTP_SEE_OTHER);
        }
    }
}
