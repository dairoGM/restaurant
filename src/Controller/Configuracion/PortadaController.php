<?php

namespace App\Controller\Configuracion;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/configuracion/portada")
 * @IsGranted("ROLE_ADMIN", "ROLE_HOME_CATALOGO")
 */
class PortadaController extends AbstractController
{

    /**
     * @Route("", name="app_configuracion_portada", methods={"GET"})
     * @return Response
     */
    public function index()
    {
        return $this->render('modules/configuracion/portada/index.html.twig');

    }
}
