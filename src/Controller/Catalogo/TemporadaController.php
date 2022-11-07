<?php

namespace App\Controller\Catalogo;

use App\Entity\Catalogo\Temporada;
use App\Entity\Security\User;
use App\Form\Catalogo\TemporadaType;
use App\Repository\Catalogo\TemporadaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/catalogo/temporada")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CEDIS")
 */
class TemporadaController extends AbstractController
{

    /**
     * @Route("/", name="app_temporada_index", methods={"GET"})
     * @param TemporadaRepository $temporadaRepository
     * @return Response
     */
    public function index(TemporadaRepository $temporadaRepository)
    {
        try {
            return $this->render('modules/catalogo/temporada/index.html.twig', [
                'registros' => $temporadaRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_temporada_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_temporada_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param TemporadaRepository $temporadaRepository
     * @return Response
     */
    public function registrar(Request $request, TemporadaRepository $temporadaRepository)
    {
        try {
            $newEntity = new Temporada();
            $form = $this->createForm(TemporadaType::class, $newEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $newEntity->setFechaInicio(\DateTime::createFromFormat('d/m/Y', $request->request->all()['temporada']['fechaInicio']));
                $newEntity->setFechaFin(\DateTime::createFromFormat('d/m/Y', $request->request->all()['temporada']['fechaFin']));

                $temporadaRepository->add($newEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_temporada_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/temporada/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_temporada_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_temporada_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $temporada
     * @param TemporadaRepository $temporadaRepository
     * @return Response
     */
    public function modificar(Request $request, Temporada $temporada, TemporadaRepository $temporadaRepository)
    {
        try {
            $form = $this->createForm(TemporadaType::class, $temporada, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $temporada->setFechaInicio(\DateTime::createFromFormat('d/m/Y', $request->request->all()['temporada']['fechaInicio']));
                $temporada->setFechaFin(\DateTime::createFromFormat('d/m/Y', $request->request->all()['temporada']['fechaFin']));

                $temporadaRepository->edit($temporada);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_temporada_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/temporada/edit.html.twig', [
                'form' => $form->createView(),
                'temporada' =>$temporada
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_temporada_modificar', ['id' => $temporada], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_temporada_eliminar", methods={"GET"})
     * @param Request $request
     * @param Temporada $temporada
     * @param TemporadaRepository $temporadaRepository
     * @return Response
     */
    public function eliminar(Request $request, Temporada $temporada, TemporadaRepository $temporadaRepository)
    {
        try {
            if ($temporadaRepository->find($temporada) instanceof Temporada) {
                $temporadaRepository->remove($temporada, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_temporada_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_temporada_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_temporada_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_temporada_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param Temporada $temporada
     * @return Response
     */
    public function detail(Request $request, Temporada $temporada)
    {
        return $this->render('modules/catalogo/temporada/detail.html.twig', [
            'item' => $temporada,
        ]);
    }
}
