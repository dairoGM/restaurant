<?php

namespace App\Controller\Configuracion;

use App\Entity\Configuracion\MetodoPago;
use App\Entity\Security\User;
use App\Form\Configuracion\MetodoPagoType;
use App\Repository\Configuracion\MetodoPagoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/configuracion/metodo_pago")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CATDOC")
 */
class MetodoPagoController extends AbstractController
{

    /**
     * @Route("/", name="app_metodo_pago_index", methods={"GET"})
     * @param MetodoPagoRepository $metodoPagoRepository
     * @return Response
     */
    public function index(MetodoPagoRepository $metodoPagoRepository)
    {
        return $this->render('modules/configuracion/metodo_pago/index.html.twig', [
            'registros' => $metodoPagoRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
        ]);
    }

    /**
     * @Route("/registrar", name="app_metodo_pago_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param MetodoPagoRepository $metodoPagoRepository
     * @return Response
     */
    public function registrar(Request $request, MetodoPagoRepository $metodoPagoRepository, SerializerInterface $serializer)
    {
        try {
            $metodoPago = new MetodoPago();
            $form = $this->createForm(MetodoPagoType::class, $metodoPago, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                if (!empty($form['imagen']->getData())) {
                    $file = $form['imagen']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $metodoPago->setImagenQr($file_name);
                    $file->move("uploads/images/metodo_pago/imagen_qr", $file_name);
                }

                $metodoPagoRepository->add($metodoPago, true);
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_metodo_pago_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/metodo_pago/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_metodo_pago_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_metodo_pago_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param MetodoPago $metodoPago
     * @param MetodoPagoRepository $metodoPagoRepository
     * @return Response
     */
    public function modificar(Request $request, MetodoPago $metodoPago, MetodoPagoRepository $metodoPagoRepository)
    {
        try {
            $form = $this->createForm(MetodoPagoType::class, $metodoPago, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                if (!empty($form['imagen']->getData())) {
                    if ($metodoPago->getImagenQr() != null) {
                        if (file_exists('uploads/images/metodo_pago/imagen_qr/' . $metodoPago->getImagenQr())) {
                            unlink('uploads/images/metodo_pago/imagen_qr/' . $metodoPago->getImagenQr());
                        }
                    }

                    $file = $form['imagen']->getData();
                    $ext = $file->guessExtension();
                    $file_name = md5(uniqid()) . "." . $ext;
                    $metodoPago->setImagenQr($file_name);
                    $file->move("uploads/images/metodo_pago/imagen_qr", $file_name);
                }

                $metodoPagoRepository->edit($metodoPago);
                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_metodo_pago_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/configuracion/metodo_pago/edit.html.twig', [
                'form' => $form->createView(),
                'metodoPago' => $metodoPago
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_metodo_pago_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/detail", name="app_metodo_pago_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param User $metodoPago
     * @param MetodoPagoRepository $metodoPagoRepository
     * @return Response
     */
    public function detail(Request $request, MetodoPago $metodoPago)
    {
        return $this->render('modules/configuracion/metodo_pago/detail.html.twig', [
            'item' => $metodoPago,
        ]);
    }

    /**
     * @Route("/{id}/eliminar", name="app_metodo_pago_eliminar", methods={"GET"})
     * @param Request $request
     * @param MetodoPago $metodoPago
     * @param MetodoPagoRepository $metodoPagoRepository
     * @return Response
     */
    public function eliminar(Request $request, MetodoPago $metodoPago, MetodoPagoRepository $metodoPagoRepository)
    {
        try {
            if ($metodoPagoRepository->find($metodoPago) instanceof MetodoPago) {
                $metodoPagoRepository->remove($metodoPago, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_metodo_pago_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_metodo_pago_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_metodo_pago_index', [], Response::HTTP_SEE_OTHER);
        }
    }

}
