<?php

namespace App\Controller\Configuracion;

use App\Entity\Configuracion\Conocenos;
use App\Entity\Configuracion\PoliticaReservacion;
use App\Entity\Security\User;
use App\Form\Configuracion\ConocenosType;
use App\Form\Configuracion\PoliticaReservacionType;
use App\Repository\Configuracion\MetodoPagoRepository;
use App\Repository\Configuracion\PoliticaReservacionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/configuracion/politica_reservacion")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CATDOC")
 */
class PoliticaReservacionController extends AbstractController
{

    /**
     * @Route("/", name="app_politica_reservacion_index", methods={"GET"})
     * @param PoliticaReservacionRepository $politicaReservacionRepository
     * @return Response
     */
    public function index(PoliticaReservacionRepository $politicaReservacionRepository)
    {
        return $this->render('modules/configuracion/politica_reservacion/index.html.twig', [
            'registros' => $politicaReservacionRepository->listarPoliticaReservacion(),
        ]);
    }

    /**
     * @Route("/registrar", name="app_politica_reservacion_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param PoliticaReservacionRepository $politicaReservacionRepository
     * @return Response
     */
    public function registrar(Request $request, PoliticaReservacionRepository $politicaReservacionRepository, SerializerInterface $serializer)
    {
        try {
            $entidad = new PoliticaReservacion();
            $form = $this->createForm(PoliticaReservacionType::class, $entidad, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                if (!empty($form['imagen']->getData())) {
                    $file = $form['imagen']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $entidad->setImagen($file_name);
                    $file->move("uploads/images/politica_reservacion/imagen", $file_name);
                }

                $politicaReservacionRepository->add($entidad, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_politica_reservacion_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/politica_reservacion/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_politica_reservacion_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_politica_reservacion_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param PoliticaReservacion $politicaReservacion
     * @param PoliticaReservacionRepository $politicaReservacionRepository
     * @return Response
     */
    public function modificar(Request $request, PoliticaReservacion $politicaReservacion, PoliticaReservacionRepository $politicaReservacionRepository)
    {
        try {
            $form = $this->createForm(PoliticaReservacionType::class, $politicaReservacion, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                if (!empty($form['imagen']->getData())) {
                    if ($politicaReservacion->getImagen() != null) {
                        if (file_exists('uploads/images/politica_reservacion/imagen/' . $politicaReservacion->getImagen())) {
                            unlink('uploads/images/politica_reservacion/imagen/' . $politicaReservacion->getImagen());
                        }
                    }

                    $file = $form['imagen']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $politicaReservacion->setImagen($file_name);
                    $file->move("uploads/images/politica_reservacion/imagen", $file_name);
                }

                $politicaReservacionRepository->edit($politicaReservacion);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_politica_reservacion_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/politica_reservacion/edit.html.twig', [
                'form' => $form->createView(),
                'politica_reservacion' => $politicaReservacion
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_politica_reservacion_modificar', ['id' => $politicaReservacion->getId()], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/detail", name="app_politica_reservacion_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param PoliticaReservacion $politicaReservacion
     * @return Response
     */
    public function detail(Request $request, PoliticaReservacion $politicaReservacion)
    {
        return $this->render('modules/configuracion/politica_reservacion/detail.html.twig', [
            'item' => $politicaReservacion,
        ]);
    }

    /**
     * @Route("/{id}/eliminar", name="app_politica_reservacion_eliminar", methods={"GET"})
     * @param Request $request
     * @param PoliticaReservacion $politicaReservacion
     * @param PoliticaReservacionRepository $politicaReservacionRepository
     * @return Response
     */
    public function eliminar(Request $request, PoliticaReservacion $politicaReservacion, PoliticaReservacionRepository $politicaReservacionRepository)
    {
        try {
            if ($politicaReservacionRepository->find($politicaReservacion) instanceof PoliticaReservacion) {
                $politicaReservacionRepository->remove($politicaReservacion, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_politica_reservacion_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_politica_reservacion_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_politica_reservacion_index', [], Response::HTTP_SEE_OTHER);
        }
    }

}
