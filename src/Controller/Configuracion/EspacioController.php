<?php

namespace App\Controller\Configuracion;


use App\Entity\Configuracion\Espacio;
use App\Form\Configuracion\EspacioType;
use App\Repository\Configuracion\EspacioRepository;
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
}
