<?php

namespace App\Controller\Configuracion;

use App\Entity\Configuracion\TipoCatering;
use App\Entity\Security\User;
use App\Form\Configuracion\TipoCateringType;
use App\Repository\Configuracion\TipoCateringRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/configuracion/tipo_catering")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CATDOC")
 */
class TipoCateringController extends AbstractController
{

    /**
     * @Route("/", name="app_tipo_catering_index", methods={"GET"})
     * @param TipoCateringRepository $tipoCateringRepository
     * @return Response
     */
    public function index(TipoCateringRepository $tipoCateringRepository)
    {
        return $this->render('modules/configuracion/tipo_catering/index.html.twig', [
            'registros' => $tipoCateringRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
        ]);
    }

    /**
     * @Route("/registrar", name="app_tipo_catering_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param TipoCateringRepository $tipoCateringRepository
     * @return Response
     */
    public function registrar(Request $request, TipoCateringRepository $tipoCateringRepository, SerializerInterface $serializer)
    {
        try {
            $catDocenteEntity = new TipoCatering();
            $form = $this->createForm(TipoCateringType::class, $catDocenteEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $tipoCateringRepository->add($catDocenteEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_catering_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/tipo_catering/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_catering_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_tipo_catering_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $tipoCatering
     * @param TipoCateringRepository $tipoCateringRepository
     * @return Response
     */
    public function modificar(Request $request, TipoCatering $tipoCatering, TipoCateringRepository $tipoCateringRepository)
    {
        try {
            $form = $this->createForm(TipoCateringType::class, $tipoCatering, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $tipoCateringRepository->edit($tipoCatering);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_catering_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/tipo_catering/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_catering_modificar', ['id' => $tipoCatering], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/detail", name="app_tipo_catering_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param User $tipoCatering
     * @param TipoCateringRepository $tipoCateringRepository
     * @return Response
     */
    public function detail(Request $request, TipoCatering $tipoCatering)
    {
        return $this->render('modules/configuracion/tipo_catering/detail.html.twig', [
            'item' => $tipoCatering,
        ]);
    }

    /**
     * @Route("/{id}/eliminar", name="app_tipo_catering_eliminar", methods={"GET"})
     * @param Request $request
     * @param TipoCatering $tipoCatering
     * @param TipoCateringRepository $tipoCateringRepository
     * @return Response
     */
    public function eliminar(Request $request, TipoCatering $tipoCatering, TipoCateringRepository $tipoCateringRepository)
    {
        try {
            if ($tipoCateringRepository->find($tipoCatering) instanceof TipoCatering) {
                $tipoCateringRepository->remove($tipoCatering, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_catering_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_tipo_catering_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_catering_index', [], Response::HTTP_SEE_OTHER);
        }
    }

}
