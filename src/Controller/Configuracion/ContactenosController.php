<?php

namespace App\Controller\Configuracion;


use App\Entity\Restaurant\Contactenos;
use App\Repository\Restaurant\ContactenosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/configuracion/contactenos")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class ContactenosController extends AbstractController
{

    /**
     * @Route("/", name="app_contactenos_index", methods={"GET"})
     * @param ContactenosRepository $contactenosRepository
     * @return Response
     */
    public function index(ContactenosRepository $contactenosRepository)
    {
        try {
            return $this->render('modules/restaurant/contactenos/index.html.twig', [
                'registros' => $contactenosRepository->listarContactenos(),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_contactenos_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * @Route("/{id}/eliminar", name="app_contactenos_eliminar", methods={"GET"})
     * @param Contactenos $contactenos
     * @param ContactenosRepository $contactenosRepository
     * @return Response
     */
    public function eliminar(Contactenos $contactenos, ContactenosRepository $contactenosRepository)
    {
        try {
            if ($contactenosRepository->find($contactenos) instanceof Contactenos) {
                $contactenosRepository->remove($contactenos, true);
                $this->addFlash('success', 'El elemento ha sido eliminado satisfactoriamente.');
                return $this->redirectToRoute('app_contactenos_index', [], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Error en la entrada de datos');
            return $this->redirectToRoute('app_contactenos_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_contactenos_index', [], Response::HTTP_SEE_OTHER);
        }
    }

}
