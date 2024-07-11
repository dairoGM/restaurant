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
 * @Route("/configuracion/reservaciones_cancelada")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class ReservacionCanceladaController extends AbstractController
{

    /**
     * @Route("/", name="app_app_reservacion_cancelada_index", methods={"GET"})
     * @param ReservacionRepository $reservacionRepository
     * @return Response
     */
    public function index(ReservacionRepository $reservacionRepository)
    {
        try {
            $reservaciones = $reservacionRepository->getReservacionesCanceladas();
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

            return $this->render('modules/reservacion/canceladas/index.html.twig', [
                'registros' => $response,
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_app_reservacion_cancelada_index', [], Response::HTTP_SEE_OTHER);
        }
    }


}
