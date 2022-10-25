<?php

namespace App\Controller\Catalogo;

use App\Entity\Catalogo\TipoRuta;
use App\Entity\Security\User;
use App\Form\Catalogo\TipoRutaType;
use App\Repository\Catalogo\TipoRutaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/catalogo/tipo_ruta")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class TipoRutaController extends AbstractController
{

    /**
     * @Route("/", name="app_tipo_ruta_index", methods={"GET"})
     * @param TipoRutaRepository $tipoRutaRepository
     * @return Response
     */
    public function index(TipoRutaRepository $tipoRutaRepository)
    {
        try {
            return $this->render('modules/catalogo/tipo_ruta/index.html.twig', [
                'registros' => $tipoRutaRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_ruta_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_tipo_ruta_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param TipoRutaRepository $tipoRutaRepository
     * @return Response
     */
    public function registrar(Request $request, TipoRutaRepository $tipoRutaRepository)
    {
        try {
            $newEntity = new TipoRuta();
            $form = $this->createForm(TipoRutaType::class, $newEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $tipoRutaRepository->add($newEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_ruta_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/tipo_ruta/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_ruta_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_tipo_ruta_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $tipoRuta
     * @param TipoRutaRepository $tipoRutaRepository
     * @return Response
     */
    public function modificar(Request $request, TipoRuta $tipoRuta, TipoRutaRepository $tipoRutaRepository)
    {
        try {
            $form = $this->createForm(TipoRutaType::class, $tipoRuta, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $tipoRutaRepository->edit($tipoRuta);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_ruta_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/tipo_ruta/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_ruta_modificar', ['id' => $tipoRuta], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_tipo_ruta_eliminar", methods={"GET"})
     * @param Request $request
     * @param TipoRuta $tipoRuta
     * @param TipoRutaRepository $tipoRutaRepository
     * @return Response
     */
    public function eliminar(Request $request, TipoRuta $tipoRuta, TipoRutaRepository $tipoRutaRepository)
    {
        try {
            if ($tipoRutaRepository->find($tipoRuta) instanceof TipoRuta) {
                $tipoRutaRepository->remove($tipoRuta, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_ruta_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_tipo_ruta_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_ruta_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_tipo_ruta_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param TipoRuta $tipoRuta
     * @return Response
     */
    public function detail(Request $request, TipoRuta $tipoRuta)
    {
        return $this->render('modules/catalogo/tipo_ruta/detail.html.twig', [
            'item' => $tipoRuta,
        ]);
    }
}
