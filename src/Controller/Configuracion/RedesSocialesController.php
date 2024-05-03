<?php

namespace App\Controller\Configuracion;

use App\Entity\Configuracion\RedSocial;
use App\Entity\Configuracion\Seccion;
use App\Form\Configuracion\DatosContactoType;
use App\Repository\Configuracion\DatosContactoSitioRepository;
use App\Repository\Configuracion\RedSocialRepository;
use App\Repository\Configuracion\SeccionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuracion/red_social")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class RedesSocialesController extends AbstractController
{

    /**
     * @Route("/", name="app_red_social_index", methods={"GET"})
     * @param RedSocialRepository $redSocialRepository
     * @return Response
     */
    public function index(RedSocialRepository $redSocialRepository)
    {
        return $this->render('modules/configuracion/red_social/index.html.twig', [
            'registros' => $redSocialRepository->findBy([], ['activo' => 'desc', 'id' => 'asc'])
        ]);
    }

    /**
     * @Route("/red_social/guardar", name="app_red_social_guardar", methods={"GET", "POST"})
     * @param Request $request
     * @param RedSocialRepository $redSocialRepository
     * @return Response
     */
    public function guardarRedSocial(Request $request, RedSocialRepository $redSocialRepository)
    {
        try {
            $allPost = $request->request->All();
            $redSocial = $redSocialRepository->find($allPost['id']);
            $redSocial->setEnlace($allPost['valor']);
            $redSocialRepository->edit($redSocial, true);
            return $this->json('OK');
        } catch (\Exception $exception) {
            return $this->json(null);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_red_social_eliminar", methods={"GET"})
     * @param RedSocial $redSocial
     * @param RedSocialRepository $redSocialRepository
     * @return Response
     */
    public function eliminar(RedSocial $redSocial, RedSocialRepository $redSocialRepository)
    {
        try {
            if ($redSocialRepository->find($redSocial) instanceof RedSocial) {
                $redSocial->setActivo(!$redSocial->getActivo());
                $redSocialRepository->edit($redSocial, true);
                $this->addFlash('success', 'El elemento ha sido modificado satisfactoriamente.');
                return $this->redirectToRoute('app_red_social_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_red_social_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_red_social_index', [], Response::HTTP_SEE_OTHER);
        }
    }

}
