<?php

namespace App\Controller\Configuracion;


use App\Entity\Configuracion\Conocenos;
use App\Entity\Configuracion\ConocenosRedesSociales;
use App\Form\Configuracion\ConocenosType;
use App\Repository\Configuracion\ConocenosRedesSocialesRepository;
use App\Repository\Configuracion\ConocenosRepository;
use App\Repository\Configuracion\RedSocialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuracion/conocenos")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class ConocenosController extends AbstractController
{

    /**
     * @Route("/", name="app_conocenos_index", methods={"GET"})
     * @param ConocenosRepository $conocenosRepository
     * @return Response
     */
    public function index(ConocenosRepository $conocenosRepository)
    {
        try {
            return $this->render('modules/configuracion/conocenos/index.html.twig', [
                'registros' => $conocenosRepository->findBy([], ['id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_conocenos_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_conocenos_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param ConocenosRepository $conocenosRepository
     * @return Response
     */
    public function registrar(Request $request, ConocenosRepository $conocenosRepository)
    {
        try {
            $entidad = new Conocenos();
            $form = $this->createForm(ConocenosType::class, $entidad, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                if (!empty($form['imagen']->getData())) {
                    $file = $form['imagen']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $entidad->setImagen($file_name);
                    $file->move("uploads/images/conocenos/imagen", $file_name);
                }

                $conocenosRepository->add($entidad, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_conocenos_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/conocenos/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_conocenos_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_conocenos_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param Conocenos $conocenos
     * @param ConocenosRepository $conocenosRepository
     * @return Response
     */
    public function modificar(Request $request, Conocenos $conocenos, ConocenosRepository $conocenosRepository)
    {
        try {
            $form = $this->createForm(ConocenosType::class, $conocenos, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                if (!empty($form['imagen']->getData())) {
                    if ($conocenos->getImagen() != null) {
                        if (file_exists('uploads/images/conocenos/imagen/' . $conocenos->getImagen())) {
                            unlink('uploads/images/conocenos/imagen/' . $conocenos->getImagen());
                        }
                    }

                    $file = $form['imagen']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $conocenos->setImagen($file_name);
                    $file->move("uploads/images/conocenos/imagen", $file_name);
                }

                $conocenosRepository->edit($conocenos);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_conocenos_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/conocenos/edit.html.twig', [
                'form' => $form->createView(),
                'conocenos' => $conocenos
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_conocenos_modificar', ['id' => $conocenos], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/configurar_redes_sociales", name="app_conocenos_configurar", methods={"GET", "POST"})
     * @param Conocenos $conocenos
     * @param RedSocialRepository $redSocialRepository
     * @return Response
     */
    public function configurar(Conocenos $conocenos, RedSocialRepository $redSocialRepository, ConocenosRedesSocialesRepository $conocenosRedesSocialesRepository)
    {
        try {
            $redesAsignadas = $conocenosRedesSocialesRepository->findBy(['conocenos' => $conocenos->getId()], ['id' => 'asc']);
            $arrayAsignadas = [];
            if (is_array($redesAsignadas)) {
                foreach ($redesAsignadas as $value) {
                    $arrayAsignadas[$value->getRedSocial()->getId()] = $value->getEnlace();
                }
            }

            return $this->render('modules/configuracion/conocenos/configurarRedesSociales.html.twig', [
                'conocenos' => $conocenos,
                'redesSociales' => $redSocialRepository->findBy(['activo' => true], ['id' => 'asc']),
                'redesSocialesAsignadas' => $arrayAsignadas
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_conocenos_modificar', ['id' => $conocenos], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/guardar_configuracion", name="app_conocenos_guardar_configuracion", methods={"GET", "POST"})
     * @param Request $request
     * @param RedSocialRepository $redSocialRepository
     * @return Response
     */
    public function guardarConfiguracion(Request $request, ConocenosRepository $conocenosRepository, RedSocialRepository $redSocialRepository, ConocenosRedesSocialesRepository $conocenosRedesSocialesRepository)
    {
        try {
            $allPost = $request->request->All();

            $exist = $conocenosRedesSocialesRepository->findBy(['conocenos' => $allPost['idConocenos'], 'redSocial' => $allPost['idRedSocial']]);

            $new = new ConocenosRedesSociales();
            $isNew = true;
            if (isset($exist[0])) {
                $new = $exist[0];
                $isNew = false;
            }
            $new->setEnlace($allPost['valor']);
            $new->setConocenos($conocenosRepository->find($allPost['idConocenos']));
            $new->setRedSocial($redSocialRepository->find($allPost['idRedSocial']));
            if ($isNew) {
                $conocenosRedesSocialesRepository->add($new, true);
            } else {
                $conocenosRedesSocialesRepository->edit($new, true);
            }
            return $this->json('OK');
        } catch (\Exception $exception) {
            return $this->json(null);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_conocenos_eliminar", methods={"GET"})
     * @param Conocenos $conocenos
     * @param ConocenosRepository $conocenosRepository
     * @return Response
     */
    public function eliminar(Conocenos $conocenos, ConocenosRepository $conocenosRepository)
    {
        try {
            if ($conocenosRepository->find($conocenos) instanceof Conocenos) {
                $conocenosRepository->remove($conocenos, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_conocenos_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_conocenos_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_conocenos_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/publicar", name="app_conocenos_publicar", methods={"GET"})
     * @param Conocenos $conocenos
     * @param ConocenosRepository $conocenosRepository
     * @return Response
     */
    public function publicar(Conocenos $conocenos, ConocenosRepository $conocenosRepository)
    {
        try {
            if ($conocenosRepository->find($conocenos) instanceof Conocenos) {
                $conocenos->setPublico(!$conocenos->getPublico());
                $conocenosRepository->edit($conocenos, true);

                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_conocenos_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_conocenos_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_conocenos_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_conocenos_detail", methods={"GET", "POST"})
     * @param Conocenos $conocenos
     * @return Response
     */
    public function detail(Conocenos $conocenos)
    {
        return $this->render('modules/configuracion/conocenos/detail.html.twig', [
            'item' => $conocenos,
        ]);
    }
}
