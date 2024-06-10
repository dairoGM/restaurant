<?php

namespace App\Controller\Configuracion;

use App\Controller\Configuracion\CategoriaDocenteRepository;
use App\Entity\Configuracion\Portada;
use App\Form\Configuracion\PortadaType;
use App\Repository\Configuracion\PortadaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuracion/portada_web")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class PortadaWebController extends AbstractController
{

    /**
     * @Route("/", name="app_portada_web_index", methods={"GET"})
     * @param PortadaRepository $portadaRepository
     * @return Response
     */
    public function index(PortadaRepository $portadaRepository)
    {
        try {
            return $this->render('modules/configuracion/portada_web/index.html.twig', [
                'registros' => $portadaRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_portada_web_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_portada_web_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param PortadaRepository $portadaRepository
     * @return Response
     */
    public function registrar(Request $request, PortadaRepository $portadaRepository)
    {
        try {
            $entidad = new Portada();
            $form = $this->createForm(PortadaType::class, $entidad, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                if (!empty($form['imagen']->getData())) {
                    $file = $form['imagen']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $entidad->setImagen($file_name);
                    $file->move("uploads/images/portada_web/imagen", $file_name);
                }
                if (!empty($form['imagen2']->getData())) {
                    $file = $form['imagen2']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $entidad->setImagen2($file_name);
                    $file->move("uploads/images/portada_web/imagen2", $file_name);
                }
                if (!empty($form['imagen3']->getData())) {
                    $file = $form['imagen3']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $entidad->setImagen3($file_name);
                    $file->move("uploads/images/portada_web/imagen3", $file_name);
                }
                if (!empty($form['imagen4']->getData())) {
                    $file = $form['imagen4']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $entidad->setImagen4($file_name);
                    $file->move("uploads/images/portada_web/imagen4", $file_name);
                }
                $portadaRepository->add($entidad, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_portada_web_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/portada_web/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_portada_web_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_portada_web_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param Portada $portada
     * @param PortadaRepository $portadaRepository
     * @return Response
     */
    public function modificar(Request $request, Portada $portada, PortadaRepository $portadaRepository)
    {
        try {
            $form = $this->createForm(PortadaType::class, $portada, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                if (!empty($form['imagen']->getData())) {
                    if ($portada->getImagen() != null) {
                        if (file_exists('uploads/images/portada_web/imagen/' . $portada->getImagen())) {
                            unlink('uploads/images/portada_web/imagen/' . $portada->getImagen());
                        }
                    }

                    $file = $form['imagen']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $portada->setImagen($file_name);
                    $file->move("uploads/images/portada_web/imagen", $file_name);
                }
                if (!empty($form['imagen2']->getData())) {
                    if ($portada->getImagen() != null) {
                        if (file_exists('uploads/images/portada_web/imagen2/' . $portada->getImagen2())) {
                            unlink('uploads/images/portada_web/imagen2/' . $portada->getImagen2());
                        }
                    }
                    $file = $form['imagen2']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $portada->setImagen2($file_name);
                    $file->move("uploads/images/portada_web/imagen2", $file_name);
                }
                if (!empty($form['imagen3']->getData())) {
                    if ($portada->getImagen() != null) {
                        if (file_exists('uploads/images/portada_web/imagen3/' . $portada->getImagen3())) {
                            unlink('uploads/images/portada_web/imagen3/' . $portada->getImagen3());
                        }
                    }
                    $file = $form['imagen3']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $portada->setImagen3($file_name);
                    $file->move("uploads/images/portada_web/imagen3", $file_name);
                }
                if (!empty($form['imagen4']->getData())) {
                    if ($portada->getImagen() != null) {
                        if (file_exists('uploads/images/portada_web/imagen4/' . $portada->getImagen4())) {
                            unlink('uploads/images/portada_web/imagen4/' . $portada->getImagen4());
                        }
                    }
                    $file = $form['imagen4']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $portada->setImagen4($file_name);
                    $file->move("uploads/images/portada_web/imagen4", $file_name);
                }


                $portadaRepository->edit($portada);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_portada_web_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/portada_web/edit.html.twig', [
                'form' => $form->createView(),
                'portada' => $portada
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_portada_web_modificar', ['id' => $portada], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_portada_web_eliminar", methods={"GET"})
     * @param Portada $portada
     * @param PortadaRepository $portadaRepository
     * @return Response
     */
    public function eliminar(Portada $portada, PortadaRepository $portadaRepository)
    {
        try {
            if ($portadaRepository->find($portada) instanceof Portada) {
                $portadaRepository->remove($portada, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_portada_web_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_portada_web_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_portada_web_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/publicar", name="app_portada_web_publicar", methods={"GET"})
     * @param Portada $portada
     * @param PortadaRepository $portadaRepository
     * @return Response
     */
    public function publicar(Portada $portada, PortadaRepository $portadaRepository)
    {
        try {
            if ($portadaRepository->find($portada) instanceof Portada) {

                $allPortadas = $portadaRepository->findAll();
                foreach ($allPortadas as $value) {
                    $value->setPublico(false);
                    $portadaRepository->edit($value, true);
                }

                $portada->setPublico(!$portada->getPublico());
                $portadaRepository->edit($portada, true);

                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_portada_web_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_portada_web_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_portada_web_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_portada_web_detail", methods={"GET", "POST"})
     * @param Portada $portada
     * @return Response
     */
    public function detail(Portada $portada)
    {
        return $this->render('modules/configuracion/portada_web/detail.html.twig', [
            'item' => $portada,
        ]);
    }
}
