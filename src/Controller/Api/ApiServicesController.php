<?php

namespace App\Controller\Api;

use App\Entity\Restaurant\Contactenos;
use App\Entity\Restaurant\Perfil;
use App\Entity\Restaurant\ReservacionMesa;
use App\Form\Restaurant\ContactenosApiType;
use App\Form\Restaurant\PerfilApiType;
use App\Form\Restaurant\ReservacionMesaType;
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
use App\Repository\Restaurant\ReservacionMesaRepository;
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
use Symfony\Component\Validator\Constraints\DateTime;

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
     * @Route("/reservaciones/mesa/listar", name="api_reservaciones_mesa_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param Request $request
     * @param ReservacionMesaRepository $reservacionMesaRepository
     * @return JsonResponse
     */
    public function listarReservacionesMesa(Request $request, ReservacionMesaRepository $reservacionMesaRepository)
    {
        try {
            $jsonParams = json_decode($request->getContent(), true);
            $email = $jsonParams['email'] ?? null;
            if (!empty($email)) {
                $reservaciones = $reservacionMesaRepository->getReservaciones($email);
                $response = [];
                foreach ($reservaciones as $value) {
                    $value['fechaReservacion'] = date_format($value['fechaReservacion'], 'Y-m-d H:i:s');
                    $response[] = $value;
                }
                return $this->json(['messaje' => 'OK', 'data' => $response]);
            }
            return $this->json(['messaje' => "Usuario requerido", 'data' => []], Response::HTTP_BAD_GATEWAY);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }


    /**
     * @Route("/reservar/mesa/editar", name="api_reservar_mesa_editar",methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param Request $request
     * @param EspacioRepository $espacioRepository
     * @param PerfilRepository $perfilRepository
     * @param EntityManagerInterface $em
     * @param ReservacionMesaRepository $reservacionMesaRepository
     * @return JsonResponse
     */
    public function editarMesa(Request $request, EspacioRepository $espacioRepository, PerfilRepository $perfilRepository, EntityManagerInterface $em, ReservacionMesaRepository $reservacionMesaRepository)
    {
        try {
            $jsonParams = json_decode($request->getContent(), true);

            if (isset($jsonParams['ticket']) && !empty($jsonParams['ticket'])) {

                $email = $jsonParams['email'] ?? null;
                $fechaReservacion = $jsonParams['fechaReservacion'] ?? null;
                $cantidadMesa = $jsonParams['cantidadMesa'] ?? null;
                $celular = $jsonParams['celular'] ?? null;
                $dni = $jsonParams['dni'] ?? null;


                $reservacionMesa = $reservacionMesaRepository->findOneBy($jsonParams['ticket']);

                $espacio = $reservacionMesa->getEspacio();
                $mesasEspacio = $espacio->getCantidadMesa();
                $fecha = explode(' ', $jsonParams['fechaReservacion'])[0];
                $reservacionesRealizadas = $reservacionMesaRepository->getCantidadReservaciones($fecha);

                if (intval($jsonParams['cantidadMesa']) <= $mesasEspacio) {
                    if (($mesasEspacio - $reservacionesRealizadas) >= $jsonParams['cantidadMesa']) {

                        if (!empty($fechaReservacion)){
                            $reservacionMesa->setFechaReservacion(\DateTime::createFromFormat('Y-m-d H:i:s', $fechaReservacion));
                        }



                        return $this->json(['messaje' => 'OK', 'data' => ['ticked' => $reservacionMesa->getTicket()]]);

                    }
                    return $this->json(['messaje' => "La disponibilidad de mesas es insuficiente", 'data' => []], Response::HTTP_BAD_REQUEST);
                }
                return $this->json(['messaje' => "La cantidad de mesas solicitada es superior a las mesas del espacio seleccionado", 'data' => []], Response::HTTP_BAD_REQUEST);

            }
            return $this->json(['messaje' => 'Incorrect Parameter', 'data' => []], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }
}
