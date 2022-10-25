<?php

namespace App\Controller\Catalogo;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/catalogo/portada")
 * @IsGranted("ROLE_ADMIN", "ROLE_HOME_CATALOGO")
 */
class PortadaController extends AbstractController
{

    /**
     * @Route("", name="app_catalogo_portada", methods={"GET"})
     * @return Response
     */
    public function index()
    {
        return $this->render('modules/catalogo/portada/index.html.twig');

    }
}
