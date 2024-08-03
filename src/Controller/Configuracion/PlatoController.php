<?php

namespace App\Controller\Configuracion;

use App\Controller\Configuracion\CategoriaDocenteRepository;
use App\Entity\Configuracion\Plato;
use App\Form\Configuracion\PlatoType;
use App\Repository\Configuracion\PlatoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuracion/plato")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class PlatoController extends AbstractController
{

    /**
     * @Route("/", name="app_plato_index", methods={"GET"})
     * @param PlatoRepository $platoRepository
     * @return Response
     */
    public function index(PlatoRepository $platoRepository, Request $request)
    {
        try {
//            $request->getSession()->remove('filtro_plato');
            $filtros = $request->getSession()->get('filtro_plato');
            if (empty($filtros)) {
                $filtros['sugerenciaChef'] = '0';
                $filtros['ofertaFamilia'] = '0';
                $filtros['activo'] = '1';
            }

            return $this->render('modules/configuracion/plato/index.html.twig', [
                'registros' => $platoRepository->findBy($filtros, ['activo' => 'desc', 'id' => 'desc']),
                'filtros' => $filtros
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_plato_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/filtros", name="app_plato_filtro", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function guardarFiltro(Request $request)
    {
        try {
            $allPost = $request->request->All();
            $filtros = $request->getSession()->get('filtro_plato');
            $nuevo = array_merge($filtros, [$allPost['campo'] => $allPost['valor']]);
            $request->getSession()->set('filtro_plato', $nuevo);
            return $this->json('OK');
        } catch (\Exception $exception) {
            return $this->json(null);
        }
    }

    /**
     * @Route("/registrar", name="app_plato_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param PlatoRepository $platoRepository
     * @return Response
     */
    public function registrar(Request $request, PlatoRepository $platoRepository)
    {
        try {
            $entidad = new Plato();
            $form = $this->createForm(PlatoType::class, $entidad, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                if (!empty($form['imagen']->getData())) {
                    $file = $form['imagen']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $entidad->setImagen($file_name);
                    $file->move("uploads/images/plato/imagen", $file_name);
                }


                $platoRepository->add($entidad, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_plato_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/plato/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_plato_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_plato_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param Plato $plato
     * @param PlatoRepository $platoRepository
     * @return Response
     */
    public function modificar(Request $request, Plato $plato, PlatoRepository $platoRepository)
    {
        try {
            $form = $this->createForm(PlatoType::class, $plato, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                if (!empty($form['imagen']->getData())) {
                    if ($plato->getImagen() != null) {
                        if (file_exists('uploads/images/plato/imagen/' . $plato->getImagen())) {
                            unlink('uploads/images/plato/imagen/' . $plato->getImagen());
                        }
                    }

                    $file = $form['imagen']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $plato->setImagen($file_name);
                    $file->move("uploads/images/plato/imagen", $file_name);
                }

                $platoRepository->edit($plato);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_plato_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/plato/edit.html.twig', [
                'form' => $form->createView(),
                'plato' => $plato
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_plato_modificar', ['id' => $plato->getId()], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_plato_eliminar", methods={"GET"})
     * @param Plato $plato
     * @param PlatoRepository $platoRepository
     * @return Response
     */
    public function eliminar(Plato $plato, PlatoRepository $platoRepository)
    {
        try {
            if ($platoRepository->find($plato) instanceof Plato) {
                $platoRepository->remove($plato, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_plato_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_plato_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_plato_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/publicar", name="app_plato_publicar", methods={"GET"})
     * @param Plato $plato
     * @param PlatoRepository $platoRepository
     * @return Response
     */
    public function publicar(Plato $plato, PlatoRepository $platoRepository)
    {
        try {
            if ($platoRepository->find($plato) instanceof Plato) {
                $plato->setPublico(!$plato->getPublico());
                $platoRepository->edit($plato, true);

                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_plato_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_plato_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_plato_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_plato_detail", methods={"GET", "POST"})
     * @param Plato $plato
     * @return Response
     */
    public function detail(Plato $plato)
    {
        return $this->render('modules/configuracion/plato/detail.html.twig', [
            'item' => $plato,
        ]);
    }
}
