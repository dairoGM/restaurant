<?php

namespace App\Controller\Notificacion;

use App\Entity\NotificacionesUsuario;
use App\Repository\NotificacionesUsuarioRepository;
use App\Repository\Planificacion\ObjetivoGeneralRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/administracion/notificaciones")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_FUNC")
 */
class GestionNotificationController extends AbstractController
{


    /**
     * @Route("/listar", name="app_notificaciones_usuario_listar", methods={"GET"})
     * @param NotificacionesUsuarioRepository $notificacionesUsuarioRepository
     * @return Response
     */
    public function listar(NotificacionesUsuarioRepository $notificacionesUsuarioRepository)
    {
        try {

            $registros = $notificacionesUsuarioRepository->findBy([], ['fechaCreado' => 'DESC']);

            return $this->render('modules/admin/notificaciones/index.html.twig', [
                'registros' => $registros
            ]);

        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
//            return $this->redirectToRoute('app_notificaciones_usuario_listar', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_notificaciones_usuario_eliminar2", methods={"GET"})
     * @param Request $request
     * @param NotificacionesUsuario $notificacionesUsuario
     * @param NotificacionesUsuarioRepository $notificacionesUsuarioRepository
     * @return Response
     */
    public function eliminar(Request $request, NotificacionesUsuario $notificacionesUsuario, NotificacionesUsuarioRepository $notificacionesUsuarioRepository)
    {
        try {
            $notificacionesUsuarioRepository->remove($notificacionesUsuario, true);
            $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
            return $this->redirectToRoute('app_notificaciones_usuario_listar', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_notificaciones_usuario_listar', [], Response::HTTP_SEE_OTHER);
        }
    }
}
