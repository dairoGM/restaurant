<?php

namespace App\Controller\Configuracion;


use App\Entity\Configuracion\ComentarioEspacio;
use App\Entity\Configuracion\Espacio;
use App\Entity\Configuracion\EspacioRedesSociales;
use App\Form\Configuracion\ComentarioEspacioType;
use App\Form\Configuracion\EspacioGaleriaType;
use App\Form\Configuracion\EspacioType;
use App\Repository\Configuracion\ComentarioEspacioRepository;
use App\Repository\Configuracion\EspacioRedesSocialesRepository;
use App\Repository\Configuracion\EspacioRepository;
use App\Repository\Configuracion\RedSocialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuracion/espacio")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class EspacioController extends AbstractController
{

    /**
     * @Route("/", name="app_espacio_index", methods={"GET"})
     * @param EspacioRepository $espacioRepository
     * @return Response
     */
    public function index(EspacioRepository $espacioRepository)
    {
        try {
            return $this->render('modules/configuracion/espacio/index.html.twig', [
                'registros' => $espacioRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_espacio_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_espacio_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param EspacioRepository $espacioRepository
     * @return Response
     */
    public function registrar(Request $request, EspacioRepository $espacioRepository)
    {
        try {
            $entidad = new Espacio();
            $form = $this->createForm(EspacioType::class, $entidad, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                if (!empty($form['imagenPortada']->getData())) {
                    $file = $form['imagenPortada']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $entidad->setImagenPortada($file_name);
                    $file->move("uploads/images/espacio/imagenPortada", $file_name);
                }

                if (!empty($form['imagenDetallada']->getData())) {
                    $file = $form['imagenDetallada']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $entidad->setImagenDetallada($file_name);
                    $file->move("uploads/images/espacio/imagenDetallada", $file_name);
                }
                if (!empty($form['imagenBanner']->getData())) {
                    $file = $form['imagenBanner']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $entidad->setImagenBanner($file_name);
                    $file->move("uploads/images/espacio/imagenBanner", $file_name);
                }
//                if (!empty($form['imagenMovil']->getData())) {
//                    $file = $form['imagenMovil']->getData();
//                    $ext = $file->guessExtension();
//                    $file_name = md5(uniqid()) . "." . $ext;
//                    $entidad->setImagenMovil($file_name);
//                    $file->move("uploads/video/espacio/reel", $file_name);
//                }
                $espacioRepository->add($entidad, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_espacio_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/espacio/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_espacio_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_espacio_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param Espacio $espacio
     * @param EspacioRepository $espacioRepository
     * @return Response
     */
    public function modificar(Request $request, Espacio $espacio, EspacioRepository $espacioRepository)
    {
        try {
            $form = $this->createForm(EspacioType::class, $espacio, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                if (!empty($form['imagenPortada']->getData())) {
                    if ($espacio->getImagenPortada() != null) {
                        if (file_exists('uploads/images/espacio/imagenPortada/' . $espacio->getImagenPortada())) {
                            unlink('uploads/images/espacio/imagenPortada/' . $espacio->getImagenPortada());
                        }
                    }

                    $file = $form['imagenPortada']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $espacio->setImagenPortada($file_name);
                    $file->move("uploads/images/espacio/imagenPortada", $file_name);
                }

                if (!empty($form['imagenDetallada']->getData())) {
                    if ($espacio->getImagenDetallada() != null) {
                        if (file_exists('uploads/images/espacio/imagenDetallada/' . $espacio->getImagenDetallada())) {
                            unlink('uploads/images/espacio/imagenDetallada/' . $espacio->getImagenDetallada());
                        }
                    }

                    $file = $form['imagenDetallada']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $espacio->setImagenDetallada($file_name);
                    $file->move("uploads/images/espacio/imagenDetallada", $file_name);
                }


//                if (!empty($form['imagenMovil']->getData())) {
//                    if ($espacio->getImagenMovil() != null) {
//                        if (file_exists('uploads/video/espacio/reel/' . $espacio->getImagenMovil())) {
//                            unlink('uploads/video/espacio/reel/' . $espacio->getImagenMovil());
//                        }
//                    }
//
//                    $file = $form['imagenMovil']->getData();
//                    $ext = $file->guessExtension();
//                    $file_name = md5(uniqid()) . "." . $ext;
//                    $espacio->setImagenMovil($file_name);
//                    $file->move("uploads/video/espacio/reel", $file_name);
//                }

                if (!empty($form['imagenBanner']->getData())) {
                    if ($espacio->getImagenBanner() != null) {
                        if (file_exists('uploads/images/espacio/imagenBanner/' . $espacio->getImagenBanner())) {
                            unlink('uploads/images/espacio/imagenBanner/' . $espacio->getImagenBanner());
                        }
                    }

                    $file = $form['imagenBanner']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $espacio->setImagenBanner($file_name);
                    $file->move("uploads/images/espacio/imagenBanner", $file_name);
                }
                $espacioRepository->edit($espacio);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_espacio_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/espacio/edit.html.twig', [
                'form' => $form->createView(),
                'espacio' => $espacio
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_espacio_modificar', ['id' => $espacio], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/configurar_redes_sociales", name="app_espacio_configurar", methods={"GET", "POST"})
     * @param Espacio $espacio
     * @param RedSocialRepository $redSocialRepository
     * @return Response
     */
    public function configurar(Espacio $espacio, RedSocialRepository $redSocialRepository, EspacioRedesSocialesRepository $espacioRedesSocialesRepository)
    {
        try {
            $redesAsignadas = $espacioRedesSocialesRepository->findBy(['espacio' => $espacio->getId()], ['id' => 'asc']);
            $arrayAsignadas = [];
            if (is_array($redesAsignadas)) {
                foreach ($redesAsignadas as $value) {
                    $arrayAsignadas[$value->getRedSocial()->getId()] = $value->getEnlace();
                }
            }

            return $this->render('modules/configuracion/espacio/configurarRedesSociales.html.twig', [
                'espacio' => $espacio,
                'redesSociales' => $redSocialRepository->findBy(['activo' => true], ['id' => 'asc']),
                'redesSocialesAsignadas' => $arrayAsignadas
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_espacio_modificar', ['id' => $espacio], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/asociar_comentarios", name="app_espacio_asociar_comentario", methods={"GET", "POST"})
     * @param Request $request
     * @param Espacio $espacio
     * @param ComentarioEspacioRepository $comentarioEspacioRepository
     * @return Response
     */
    public function asociarComentarios(Request $request, Espacio $espacio, ComentarioEspacioRepository $comentarioEspacioRepository)
    {
        try {
            $comentarioEspacio = new ComentarioEspacio();
            $form = $this->createForm(ComentarioEspacioType::class, $comentarioEspacio, ['action' => 'modificar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                if (!empty($form['imagen']->getData())) {
                    if ($comentarioEspacio->getImagen() != null) {
                        if (file_exists('uploads/images/espacio/comentario/imagen/' . $comentarioEspacio->getImagen())) {
                            unlink('uploads/images/espacio/comentario/imagen/' . $comentarioEspacio->getImagen());
                        }
                    }

                    $file = $form['imagen']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $comentarioEspacio->setImagen($file_name);
                    $file->move("uploads/images/espacio/comentario/imagen", $file_name);
                }
                $comentarioEspacio->setEspacio($espacio);
                $comentarioEspacioRepository->add($comentarioEspacio, true);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_espacio_asociar_comentario', ['id' => $espacio->getId()], Response::HTTP_SEE_OTHER);
            }
            $comentarios = $comentarioEspacioRepository->findBy(['espacio' => $espacio->getId()]);
            return $this->render('modules/configuracion/espacio/comentario.html.twig', [
                'form' => $form->createView(),
                'comentarioEspacio' => $comentarioEspacio,
                'espacio' => $espacio,
                'comentarios' => $comentarios
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_espacio_asociar_comentario', ['id' => $espacio->getId()], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar_comentario", name="app_espacio_eliminar_comentario", methods={"GET"})
     * @param ComentarioEspacio $comentarioEspacio
     * @param ComentarioEspacioRepository $comentarioEspacioRepository
     * @return Response
     */
    public function eliminarComentario(ComentarioEspacio $comentarioEspacio, ComentarioEspacioRepository $comentarioEspacioRepository)
    {
        try {
            if ($comentarioEspacioRepository->find($comentarioEspacio) instanceof ComentarioEspacio) {
                $comentarioEspacioRepository->remove($comentarioEspacio, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_espacio_asociar_comentario', ['id' => $comentarioEspacio->getEspacio()->getId()], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_espacio_asociar_comentario', ['id' => $comentarioEspacio->getEspacio()->getId()], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_espacio_asociar_comentario', ['id' => $comentarioEspacio->getEspacio()->getId()], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/guardar_configuracion", name="app_espacio_guardar_configuracion", methods={"GET", "POST"})
     * @param Request $request
     * @param RedSocialRepository $redSocialRepository
     * @return Response
     */
    public function guardarConfiguracion(Request $request, EspacioRepository $espacioRepository, RedSocialRepository $redSocialRepository, EspacioRedesSocialesRepository $espacioRedesSocialesRepository)
    {
        try {
            $allPost = $request->request->All();

            $exist = $espacioRedesSocialesRepository->findBy(['espacio' => $allPost['idEspacio'], 'redSocial' => $allPost['idRedSocial']]);

            $new = new EspacioRedesSociales();
            $isNew = true;
            if (isset($exist[0])) {
                $new = $exist[0];
                $isNew = false;
            }
            $new->setEnlace($allPost['valor']);
            $new->setEspacio($espacioRepository->find($allPost['idEspacio']));
            $new->setRedSocial($redSocialRepository->find($allPost['idRedSocial']));
            if ($isNew) {
                $espacioRedesSocialesRepository->add($new, true);
            } else {
                $espacioRedesSocialesRepository->edit($new, true);
            }
            return $this->json('OK');
        } catch (\Exception $exception) {
            return $this->json(null);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_espacio_eliminar", methods={"GET"})
     * @param Espacio $espacio
     * @param EspacioRepository $espacioRepository
     * @return Response
     */
    public function eliminar(Espacio $espacio, EspacioRepository $espacioRepository)
    {
        try {
            if ($espacioRepository->find($espacio) instanceof Espacio) {
                $espacioRepository->remove($espacio, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_espacio_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_espacio_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_espacio_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/publicar", name="app_espacio_publicar", methods={"GET"})
     * @param Espacio $espacio
     * @param EspacioRepository $espacioRepository
     * @return Response
     */
    public function publicar(Espacio $espacio, EspacioRepository $espacioRepository)
    {
        try {
            if ($espacioRepository->find($espacio) instanceof Espacio) {
                $espacio->setPublico(!$espacio->getPublico());
                $espacioRepository->edit($espacio, true);

                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_espacio_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_espacio_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_espacio_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_espacio_detail", methods={"GET", "POST"})
     * @param Espacio $espacio
     * @return Response
     */
    public function detail(Espacio $espacio)
    {
        return $this->render('modules/configuracion/espacio/detail.html.twig', [
            'item' => $espacio,
        ]);
    }


    /**
     * @Route("/{id}/galeria", name="app_espacio_asociar_galeria", methods={"GET", "POST"})
     * @param Request $request
     * @param Espacio $espacio
     * @param EspacioRepository $espacioRepository
     * @return Response
     */
    public function galeria(Request $request, Espacio $espacio, EspacioRepository $espacioRepository)
    {
        try {
            $form = $this->createForm(EspacioGaleriaType::class, $espacio, ['action' => 'modificar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $gallery = json_decode($espacio->getGaleria());
                if (!empty($form['galeria']->getData())) {
                    foreach ($form['galeria']->getData() as $key => $val) {
                        $file = $val;
                        $ext = $file->guessExtension();
                        $file_name = md5(uniqid()) . "." . $ext;
                        $gallery[] = $file_name;
                        $file->move("uploads/images/espacio/galeria", $file_name);
                    }
                }
                $espacio->setGaleria(json_encode($gallery));
                $espacioRepository->edit($espacio, true);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_espacio_asociar_galeria', ['id' => $espacio->getId()], Response::HTTP_SEE_OTHER);
            }
            return $this->render('modules/configuracion/espacio/galeria.html.twig', [
                'form' => $form->createView(),
                'espacio' => $espacio,
                'imagenes' => json_decode($espacio->getGaleria(), true)
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_espacio_asociar_galeria', ['id' => $espacio->getId()], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/eliminar-imagen/{id}/{imagen}", name="app_espacio_eliminar_imagen", methods={"GET"})
     * @param Espacio $id
     * @param $imagen
     * @param EspacioRepository $espacioRepository
     * @return Response
     */
    public function eliminarImagen(Espacio $id, $imagen, EspacioRepository $espacioRepository)
    {
        try {
            $galeria = json_decode($id->getGaleria());
            $nuevaGaleria = [];
            if (is_array($galeria)) {
                foreach ($galeria as $value) {
                    $img = explode(".", $value);
                    if ($img[0] != $imagen) {
                        $nuevaGaleria[] = $value;
                    }
                }
            }
            $id->setGaleria(json_encode($nuevaGaleria));
            $espacioRepository->edit($id, true);
            return $this->redirectToRoute('app_espacio_asociar_galeria', ['id' => $id->getId()], Response::HTTP_SEE_OTHER);

        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_espacio_asociar_comentario', ['id' => $id->getEspacio()->getId()], Response::HTTP_SEE_OTHER);
        }
    }
}
