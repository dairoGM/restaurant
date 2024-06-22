<?php

namespace App\Controller\Configuracion;


use App\Entity\Restaurant\Contactenos;
use App\Entity\Restaurant\ReservacionMesa;
use App\Repository\Restaurant\ContactenosRepository;
use App\Repository\Restaurant\ReservacionMesaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuracion/reservacion/mesa")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class ReservacionMesaController extends AbstractController
{

    /**
     * @Route("/", name="app_reservacion_mesa_index", methods={"GET"})
     * @param ReservacionMesaRepository $reservacionMesaRepository
     * @return Response
     */
    public function index(ReservacionMesaRepository $reservacionMesaRepository)
    {
        try {
            $reservaciones = $reservacionMesaRepository->getReservaciones();
            $response = [];
            foreach ($reservaciones as $value) {
                $fechaReservacion = new \DateTime($value['fechaReservacion'] . ' ' . $value['horaFin']);
                if ($fechaReservacion < date('Y-m-d H:i:s')) {
                    $reserva = $reservacionMesaRepository->find($value['id']);
                    $reserva->setEstado('Expirada');
                    $reservacionMesaRepository->edit($reserva, true);
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
     * @param ReservacionMesa $reservacionMesa
     * @param ReservacionMesaRepository $reservacionMesaRepository
     * @return Response
     */
    public function eliminar(ReservacionMesa $reservacionMesa, ReservacionMesaRepository $reservacionMesaRepository)
    {
        try {
            if ($reservacionMesaRepository->find($reservacionMesa) instanceof ReservacionMesa) {
                $reservacionMesaRepository->remove($reservacionMesa, true);
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
     * @param ReservacionMesa $reservacionMesa
     * @param ReservacionMesaRepository $reservacionMesaRepository
     * @return Response
     */
    public function terminar(ReservacionMesa $reservacionMesa, ReservacionMesaRepository $reservacionMesaRepository)
    {
        try {
            if ($reservacionMesaRepository->find($reservacionMesa) instanceof ReservacionMesa) {
                $reservacionMesa->setEstado('Terminada');
                $reservacionMesaRepository->edit($reservacionMesa, true);
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
}
