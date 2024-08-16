<?php

namespace App\Controller\Configuracion;

use App\Controller\Configuracion\CategoriaDocenteRepository;
use App\Entity\Configuracion\ComentarioEspacio;
use App\Entity\Configuracion\Espacio;
use App\Entity\Configuracion\SeccionServicio;
use App\Entity\Configuracion\Servicio;
use App\Form\Configuracion\ComentarioEspacioType;
use App\Form\Configuracion\SeccionServicioGaleriaType;
use App\Form\Configuracion\SeccionServicioType;
use App\Form\Configuracion\ServicioType;
use App\Repository\Configuracion\ComentarioEspacioRepository;
use App\Repository\Configuracion\SeccionServicioRepository;
use App\Repository\Configuracion\ServicioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
        try {
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
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_servicio_index', [], Response::HTTP_SEE_OTHER);
        }
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
                'servicio' => $servicio
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
     * @Route("/{id}/publicar", name="app_servicio_publicar", methods={"GET"})
     * @param Servicio $servicio
     * @param ServicioRepository $servicioRepository
     * @return Response
     */
    public function publicar(Servicio $servicio, ServicioRepository $servicioRepository)
    {
        try {
            if ($servicioRepository->find($servicio) instanceof Servicio) {
                $servicio->setPublico(!$servicio->getPublico());
                $servicioRepository->edit($servicio, true);

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


    /**
     * @Route("/{id}/asociar_seccion", name="app_servicio_asociar_seccion", methods={"GET", "POST"})
     * @param Request $request
     * @param Servicio $servicio
     * @param SeccionServicioRepository $seccionServicioRepository
     * @return Response
     */
    public function asociarSeccion(Request $request, Servicio $servicio, SeccionServicioRepository $seccionServicioRepository)
    {
        try {
            $seccionServicio = new SeccionServicio();
            $form = $this->createForm(SeccionServicioType::class, $seccionServicio, ['action' => 'modificar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                if (!empty($form['imagen']->getData())) {
                    if ($seccionServicio->getImagen() != null) {
                        if (file_exists('uploads/images/servicio/seccion/imagen/' . $seccionServicio->getImagen())) {
                            unlink('uploads/images/servicio/seccion/imagen/' . $seccionServicio->getImagen());
                        }
                    }

                    $file = $form['imagen']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $seccionServicio->setImagen($file_name);
                    $file->move("uploads/images/servicio/seccion/imagen", $file_name);
                }
                $seccionServicio->setServicio($servicio);
                $seccionServicioRepository->add($seccionServicio, true);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_servicio_asociar_seccion', ['id' => $servicio->getId()], Response::HTTP_SEE_OTHER);
            }
            $seccion = $seccionServicioRepository->findBy(['servicio' => $servicio->getId()]);
            $galery = [];
            if (is_array($seccion)) {
                foreach ($seccion as $value) {
                    $galery[$value->getId()] = json_decode($value->getGaleria(), true);
                }
            }

            return $this->render('modules/configuracion/servicio/seccion.html.twig', [
                'form' => $form->createView(),
                'seccionServicio' => $seccionServicio,
                'servicio' => $servicio,
                'seccion' => $seccion,
                'galeria' => $galery
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_servicio_asociar_seccion', ['id' => $servicio->getId()], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar_seccion", name="app_servicio_eliminar_seccion", methods={"GET"})
     * @param SeccionServicio $seccionServicio
     * @param SeccionServicioRepository $seccionServicioRepository
     * @return Response
     */
    public function eliminarSeccion(SeccionServicio $seccionServicio, SeccionServicioRepository $seccionServicioRepository)
    {
        try {
            if ($seccionServicioRepository->find($seccionServicio) instanceof SeccionServicio) {
                $seccionServicioRepository->remove($seccionServicio, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_servicio_asociar_seccion', ['id' => $seccionServicio->getServicio()->getId()], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_servicio_asociar_seccion', ['id' => $seccionServicio->getServicio()->getId()], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_servicio_asociar_seccion', ['id' => $seccionServicio->getServicio()->getId()], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/asociar_galeria_seccion", name="app_servicio_asociar_galeria_seccion", methods={"GET", "POST"})
     * @param Request $request
     * @param SeccionServicio $seccionServicio
     * @param SeccionServicioRepository $seccionServicioRepository
     * @return Response
     */
    public function asociarGaleriaSeccion(Request $request, SeccionServicio $seccionServicio, SeccionServicioRepository $seccionServicioRepository)
    {
        try {

            $form = $this->createForm(SeccionServicioGaleriaType::class, $seccionServicio, ['action' => 'modificar']);
            $form->handleRequest($request);
            $gallery = json_decode($seccionServicio->getGaleria(), true);
            if ($form->isSubmitted() && $form->isValid()) {


                if (!empty($form['imagen']->getData())) {
                    $file = $form['imagen']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $gallery[] = $file_name;
                    $file->move("uploads/images/servicio/seccion/galeria", $file_name);
                    $seccionServicio->setGaleria(json_encode($gallery));
                    $seccionServicioRepository->edit($seccionServicio, true);
                }

                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_servicio_asociar_galeria_seccion', ['id' => $seccionServicio->getId()], Response::HTTP_SEE_OTHER);
            }
            $request->getSession()->set('gallery_seccion', $gallery);
            $request->getSession()->set('seccion_servicio_id', $seccionServicio->getId());
            return $this->render('modules/configuracion/servicio/galeria_seccion.html.twig', [
                'form' => $form->createView(),
                'seccionServicio' => $seccionServicio,
                'servicio' => $seccionServicio->getServicio(),
                'galeria' => $gallery
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_servicio_asociar_galeria_seccion', ['id' => $seccionServicio->getId()], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar_imagen_seccion", name="app_servicio_eliminar_imagen_seccion", methods={"GET"})
     * @param Request $request
     * @param $id
     * @param SeccionServicioRepository $seccionServicioRepository
     * @return Response
     */
    public function eliminarImagenSeccion(Request $request, $id, SeccionServicioRepository $seccionServicioRepository)
    {
        $seccionServicioId = $request->getSession()->get('seccion_servicio_id');
        $temp = $seccionServicioRepository->find($seccionServicioId);
        try {
            $gallery = $request->getSession()->get('gallery_seccion');

            $newGallery = [];
            foreach ($gallery as $value) {
                if (!str_contains($value, $id)) {
                    $newGallery[] = $value;
                }
            }
            $temp->setGaleria(json_encode($newGallery));
            $seccionServicioRepository->edit($temp, true);

            $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
            return $this->redirectToRoute('app_servicio_asociar_galeria_seccion', ['id' => $temp->getId()], Response::HTTP_SEE_OTHER);

        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_servicio_asociar_seccion', ['id' => $temp->getId()], Response::HTTP_SEE_OTHER);
        }
    }

}
