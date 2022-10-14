<?php

namespace App\Controller\Client;

use App\Entity\Client\ObjetivoEspecificoUsuarioFavoritos;
use App\Entity\NotificacionesUsuario;
use App\ExtendSys\Filter\FilterImpl;
use App\Repository\Client\ObjetivoEspecificoUsuarioFavoritosRepository;
use App\Repository\Estructura\EstructuraRepository;
use App\Repository\Estructura\MunicipioRepository;
use App\Repository\Personal\PersonaRepository;
use App\Services\AutoEvalService;
use App\Services\Utils;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @param ObjetivoEspecificoRepository $objetivoEspecificoRepository
     * @param Utils $utils
     * @param PlanRepository $planRepository
     * @param PlanObjetivoGeneralRepository $planObjetivoGeneralRepository
     * @param PlanIndicadorResponsableRepository $planIndicadorResponsableRepository
     * @param EvaluacionRepository $evaluacionRepository
     * @param MunicipioRepository $municipioRepository
     * @param ObjetivoEspecificoUsuarioFavoritosRepository $especificoUsuarioFavoritosRepository
     * @param EntityManagerInterface $entityManager
     * @param ObjetivoGeneralRepository $objetivoGeneralRepository
     * @param IndicadorRepository $indicadorRepository
     * @param Request $request
     * @param null $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function index( $id = null)
    {


        return $this->render('dash_board/index.html.twig', [

        ]);
    }

    /**
     * @Route("/dashboard/responsables/indicador/{id}", name="app_dash_board_responsables_indicador")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function responsablesIndicador(Indicador $id)
    {


        return $this->render('dash_board/modalResponsable.html.twig', ['indicador' => $id]);
    }


}
