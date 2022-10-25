<?php

namespace App\Controller\Catalogo;

use App\Repository\Personal\PersonaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN", "ROLE_PORTADA_CATALOGO")
 */
class CatalogoHomeController extends AbstractController
{
    /**
     * @Route("/catalogo/home", name="app_catalogo_home")
     */
    public function index(): Response
    {

        return $this->render('modules/catalogo/index.html.twig');
    }

}
