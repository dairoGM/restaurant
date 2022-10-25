<?php

namespace App\Controller\Catalogo;

use App\Entity\Catalogo\ClasificacionRuta;
use App\Entity\Security\User;
use App\Form\Catalogo\ClasificacionRutaType;
use App\Repository\Catalogo\ClasificacionRutaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/catalogo/clasificacion_ruta")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class ClasificacionRutaController extends AbstractController
{

    /**
     * @Route("/", name="app_clasificacion_ruta_index", methods={"GET"})
     * @param ClasificacionRutaRepository $clasificacionRutaRepository
     * @return Response
     */
    public function index(ClasificacionRutaRepository $clasificacionRutaRepository)
    {
        try {
            return $this->render('modules/catalogo/clasificacion_ruta/index.html.twig', [
                'registros' => $clasificacionRutaRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_clasificacion_ruta_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_clasificacion_ruta_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param ClasificacionRutaRepository $clasificacionRutaRepository
     * @return Response
     */
    public function registrar(Request $request, ClasificacionRutaRepository $clasificacionRutaRepository)
    {
        try {
            $newEntity = new ClasificacionRuta();
            $form = $this->createForm(ClasificacionRutaType::class, $newEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $clasificacionRutaRepository->add($newEntity, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_clasificacion_ruta_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/clasificacion_ruta/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_clasificacion_ruta_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_clasificacion_ruta_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param User $clasificacionRuta
     * @param ClasificacionRutaRepository $clasificacionRutaRepository
     * @return Response
     */
    public function modificar(Request $request, ClasificacionRuta $clasificacionRuta, ClasificacionRutaRepository $clasificacionRutaRepository)
    {
        try {
            $form = $this->createForm(ClasificacionRutaType::class, $clasificacionRuta, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $clasificacionRutaRepository->edit($clasificacionRuta);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_clasificacion_ruta_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/clasificacion_ruta/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_clasificacion_ruta_modificar', ['id' => $clasificacionRuta], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_clasificacion_ruta_eliminar", methods={"GET"})
     * @param Request $request
     * @param ClasificacionRuta $clasificacionRuta
     * @param ClasificacionRutaRepository $clasificacionRutaRepository
     * @return Response
     */
    public function eliminar(Request $request, ClasificacionRuta $clasificacionRuta, ClasificacionRutaRepository $clasificacionRutaRepository)
    {
        try {
            if ($clasificacionRutaRepository->find($clasificacionRuta) instanceof ClasificacionRuta) {
                $clasificacionRutaRepository->remove($clasificacionRuta, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_clasificacion_ruta_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_clasificacion_ruta_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_clasificacion_ruta_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_clasificacion_ruta_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param ClasificacionRuta $clasificacionRuta
     * @return Response
     */
    public function detail(Request $request, ClasificacionRuta $clasificacionRuta)
    {
        return $this->render('modules/catalogo/clasificacion_ruta/detail.html.twig', [
            'item' => $clasificacionRuta,
        ]);
    }
}
