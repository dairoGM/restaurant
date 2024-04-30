<?php

namespace App\Controller\Configuracion;

use App\Entity\Configuracion\TipoExperienciaCulinaria;
use App\Entity\Security\User;
use App\Form\Configuracion\TipoExperienciaCulinariaType;
use App\Repository\Configuracion\TipoExperienciaCulinariaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/configuracion/tipo_experiencia_culinaria")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CATDOC")
 */
class TipoExperienciaCulinariaController extends AbstractController
{

    /**
     * @Route("/", name="app_tipo_experiencia_culinaria_index", methods={"GET"})
     * @param TipoExperienciaCulinariaRepository $tipoExperienciaCulinariaRepository
     * @return Response
     */
    public function index(TipoExperienciaCulinariaRepository $tipoExperienciaCulinariaRepository)
    {
        return $this->render('modules/configuracion/tipo_experiencia_culinaria/index.html.twig', [
            'registros' => $tipoExperienciaCulinariaRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
        ]);
    }

    /**
     * @Route("/registrar", name="app_tipo_experiencia_culinaria_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param TipoExperienciaCulinariaRepository $tipoExperienciaCulinariaRepository
     * @return Response
     */
    public function registrar(Request $request, TipoExperienciaCulinariaRepository $tipoExperienciaCulinariaRepository, SerializerInterface $serializer)
    {
        try {
            $catDocenteEntity = new TipoExperienciaCulinaria();
            $form = $this->createForm(TipoExperienciaCulinariaType::class, $catDocenteEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $tipoExperienciaCulinariaRepository->add($catDocenteEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_experiencia_culinaria_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/tipo_experiencia_culinaria/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_experiencia_culinaria_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_tipo_experiencia_culinaria_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $tipoExperienciaCulinaria
     * @param TipoExperienciaCulinariaRepository $tipoExperienciaCulinariaRepository
     * @return Response
     */
    public function modificar(Request $request, TipoExperienciaCulinaria $tipoExperienciaCulinaria, TipoExperienciaCulinariaRepository $tipoExperienciaCulinariaRepository)
    {
        try {
            $form = $this->createForm(TipoExperienciaCulinariaType::class, $tipoExperienciaCulinaria, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $tipoExperienciaCulinariaRepository->edit($tipoExperienciaCulinaria);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_experiencia_culinaria_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/tipo_experiencia_culinaria/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_experiencia_culinaria_modificar', ['id' => $tipoExperienciaCulinaria], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/detail", name="app_tipo_experiencia_culinaria_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param User $tipoExperienciaCulinaria
     * @param TipoExperienciaCulinariaRepository $tipoExperienciaCulinariaRepository
     * @return Response
     */
    public function detail(Request $request, TipoExperienciaCulinaria $tipoExperienciaCulinaria)
    {
        return $this->render('modules/configuracion/tipo_experiencia_culinaria/detail.html.twig', [
            'item' => $tipoExperienciaCulinaria,
        ]);
    }

    /**
     * @Route("/{id}/eliminar", name="app_tipo_experiencia_culinaria_eliminar", methods={"GET"})
     * @param Request $request
     * @param TipoExperienciaCulinaria $tipoExperienciaCulinaria
     * @param TipoExperienciaCulinariaRepository $tipoExperienciaCulinariaRepository
     * @return Response
     */
    public function eliminar(Request $request, TipoExperienciaCulinaria $tipoExperienciaCulinaria, TipoExperienciaCulinariaRepository $tipoExperienciaCulinariaRepository)
    {
        try {
            if ($tipoExperienciaCulinariaRepository->find($tipoExperienciaCulinaria) instanceof TipoExperienciaCulinaria) {
                $tipoExperienciaCulinariaRepository->remove($tipoExperienciaCulinaria, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_experiencia_culinaria_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_tipo_experiencia_culinaria_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_experiencia_culinaria_index', [], Response::HTTP_SEE_OTHER);
        }
    }

}
