<?php

namespace App\Controller\Api;

use App\Entity\Restaurant\Contactenos;
use App\Entity\Restaurant\Perfil;
use App\Form\Restaurant\ContactenosApiType;
use App\Form\Restaurant\PerfilApiType;
use App\Repository\Configuracion\CateringRepository;
use App\Repository\Configuracion\ConocenosRedesSocialesRepository;
use App\Repository\Configuracion\ConocenosRepository;
use App\Repository\Configuracion\DatosContactoRepository;
use App\Repository\Configuracion\EspacioRedesSocialesRepository;
use App\Repository\Configuracion\EspacioRepository;
use App\Repository\Configuracion\EventoRepository;
use App\Repository\Configuracion\ExperienciaCulinariaRepository;
use App\Repository\Configuracion\ExperienciaGastronomicaRepository;
use App\Repository\Configuracion\MaridajeRepository;
use App\Repository\Configuracion\MenuPlatoRepository;
use App\Repository\Configuracion\MenuRepository;
use App\Repository\Configuracion\PlatoRepository;
use App\Repository\Configuracion\PortadaRepository;
use App\Repository\Configuracion\ReservaRepository;
use App\Repository\Configuracion\ServicioRepository;
use App\Repository\Configuracion\SobreRepository;
use App\Repository\Configuracion\TerminosCondicionesRepository;
use App\Repository\Restaurant\ContactenosRepository;
use App\Repository\Restaurant\PerfilRepository;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\Utils;

/**
 * @Route("/api")
 */
class ApiServicesController extends AbstractController
{
    private $requestStack;
    private $baseUrl;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $request = $this->requestStack->getCurrentRequest();

        // Obtener la URL base
        $this->baseUrl = $request->getSchemeAndHttpHost() . $request->getBasePath();
    }

    /**
     * @Route("/contactenos/crear", name="api_contactenos_crear",methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param Request $request
     * @param ContactenosRepository $contactenosRepository
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function crearContactenos(Request $request, ContactenosRepository $contactenosRepository, EntityManagerInterface $em)
    {
        try {
            $jsonParams = json_decode($request->getContent(), true);

            if (isset($jsonParams['correo']) && !empty($jsonParams['correo']) && isset($jsonParams['nombre']) && !empty($jsonParams['nombre'])
                && isset($jsonParams['mensaje']) && !empty($jsonParams['mensaje'])) {

                $contactenos = new Contactenos();
                $form = $this->createForm(ContactenosApiType::class, $contactenos);
                $form->submit($jsonParams);
                if ($form->isSubmitted() && $form->isValid()) {
                    $contactenos->setNombre($jsonParams['nombre']);
                    $contactenos->setCorreo($jsonParams['correo']);
                    $contactenos->setMensaje($jsonParams['mensaje']);

                    $em->persist($contactenos);
                    $em->flush();

                    return $this->json(['messaje' => 'OK', 'data' => $contactenosRepository->listarContactenos(['id' => $contactenos->getId()], ['id' => 'desc'], 1)]);
                }
                return $this->json(['messaje' => $form->getErrors(), 'data' => []], Response::HTTP_BAD_REQUEST);
            }
            return $this->json(['messaje' => 'Incorrect Parameter', 'data' => []], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }


}
