<?php

namespace App\Controller\Configuracion;

use App\Entity\Configuracion\ExperienciaGastronomica;
use App\Entity\Security\User;
use App\Form\Configuracion\ExperienciaGastronomicaType;
use App\Repository\Configuracion\ExperienciaGastronomicaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/configuracion/experiencia_gastronomica")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CATDOC")
 */
class ExperienciaGastronomicaController extends AbstractController
{

    /**
     * @Route("/", name="app_experiencia_gastronomica_index", methods={"GET"})
     * @param ExperienciaGastronomicaRepository $experienciaGastronomicaRepository
     * @return Response
     */
    public function index(ExperienciaGastronomicaRepository $experienciaGastronomicaRepository)
    {
        return $this->render('modules/configuracion/experiencia_gastronomica/index.html.twig', [
            'registros' => $experienciaGastronomicaRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
        ]);
    }

    /**
     * @Route("/registrar", name="app_experiencia_gastronomica_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param ExperienciaGastronomicaRepository $experienciaGastronomicaRepository
     * @return Response
     */
    public function registrar(Request $request, ExperienciaGastronomicaRepository $experienciaGastronomicaRepository, SerializerInterface $serializer)
    {
        try {
            $catDocenteEntity = new ExperienciaGastronomica();
            $form = $this->createForm(ExperienciaGastronomicaType::class, $catDocenteEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $experienciaGastronomicaRepository->add($catDocenteEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_experiencia_gastronomica_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/experiencia_gastronomica/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_experiencia_gastronomica_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_experiencia_gastronomica_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param ExperienciaGastronomica $experienciaGastronomica
     * @param ExperienciaGastronomicaRepository $experienciaGastronomicaRepository
     * @return Response
     */
    public function modificar(Request $request, ExperienciaGastronomica $experienciaGastronomica, ExperienciaGastronomicaRepository $experienciaGastronomicaRepository)
    {
        try {
            $form = $this->createForm(ExperienciaGastronomicaType::class, $experienciaGastronomica, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $experienciaGastronomicaRepository->edit($experienciaGastronomica);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_experiencia_gastronomica_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/experiencia_gastronomica/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_experiencia_gastronomica_modificar', ['id' => $experienciaGastronomica], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/detail", name="app_experiencia_gastronomica_detail", methods={"GET", "POST"})
     * @param ExperienciaGastronomica $tipoExperienciaGastronomica
     * @return Response
     */
    public function detail(ExperienciaGastronomica $tipoExperienciaGastronomica)
    {
        return $this->render('modules/configuracion/experiencia_gastronomica/detail.html.twig', [
            'item' => $tipoExperienciaGastronomica,
        ]);
    }

    /**
     * @Route("/{id}/eliminar", name="app_experiencia_gastronomica_eliminar", methods={"GET"})
     * @param ExperienciaGastronomica $tipoExperienciaGastronomica
     * @param ExperienciaGastronomicaRepository $experienciaGastronomicaRepository
     * @return Response
     */
    public function eliminar(ExperienciaGastronomica $tipoExperienciaGastronomica, ExperienciaGastronomicaRepository $experienciaGastronomicaRepository)
    {
        try {
            if ($experienciaGastronomicaRepository->find($tipoExperienciaGastronomica) instanceof ExperienciaGastronomica) {
                $experienciaGastronomicaRepository->remove($tipoExperienciaGastronomica, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_experiencia_gastronomica_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_experiencia_gastronomica_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_experiencia_gastronomica_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/publicar", name="app_experiencia_gastronomica_publicar", methods={"GET"})
     * @param ExperienciaGastronomica $experienciaGastronomica
     * @param ExperienciaGastronomicaRepository $experienciaGastronomicaRepository
     * @return Response
     */
    public function publicar(ExperienciaGastronomica $experienciaGastronomica, ExperienciaGastronomicaRepository $experienciaGastronomicaRepository)
    {
        try {
            if ($experienciaGastronomicaRepository->find($experienciaGastronomica) instanceof ExperienciaGastronomica) {
                $experienciaGastronomica->setPublico(!$experienciaGastronomica->getPublico());
                $experienciaGastronomicaRepository->edit($experienciaGastronomica, true);

                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_experiencia_gastronomica_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_experiencia_gastronomica_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_experiencia_gastronomica_index', [], Response::HTTP_SEE_OTHER);
        }
    }
}
