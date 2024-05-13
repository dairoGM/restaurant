<?php

namespace App\Controller\Client;

//use App\Entity\NotificacionesUsuario;
use App\ExtendSys\Filter\FilterImpl;
use App\Repository\Estructura\EstructuraRepository;
use App\Repository\Estructura\MunicipioRepository;
//use App\Repository\Personal\PersonaRepository;
use App\Services\AutoEvalService;
use App\Services\Utils;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class DashBoardController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     * @param ObjetivoEspecificoRepository $objetivoEspecificoRepository
     * @param ObjetivoGeneralRepository $objetivoGeneralRepository
     * @param null $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function home()
    {
        return $this->redirectToRoute('app_dash_board');
    }

    /**
     * @Route("/dashboard/{id}", name="app_dash_board")
     * @param null $id
     * @return RedirectResponse|Response
     */
    public function index( $id = null)
    {
        return $this->render('modules/admin/index.html.twig');
    }




}
