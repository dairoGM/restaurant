<?php

namespace App\Controller\Configuracion;

use App\Entity\Configuracion\TipoReservacion;
use App\Entity\Security\User;
use App\Form\Configuracion\TipoReservacionType;
use App\Repository\Configuracion\MetodoPagoRepository;
use App\Repository\Configuracion\TipoReservacionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/configuracion/tipo_reservacion")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CATDOC")
 */
class TipoReservacionController extends AbstractController
{

    /**
     * @Route("/", name="app_tipo_reservacion_index", methods={"GET"})
     * @param TipoReservacionRepository $tipoReservacionRepository
     * @return Response
     */
    public function index(TipoReservacionRepository $tipoReservacionRepository, MetodoPagoRepository $metodoPagoRepository)
    {
        $response = [];
        $registros = $tipoReservacionRepository->listarTiposReservacionGestion();
        foreach ($registros as $value) {
            $metodosPagoConfig = [];
            if (!empty($value['metodoPago'])) {
                $metodosPagoConfig = json_decode($value['metodoPago'], true);
            }

            $filtros['metodosPagoConfig'] = implode(",", $metodosPagoConfig);
            $filtros['activo'] = true;
            $metPag = $metodoPagoRepository->listarMetodosPago($filtros);
            $nombreMostrar = [];
            if (is_array($metPag)) {
                foreach ($metPag as $value1) {
                    $nombreMostrar[] = $value1['nombre'];
                }
            }
            $value['nombreMostrar'] = implode(", ", $nombreMostrar);
            $response[] = $value;
        }

        return $this->render('modules/configuracion/tipo_reservacion/index.html.twig', [
            'registros' => $response
        ]);
    }

    /**
     * @Route("/registrar", name="app_tipo_reservacion_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param TipoReservacionRepository $tipoReservacionRepository
     * @return Response
     */
    public function registrar(Request $request, TipoReservacionRepository $tipoReservacionRepository, SerializerInterface $serializer)
    {
        try {
            $tipoReservacion = new TipoReservacion();
            $form = $this->createForm(TipoReservacionType::class, $tipoReservacion, ['action' => 'registrar']);
            $form->handleRequest($request);
            $allPost = $request->request->All();
            if ($form->isSubmitted() && $form->isValid()) {
                $tipoReservacion->setMetodoPago(json_encode($allPost['tipo_reservacion']['metodoPago']));
                $tipoReservacionRepository->add($tipoReservacion, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_reservacion_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/tipo_reservacion/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_reservacion_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_tipo_reservacion_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param TipoReservacion $tipoReservacion
     * @param TipoReservacionRepository $tipoReservacionRepository
     * @return Response
     */
    public function modificar(Request $request, TipoReservacion $tipoReservacion, TipoReservacionRepository $tipoReservacionRepository)
    {
        try {
            $form = $this->createForm(TipoReservacionType::class, $tipoReservacion, ['action' => 'modificar']);
            $form->handleRequest($request);
            $allPost = $request->request->All();
            if ($form->isSubmitted()) {
                $met = isset($allPost['tipo_reservacion']['metodoPago']) ? json_encode($allPost['tipo_reservacion']['metodoPago']) : null;
                $tipoReservacion->setMetodoPago($met);
                $tipoReservacionRepository->edit($tipoReservacion);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_reservacion_index', [], Response::HTTP_SEE_OTHER);
            }
            $metodosPago = $tipoReservacion->getMetodoPago() != null ? implode(',', json_decode($tipoReservacion->getMetodoPago(), true)) : "-1";

            return $this->render('modules/configuracion/tipo_reservacion/edit.html.twig', [
                'form' => $form->createView(),
                'metodosPago' => $metodosPago
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_reservacion_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/detail", name="app_tipo_reservacion_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param User $tipoReservacion
     * @param TipoReservacionRepository $tipoReservacionRepository
     * @return Response
     */
    public function detail(Request $request, TipoReservacion $tipoReservacion)
    {
        return $this->render('modules/configuracion/tipo_reservacion/detail.html.twig', [
            'item' => $tipoReservacion,
        ]);
    }

    /**
     * @Route("/{id}/eliminar", name="app_tipo_reservacion_eliminar", methods={"GET"})
     * @param Request $request
     * @param TipoReservacion $tipoReservacion
     * @param TipoReservacionRepository $tipoReservacionRepository
     * @return Response
     */
    public function eliminar(Request $request, TipoReservacion $tipoReservacion, TipoReservacionRepository $tipoReservacionRepository)
    {
        try {
            if ($tipoReservacionRepository->find($tipoReservacion) instanceof TipoReservacion) {
                $tipoReservacionRepository->remove($tipoReservacion, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_tipo_reservacion_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_tipo_reservacion_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_tipo_reservacion_index', [], Response::HTTP_SEE_OTHER);
        }
    }

}
