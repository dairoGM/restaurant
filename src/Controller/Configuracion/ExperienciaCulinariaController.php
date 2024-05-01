<?php

namespace App\Controller\Configuracion;

use App\Entity\Configuracion\ExperienciaCulinaria;
use App\Entity\Security\User;
use App\Form\Configuracion\ExperienciaCulinariaType;
use App\Repository\Configuracion\ExperienciaCulinariaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/configuracion/experiencia_culinaria")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CATDOC")
 */
class ExperienciaCulinariaController extends AbstractController
{

    /**
     * @Route("/", name="app_experiencia_culinaria_index", methods={"GET"})
     * @param ExperienciaCulinariaRepository $experienciaCulinariaRepository
     * @return Response
     */
    public function index(ExperienciaCulinariaRepository $experienciaCulinariaRepository)
    {
        return $this->render('modules/configuracion/experiencia_culinaria/index.html.twig', [
            'registros' => $experienciaCulinariaRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
        ]);
    }

    /**
     * @Route("/registrar", name="app_experiencia_culinaria_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param ExperienciaCulinariaRepository $experienciaCulinariaRepository
     * @return Response
     */
    public function registrar(Request $request, ExperienciaCulinariaRepository $experienciaCulinariaRepository)
    {
        try {
            $entidad = new ExperienciaCulinaria();
            $form = $this->createForm(ExperienciaCulinariaType::class, $entidad, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $experienciaCulinariaRepository->add($entidad, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_experiencia_culinaria_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/experiencia_culinaria/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_experiencia_culinaria_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_experiencia_culinaria_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param ExperienciaCulinaria $experienciaCulinaria
     * @param ExperienciaCulinariaRepository $experienciaCulinariaRepository
     * @return Response
     */
    public function modificar(Request $request, ExperienciaCulinaria $experienciaCulinaria, ExperienciaCulinariaRepository $experienciaCulinariaRepository)
    {
        try {
            $form = $this->createForm(ExperienciaCulinariaType::class, $experienciaCulinaria, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $experienciaCulinariaRepository->edit($experienciaCulinaria);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_experiencia_culinaria_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/experiencia_culinaria/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_experiencia_culinaria_modificar', ['id' => $experienciaCulinaria], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/detail", name="app_experiencia_culinaria_detail", methods={"GET", "POST"})
     * @param ExperienciaCulinaria $tipoExperienciaCulinaria
     * @return Response
     */
    public function detail(ExperienciaCulinaria $tipoExperienciaCulinaria)
    {
        return $this->render('modules/configuracion/experiencia_culinaria/detail.html.twig', [
            'item' => $tipoExperienciaCulinaria,
        ]);
    }

    /**
     * @Route("/{id}/eliminar", name="app_experiencia_culinaria_eliminar", methods={"GET"})
     * @param ExperienciaCulinaria $tipoExperienciaCulinaria
     * @param ExperienciaCulinariaRepository $experienciaCulinariaRepository
     * @return Response
     */
    public function eliminar(ExperienciaCulinaria $tipoExperienciaCulinaria, ExperienciaCulinariaRepository $experienciaCulinariaRepository)
    {
        try {
            if ($experienciaCulinariaRepository->find($tipoExperienciaCulinaria) instanceof ExperienciaCulinaria) {
                $experienciaCulinariaRepository->remove($tipoExperienciaCulinaria, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_experiencia_culinaria_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_experiencia_culinaria_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_experiencia_culinaria_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/publicar", name="app_experiencia_culinaria_publicar", methods={"GET"})
     * @param ExperienciaCulinaria $experienciaCulinaria
     * @param ExperienciaCulinariaRepository $experienciaCulinariaRepository
     * @return Response
     */
    public function publicar(ExperienciaCulinaria $experienciaCulinaria, ExperienciaCulinariaRepository $experienciaCulinariaRepository)
    {
        try {
            if ($experienciaCulinariaRepository->find($experienciaCulinaria) instanceof ExperienciaCulinaria) {
                $experienciaCulinaria->setPublico(!$experienciaCulinaria->getPublico());
                $experienciaCulinariaRepository->edit($experienciaCulinaria, true);

                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_experiencia_culinaria_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_experiencia_culinaria_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_experiencia_culinaria_index', [], Response::HTTP_SEE_OTHER);
        }
    }
}
