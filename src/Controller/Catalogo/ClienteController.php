<?php

namespace App\Controller\Catalogo;

use App\Entity\Catalogo\Cliente;
use App\Entity\Catalogo\RutaCliente;
use App\Entity\Security\User;
use App\Form\Catalogo\ClienteType;
use App\Repository\Catalogo\ClienteRepository;
use App\Repository\Catalogo\RutaClienteRepository;
use App\Repository\Catalogo\RutaRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/catalogo/cliente")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class ClienteController extends AbstractController
{

    /**
     * @Route("/", name="app_cliente_index", methods={"GET"})
     * @param ClienteRepository $clienteRepository
     * @return Response
     */
    public function index(ClienteRepository $clienteRepository)
    {
        try {
            return $this->render('modules/catalogo/cliente/index.html.twig', [
                'registros' => $clienteRepository->findBy([], ['activo' => 'desc', 'id' => 'desc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_cliente_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/registrar", name="app_cliente_registrar", methods={"GET", "POST"})
     * @param Request $request
     * @param ClienteRepository $clienteRepository
     * @param EntityManagerInterface $em
     * @param RutaRepository $rutaRepository
     * @return Response
     */
    public function registrar(Request $request, ClienteRepository $clienteRepository, EntityManagerInterface $em, RutaRepository $rutaRepository)
    {
        try {
            $newEntity = new Cliente();
            $form = $this->createForm(ClienteType::class, $newEntity, ['action' => 'registrar']);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $clienteRepository->add($newEntity, true);


                $allPost = $request->request->all();
                if (isset($allPost['cliente']['ruta']) && count($allPost['cliente']['ruta']) > 0) {
                    foreach ($allPost['cliente']['ruta'] as $value) {
                        $rutaCliente = new RutaCliente();
                        $rutaCliente->setCliente($newEntity);
                        $rutaCliente->setRuta($rutaRepository->find($value));
                        $em->persist($rutaCliente);
                    }
                    $em->flush();
                }
                $this->addFlash('success', 'El elemento ha sido creado satisfactoriamente.');
                return $this->redirectToRoute('app_cliente_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('modules/catalogo/cliente/new.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_cliente_registrar', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/modificar", name="app_cliente_modificar", methods={"GET", "POST"})
     * @param Request $request
     * @param Cliente $cliente
     * @param ClienteRepository $clienteRepository
     * @param Utils $utils
     * @param RutaClienteRepository $rutaClienteRepository
     * @return Response
     */
    public function modificar(Request $request, Cliente $cliente, RutaRepository $rutaRepository, EntityManagerInterface $em, ClienteRepository $clienteRepository, \App\Services\Utils $utils, RutaClienteRepository $rutaClienteRepository)
    {
        try {
            $form = $this->createForm(ClienteType::class, $cliente, ['action' => 'modificar']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $clienteRepository->edit($cliente);

                $allPost = $request->request->all();
                if (isset($allPost['cliente']['ruta']) && count($allPost['cliente']['ruta']) > 0) {

                    foreach ($rutaClienteRepository->findBy(['cliente' => $cliente->getId()]) as $value) {
                        $rutaClienteRepository->remove($value);
                    }
                    $em->flush();

                    foreach ($allPost['cliente']['ruta'] as $value) {
                        $rutaCliente = new RutaCliente();
                        $rutaCliente->setCliente($cliente);
                        $rutaCliente->setRuta($rutaRepository->find($value));
                        $em->persist($rutaCliente);
                    }
                    $em->flush();
                }

                $this->addFlash('success', 'El elemento ha sido actualizado satisfactoriamente.');
                return $this->redirectToRoute('app_cliente_index', [], Response::HTTP_SEE_OTHER);
            }
            $rutas = $utils->procesarRutaCliente($rutaClienteRepository->findBy(['cliente' => $cliente->getId()]));
            return $this->render('modules/catalogo/cliente/edit.html.twig', [
                'form' => $form->createView(),
                'rutas' => $rutas
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_cliente_modificar', ['id' => $cliente], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/eliminar", name="app_cliente_eliminar", methods={"GET"})
     * @param Request $request
     * @param Cliente $cliente
     * @param ClienteRepository $clienteRepository
     * @return Response
     */
    public function eliminar(Request $request, Cliente $cliente, ClienteRepository $clienteRepository)
    {
        try {
            if ($clienteRepository->find($cliente) instanceof Cliente) {
                $clienteRepository->remove($cliente, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_cliente_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_cliente_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_cliente_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_cliente_detail", methods={"GET", "POST"})
     * @param Request $request
     * @param Cliente $cliente
     * @return Response
     */
    public function detail(Request $request, Cliente $cliente)
    {
        return $this->render('modules/catalogo/cliente/detail.html.twig', [
            'item' => $cliente,
        ]);
    }
}
