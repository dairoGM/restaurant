<?php

namespace App\Controller\Configuracion;

use App\Controller\Configuracion\CategoriaDocenteRepository;
use App\Entity\Configuracion\Servicio;
use App\Form\Configuracion\ServicioType;
use App\Repository\Configuracion\ServicioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuracion/servicio")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class ServicioController extends AbstractController
{

    /**
     * @Route("/", name="app_servicio_index", methods={"GET"})
     * @param ServicioRepository $servicioRepository
     * @return Response
     */
    public function index(ServicioRepository $servicioRepository)
    {
        try {
            return $this->render('modules/configuracion/servicio/index.html.twig', [
                'registros' => $servicioRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_servicio_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_servicio_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param ServicioRepository $servicioRepository
     * @return Response
     */
    public function registrar(Request $request, ServicioRepository $servicioRepository)
    {
//        try {
            $entidad = new Servicio();
            $form = $this->createForm(ServicioType::class, $entidad, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                if (!empty($form['imagenPortada']->getData())) {
                    $file = $form['imagenPortada']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $entidad->setImagenPortada($file_name);
                    $file->move("uploads/images/servicio/imagenPortada", $file_name);
                }

                if (!empty($form['imagenDetallada']->getData())) {
                    $file = $form['imagenDetallada']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $entidad->setImagenDetallada($file_name);
                    $file->move("uploads/images/servicio/imagenDetallada", $file_name);
                }

                $servicioRepository->add($entidad, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_servicio_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/servicio/new.html.twig', [
                'form' => $form->createView(),
            ]);
//        } catch (\Exception $exception) {
//            $this->addFlash('error', $exception->getMessage());
//            return $this->redirectToRoute('app_servicio_index', [], Response::HTTP_SEE_OTHER);
//        }
    }


    /**
     * @Route("/{id}/modificar", name="app_servicio_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param Servicio $servicio
     * @param ServicioRepository $servicioRepository
     * @return Response
     */
    public function modificar(Request $request, Servicio $servicio, ServicioRepository $servicioRepository)
    {
        try {
            $form = $this->createForm(ServicioType::class, $servicio, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                if (!empty($form['imagenPortada']->getData())) {
                    if ($servicio->getImagenPortada() != null) {
                        if (file_exists('uploads/images/servicio/imagenPortada/' . $servicio->getImagenPortada())) {
                            unlink('uploads/images/servicio/imagenPortada/' . $servicio->getImagenPortada());
                        }
                    }

                    $file = $form['imagenPortada']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $servicio->setImagenPortada($file_name);
                    $file->move("uploads/images/servicio/imagenPortada", $file_name);
                }

                if (!empty($form['imagenDetallada']->getData())) {
                    if ($servicio->getImagenDetallada() != null) {
                        if (file_exists('uploads/images/servicio/imagenDetallada/' . $servicio->getImagenDetallada())) {
                            unlink('uploads/images/servicio/imagenDetallada/' . $servicio->getImagenDetallada());
                        }
                    }

                    $file = $form['imagenDetallada']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $servicio->setImagenDetallada($file_name);
                    $file->move("uploads/images/servicio/imagenDetallada", $file_name);
                }

                $servicioRepository->edit($servicio);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_servicio_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/servicio/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_servicio_modificar', ['id' => $servicio], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_servicio_eliminar", methods={"GET"})
     * @param Servicio $servicio
     * @param ServicioRepository $servicioRepository
     * @return Response
     */
    public function eliminar(Servicio $servicio, ServicioRepository $servicioRepository)
    {
        try {
            if ($servicioRepository->find($servicio) instanceof Servicio) {
                $servicioRepository->remove($servicio, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_servicio_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_servicio_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_servicio_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_servicio_detail", methods={"GET", "POST"})
     * @param Servicio $servicio
     * @return Response
     */
    public function detail(Servicio $servicio)
    {
        return $this->render('modules/configuracion/servicio/detail.html.twig', [
            'item' => $servicio,
        ]);
    }
}
