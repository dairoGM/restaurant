<?php

namespace App\Controller\Personal;


use App\Entity\Personal\Vendedor;
use App\Entity\Security\User;
use App\Export\Personal\ExportListVendedorToPdf;
use App\Repository\Personal\PersonaRepository;
use App\Repository\Personal\ResponsableRepository;
use App\Repository\Personal\VendedorRepository;
use App\Services\DoctrineHelper;
use App\Services\HandlerFop;
use App\Services\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/personal/vendendor")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_PERSON")
 */
class VendedorController extends AbstractController
{

    /**
     * @Route("/", name="app_vendendor_index", methods={"GET"})
     * @param Request $request
     * @param VendedorRepository $vendendorRepository
     * @param Utils $utils
     * @return Response
     */
    public function index(Request $request, VendedorRepository $vendendorRepository, Utils $utils)
    {
        try {
            $request->getSession()->remove('usuario_modificado');

            $estructurasNegocio = $utils->procesarRolesUsuarioAutenticado($this->getUser()->getId());
            $registros = $vendendorRepository->getVendedores($estructurasNegocio);

            return $this->render('modules/personal/vendedor/index.html.twig', [
                'registros' => $registros,
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_vendendor_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/eliminar", name="app_vendedor_eliminar", methods={"GET"})
     * @param Vendedor $vendendor
     * @param VendedorRepository $vendendorRepository
     * @return Response
     */
    public function eliminar(Vendedor $vendendor, VendedorRepository $vendendorRepository)
    {
        try {
            if ($vendendorRepository->find($vendendor) instanceof Vendedor) {
                $vendendorRepository->remove($vendendor, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');

                return $this->redirectToRoute('app_vendendor_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_vendendor_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            pr($exception->getMessage());
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_vendendor_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/detail", name="app_vendedor_detail", methods={"GET", "POST"})
     * @param Vendedor $vendendor
     * @return Response
     */
    public function detail(Vendedor $vendendor)
    {
        return $this->render('modules/personal/vendedor/detail.html.twig', [
            'item' => $vendendor,
        ]);
    }

    /**
     * @Route("/exportar_pdf", name="app_vendedor_exportar_pdf", methods={"GET", "POST"})
     * @param HandlerFop $handFop
     * @param VendedorRepository $vendedorRepository
     * @param Utils $utils
     * @return Response
     */
    public function exportarPdf(HandlerFop $handFop, VendedorRepository $vendedorRepository, Utils $utils)
    {
        $estructurasNegocio = $utils->procesarRolesUsuarioAutenticado($this->getUser()->getId());
        $export = $vendedorRepository->getExportarListado($estructurasNegocio);
        $export = DoctrineHelper::toArray($export);
        return $handFop->exportToPdf(new ExportListVendedorToPdf($export));
    }
}
