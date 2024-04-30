<?php

namespace App\Controller\Configuracion;

use App\Entity\Configuracion\TipoExperienciaGastronomica;
use App\Entity\Security\User;
use App\Form\Configuracion\TipoExperienciaGastronomicaType;
use App\Repository\Configuracion\TipoExperienciaGastronomicaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/configuracion/tipo_experiencia_gastronomica")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CATDOC")
 */
class TipoExperienciaGastronomicaController extends AbstractController
{

    /**
     * @Route("/", name="app_tipo_experiencia_gastronomica_index", methods={"GET"})
     * @param TipoExperienciaGastronomicaRepository $tipoExperienciaGastronomicaRepository
     * @return Response
     */
    public function index(TipoExperienciaGastronomicaRepository $tipoExperienciaGastronomicaRepository)
    {
        return $this->render('modules/configuracion/tipo_experiencia_gastronomica/index.html.twig', [
            'registros' => $tipoExperienciaGastronomicaRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
        ]);
    }

    /**
     * @Route("/registrar", name="app_tipo_experiencia_gastronomica_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param TipoExperienciaGastronomicaRepository $tipoExperienciaGastronomicaRepository
     * @return Response
     */
    public function registrar(Request $request, TipoExperienciaGastronomicaRepository $tipoExperienciaGastronomicaRepository, SerializerInterface $serializer)
    {
        try {
            $catDocenteEntity = new TipoExperienciaGastronomica();
            $form = $this->createForm(TipoExperienciaGastronomicaType::class, $catDocenteEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $tipoExperienciaGastronomicaRepository->add($catDocenteEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_experiencia_gastronomica_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/tipo_experiencia_gastronomica/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_experiencia_gastronomica_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_tipo_experiencia_gastronomica_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $tipoExperienciaGastronomica
     * @param TipoExperienciaGastronomicaRepository $tipoExperienciaGastronomicaRepository
     * @return Response
     */
    public function modificar(Request $request, TipoExperienciaGastronomica $tipoExperienciaGastronomica, TipoExperienciaGastronomicaRepository $tipoExperienciaGastronomicaRepository)
    {
        try {
            $form = $this->createForm(TipoExperienciaGastronomicaType::class, $tipoExperienciaGastronomica, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $tipoExperienciaGastronomicaRepository->edit($tipoExperienciaGastronomica);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_experiencia_gastronomica_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/tipo_experiencia_gastronomica/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_experiencia_gastronomica_modificar', ['id' => $tipoExperienciaGastronomica], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/detail", name="app_tipo_experiencia_gastronomica_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param User $tipoExperienciaGastronomica
     * @param TipoExperienciaGastronomicaRepository $tipoExperienciaGastronomicaRepository
     * @return Response
     */
    public function detail(Request $request, TipoExperienciaGastronomica $tipoExperienciaGastronomica)
    {
        return $this->render('modules/configuracion/tipo_experiencia_gastronomica/detail.html.twig', [
            'item' => $tipoExperienciaGastronomica,
        ]);
    }

    /**
     * @Route("/{id}/eliminar", name="app_tipo_experiencia_gastronomica_eliminar", methods={"GET"})
     * @param Request $request
     * @param TipoExperienciaGastronomica $tipoExperienciaGastronomica
     * @param TipoExperienciaGastronomicaRepository $tipoExperienciaGastronomicaRepository
     * @return Response
     */
    public function eliminar(Request $request, TipoExperienciaGastronomica $tipoExperienciaGastronomica, TipoExperienciaGastronomicaRepository $tipoExperienciaGastronomicaRepository)
    {
        try {
            if ($tipoExperienciaGastronomicaRepository->find($tipoExperienciaGastronomica) instanceof TipoExperienciaGastronomica) {
                $tipoExperienciaGastronomicaRepository->remove($tipoExperienciaGastronomica, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_experiencia_gastronomica_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_tipo_experiencia_gastronomica_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_experiencia_gastronomica_index', [], Response::HTTP_SEE_OTHER);
        }
    }

}
