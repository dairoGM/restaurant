<?php

namespace App\Controller\Catalogo;

use App\Entity\Catalogo\Pais;
use App\Entity\Security\User;
use App\Form\Catalogo\PaisType;
use App\Repository\Catalogo\PaisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/catalogo/pais")
 * @IsGranted("ROLE_ADMIN", "ROLE_GEST_CARRERA")
 */
class PaisController extends AbstractController
{

    /**
     * @Route("/", name="app_pais_index", methods={"GET"})
     * @param PaisRepository $paisRepository
     * @return Response
     */
    public function index(PaisRepository $paisRepository)
    {
        try {
            return $this->render('modules/catalogo/pais/index.html.twig', [
                'registros' => $paisRepository->findBy([], ['activo' => 'desc', 'nombre' => 'asc']),
            ]);
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute('app_pais_index', [], Response::HTTP_SEE_OTHER);
        }
    }

}
