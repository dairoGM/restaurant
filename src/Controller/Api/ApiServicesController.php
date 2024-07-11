<?php

namespace App\Controller\Api;

use App\Entity\Restaurant\Contactenos;
use App\Entity\Restaurant\Pago;
use App\Entity\Restaurant\Perfil;
use App\Entity\Restaurant\Reservacion;
use App\Entity\Security\User;
use App\Form\Restaurant\ContactenosApiType;
use App\Form\Restaurant\PagoType;
use App\Form\Restaurant\PerfilApiType;
use App\Form\Restaurant\ReservacionType;
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
use App\Repository\Restaurant\ReservacionRepository;
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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
    private UserPasswordHasherInterface $hasher;

    public function __construct(RequestStack $requestStack, UserPasswordHasherInterface $hasher)
    {
        $this->requestStack = $requestStack;
        $request = $this->requestStack->getCurrentRequest();

        // Obtener la URL base
        $this->baseUrl = $request->getSchemeAndHttpHost() . $request->getBasePath();
        $this->hasher = $hasher;
    }

    /**
     * @Route("/reservaciones/mesa/listar", name="api_reservaciones_mesa_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param Request $request
     * @param ReservacionRepository $reservacionMesaRepository
     * @return JsonResponse
     */
    public function listarReservacionesMesa(Request $request, ReservacionRepository $reservacionMesaRepository)
    {
        try {
            $jsonParams = json_decode($request->getContent(), true);
            $email = $jsonParams['email'] ?? null;
            if (!empty($email)) {
                $response = $reservacionMesaRepository->getReservaciones($email);
                return $this->json(['messaje' => 'OK', 'data' => $response]);
            }
            return $this->json(['messaje' => "Usuario requerido", 'data' => []], Response::HTTP_BAD_GATEWAY);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }


    /**
     * @Route("/reservaciones/editar", name="api_reservaciones_editar",methods={"PUT", "OPTIONS"}, defaults={"_format":"json"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ReservacionRepository $reservacionMesaRepository
     * @return JsonResponse
     */
    public function editarReservacion(Request $request, EntityManagerInterface $em, ReservacionRepository $reservacionRepository)
    {
        try {
            $jsonParams = json_decode($request->getContent(), true);

            if (isset($jsonParams['id']) && !empty($jsonParams['id']) &&
                isset($jsonParams['cantidad']) && !empty($jsonParams['cantidad'])) {
                $cantidad = $jsonParams['cantidad'];
                $reservacion = $reservacionRepository->find($jsonParams['id']);
                if (empty($reservacion->getEspacio())) {
                    $reservacion->setCantidad($cantidad);
                } else {
                    $reservacion->setCantidadPersona($cantidad);
                }

                $em->persist($reservacion);
                $em->flush();
                return $this->json(['messaje' => 'OK', 'data' => []]);
            }
            return $this->json(['messaje' => 'Incorrect Parameter', 'data' => []], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }


    /**
     * @Route("/reservaciones/mesa/eliminar/{id}", name="api_reservaciones_mesa_eliminar",methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param ReservacionRepository $reservacionMesaRepository
     * @return JsonResponse
     */
    public function eliminarMesa(Reservacion $id, ReservacionRepository $reservacionMesaRepository)
    {
        try {
            $reservacionMesaRepository->remove($id, true);
            return $this->json(['messaje' => 'OK', 'data' => []]);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }

    /**
     * @Route("/perfil/cambiar_clave", name="api_perfil_cambiar_clave", methods={"POST"}, defaults={"_format":"json"})
     * @param Request $request
     * @param PerfilRepository $perfilRepository
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function cambiarClave(Request $request, PerfilRepository $perfilRepository, EntityManagerInterface $em)
    {
        try {
            $jsonParams = json_decode($request->getContent(), true);
            if (isset($jsonParams['email']) && !empty($jsonParams['email']) && isset($jsonParams['password']) && !empty($jsonParams['password'])) {
                $perfil = $perfilRepository->findOneBy(['email' => $jsonParams['email']]);
                if ($perfil instanceof Perfil) {

                    $perfil->setPassword($jsonParams['password']);

                    if (method_exists($perfil, 'getUser') && !empty($perfil->getUser())) {
                        $password = $this->hasher->hashPassword($perfil->getUser(), $jsonParams['password']);
                        $perfil->getUser()->setPassword($password);
                    } else {
                        $user = new User();
                        $user->setEmail($jsonParams['email']);
                        $user->setRole('ROLE_CLIENT');
                        $password = $this->hasher->hashPassword($user, $jsonParams['password']);
                        $user->setPassword($password);
                        $em->persist($user);
                        $perfil->setUser($user);
                    }

                    $em->persist($perfil);
                    $em->flush();
                    return $this->json(['messaje' => 'OK', 'data' => $perfilRepository->listarPerfiles(['email' => $jsonParams['email']], ['id' => 'desc'], 1)[0]]);
                }
                return $this->json(['messaje' => 'Item no found', 'data' => []], Response::HTTP_NOT_FOUND);
            }
            return $this->json(['messaje' => 'Incorrect Parameter', 'data' => []], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }


    /**
     * @Route("/reservaciones/prereserva", name="api_reservaciones_prereserva_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param Request $request
     * @param ReservacionRepository $reservacionMesaRepository
     * @return JsonResponse
     */
    public function listarReservacionesPrereserva(Request $request, ReservacionRepository $reservacionMesaRepository)
    {
        try {
            $jsonParams = json_decode($request->getContent(), true);
            $email = $jsonParams['email'] ?? null;
            if (!empty($email)) {
                $response = $reservacionMesaRepository->listarReservacionesPrereserva($email);
                return $this->json(['messaje' => 'OK', 'data' => $response]);
            }
            return $this->json(['messaje' => "Usuario requerido", 'data' => []], Response::HTTP_BAD_GATEWAY);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }


    /**
     * @Route("/reservaciones/cantidad_prereserva", name="api_reservaciones_cantidad_prereserva", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param Request $request
     * @param ReservacionRepository $reservacionMesaRepository
     * @return JsonResponse
     */
    public function listarCantidadReservacionesPrereserva(Request $request, ReservacionRepository $reservacionMesaRepository)
    {
        try {
            $jsonParams = json_decode($request->getContent(), true);
            $email = $jsonParams['email'] ?? null;
            if (!empty($email)) {
                $response = $reservacionMesaRepository->listarReservacionesPrereserva($email);
                return $this->json(['messaje' => 'OK', 'data' => count($response)]);
            }
            return $this->json(['messaje' => "Usuario requerido", 'data' => []], Response::HTTP_BAD_GATEWAY);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }


    /**
     * @Route("/reservaciones/cancelar/{id}", name="api_reservaciones_cancelar",methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param ReservacionRepository $reservacionMesaRepository
     * @return JsonResponse
     */
    public function cancelarReservacion(Reservacion $id, ReservacionRepository $reservacionMesaRepository)
    {
        try {
            $id->setEstado('Cancelada');
            $reservacionMesaRepository->edit($id, true);
            return $this->json(['messaje' => 'OK', 'data' => []]);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }


    /**
     * @Route("/reservaciones/prereserva_mesa", name="api_reservaciones_prereserva_mesa_listar", methods={"POST", "OPTIONS"}, defaults={"_format":"json"})
     * @param Request $request
     * @param ReservacionRepository $reservacionMesaRepository
     * @return JsonResponse
     */
    public function listarReservacionesPrereservaMesa(Request $request, ReservacionRepository $reservacionMesaRepository, PlatoRepository $platoRepository)
    {
        try {
            $jsonParams = json_decode($request->getContent(), true);
            $espacio = $jsonParams['espacioPlato'] ?? null;
            $email = $jsonParams['email'] ?? null;
            if (!empty($email)) {
                $response = $reservacionMesaRepository->listarReservacionesPrereservaMesa($email, $espacio);
                return $this->json(['messaje' => 'OK', 'data' => $response]);
            }
            return $this->json(['messaje' => "Usuario requerido", 'data' => []], Response::HTTP_BAD_GATEWAY);
        } catch (\Exception $exc) {
            return $this->json(['messaje' => $exc->getMessage(), 'data' => []], Response::HTTP_BAD_GATEWAY);
        }
    }

}
