<?php

namespace App\Controller\Configuracion;


use App\Entity\Restaurant\Contactenos;
use App\Repository\Restaurant\ContactenosRepository;
use App\Repository\Restaurant\ReservacionMesaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/reservacion/mesa")
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
                $value['fechaReservacion'] = date_format($value['fechaReservacion'], 'Y-m-d H:i:s');
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
     * @Route("/{id}/eliminar", name="app_contactenos_eliminar", methods={"GET"})
     * @param Contactenos $contactenos
     * @param ContactenosRepository $contactenosRepository
     * @return Response
     */
    public function eliminar(Contactenos $contactenos, ContactenosRepository $contactenosRepository)
    {
        try {
            if ($contactenosRepository->find($contactenos) instanceof Contactenos) {
                $contactenosRepository->remove($contactenos, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_contactenos_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_contactenos_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_contactenos_index', [], Response::HTTP_SEE_OTHER);
        }
    }

}
