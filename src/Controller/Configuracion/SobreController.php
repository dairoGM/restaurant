<?php

namespace App\Controller\Configuracion;


use App\Entity\Configuracion\Sobre;
use App\Entity\Configuracion\SobreRedesSociales;
use App\Form\Configuracion\SobreType;
use App\Repository\Configuracion\SobreRedesSocialesRepository;
use App\Repository\Configuracion\SobreRepository;
use App\Repository\Configuracion\RedSocialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuracion/sobre")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class SobreController extends AbstractController
{

    /**
     * @Route("/", name="app_sobre_index", methods={"GET"})
     * @param SobreRepository $sobreRepository
     * @return Response
     */
    public function index(SobreRepository $sobreRepository)
    {
        try {
            return $this->render('modules/configuracion/sobre/index.html.twig', [
                'registros' => $sobreRepository->findBy([], ['id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_sobre_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_sobre_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param SobreRepository $sobreRepository
     * @return Response
     */
    public function registrar(Request $request, SobreRepository $sobreRepository)
    {
        try {
            $entidad = new Sobre();
            $form = $this->createForm(SobreType::class, $entidad, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                if (!empty($form['imagen']->getData())) {
                    $file = $form['imagen']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $entidad->setImagen($file_name);
                    $file->move("uploads/images/sobre/imagen", $file_name);
                }

                $sobreRepository->add($entidad, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_sobre_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/sobre/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_sobre_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_sobre_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param Sobre $sobre
     * @param SobreRepository $sobreRepository
     * @return Response
     */
    public function modificar(Request $request, Sobre $sobre, SobreRepository $sobreRepository)
    {
        try {
            $form = $this->createForm(SobreType::class, $sobre, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                if (!empty($form['imagen']->getData())) {
                    if ($sobre->getImagen() != null) {
                        if (file_exists('uploads/images/sobre/imagen/' . $sobre->getImagen())) {
                            unlink('uploads/images/sobre/imagen/' . $sobre->getImagen());
                        }
                    }

                    $file = $form['imagen']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $sobre->setImagen($file_name);
                    $file->move("uploads/images/sobre/imagen", $file_name);
                }

                $sobreRepository->edit($sobre);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_sobre_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/sobre/edit.html.twig', [
                'form' => $form->createView(),
                'sobre' => $sobre
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_sobre_modificar', ['id' => $sobre], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_sobre_eliminar", methods={"GET"})
     * @param Sobre $sobre
     * @param SobreRepository $sobreRepository
     * @return Response
     */
    public function eliminar(Sobre $sobre, SobreRepository $sobreRepository)
    {
        try {
            if ($sobreRepository->find($sobre) instanceof Sobre) {
                $sobreRepository->remove($sobre, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_sobre_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_sobre_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_sobre_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/detail", name="app_sobre_detail", methods={"GET", "POST"})
     * @param Sobre $sobre
     * @return Response
     */
    public function detail(Sobre $sobre)
    {
        return $this->render('modules/configuracion/sobre/detail.html.twig', [
            'item' => $sobre,
        ]);
    }
}
