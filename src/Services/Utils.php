<?php

namespace App\Services;

use App\Entity\Restaurant\Pago;
use App\Entity\Restaurant\Reservacion;
use App\Entity\Restaurant\ReservacionMesa;
use App\Entity\Security\Rol;

//use App\Entity\Security\RolEstructura;
use App\Entity\Security\User;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Pimple\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @Service("agent.utils")
 */
class Utils
{

    private $baseUrl;
    private $em;
    private $container;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $em, ContainerInterface $container)
    {
        $this->baseUrl = $requestStack->getCurrentRequest()->getSchemeAndHttpHost();
        $this->em = $em;
        $this->container = $container;
    }

    public function getToken($email, $password)
    {
        try {
            $httpClient = new Client();
            $response = $httpClient->request('POST', $this->baseUrl . "/api/login_check", [
                'body' => json_encode(['email' => $email, 'password' => $password]),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Mc-Validation-Verify' => $this->container->getParameter('MC_VALIDATION_VERIFY')
                ]
            ]);
            $result = json_decode($response->getBody()->getContents(), true);
            return $result['token'] ?? null;;
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function procesarRutaCliente($rutaClienteRepository)
    {
        $final = [];
        foreach ($rutaClienteRepository as $value) {
            $final[] = (string)$value->getRuta()->getId();
        }
        return implode(',', $final);
    }


    /**
     * @return string
     */
    public function getMeses()
    {
        $meses = [
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Septiembre',
            'Octubre',
            'Noviembre',
            'Diciembre',
        ];
        return $meses;
    }

    public function procesarRolesUsuarioAutenticado($idUsuario)
    {
        $usuario = $this->em->getRepository(User::class)->find($idUsuario);
        $arrayEstructuras = [];
        /* @var $value Rol */
//        foreach ($usuario->getUserRoles() as $value) {
//            $rolEstructura = $this->em->getRepository(RolEstructura::class)->findBy(['rol' => $value->getId()]);
//            if (is_array($rolEstructura)) {
//                foreach ($rolEstructura as $value2) {
//                    if (!in_array($value2->getEstructura()->getId(), $arrayEstructuras)) {
//                        $arrayEstructuras[] = $value2->getEstructura()->getId();
//                    }
//                }
//            }
//        }
        return $arrayEstructuras;
    }

    public function getAwesomeIcons()
    {
        $fonts = array(
            'fa-address-book',
            'fa-address-card',
            'fa-adjust',
            'fa-align-center',
            'fa-align-justify',
            'fa-align-left',
            'fa-align-right',
            'fa-ambulance',
            'fa-american-sign-language-interpreting',
            'fa-anchor',
            'fa-angle-double-down',
            'fa-angle-double-left',
            'fa-angle-double-right',
            'fa-angle-double-up',
            'fa-angle-down',
            'fa-angle-left',
            'fa-angle-right',
            'fa-angle-up',
            'fa-archive',
            'fa-arrow-circle-down',
            'fa-arrow-circle-left',
            'fa-arrow-circle-right',
            'fa-arrow-circle-up',
            'fa-arrow-down',
            'fa-arrow-left',
            'fa-arrow-right',
            'fa-arrow-up',
            'fa-arrows-alt',
            'fa-assistive-listening-systems',
            'fa-asterisk',
            'fa-at',
            'fa-audio-description',
            'fa-backward',
            'fa-balance-scale',
            'fa-ban',
            'fa-barcode',
            'fa-bars',
            'fa-bath',
            'fa-battery-empty',
            'fa-battery-full',
            'fa-battery-half',
            'fa-battery-quarter',
            'fa-battery-three-quarters',
            'fa-bed',
            'fa-beer',
            'fa-bell',
            'fa-bell-slash',
            'fa-bicycle',
            'fa-binoculars',
            'fa-birthday-cake',
            'fa-blind',
            'fa-bold',
            'fa-bolt',
            'fa-bomb',
            'fa-book',
            'fa-bookmark',
            'fa-braille',
            'fa-briefcase',
            'fa-bug',
            'fa-building',
            'fa-bullhorn',
            'fa-bullseye',
            'fa-bus',
            'fa-calculator',
            'fa-calendar',
            'fa-camera',
            'fa-camera-retro',
            'fa-car',
            'fa-caret-down',
            'fa-caret-left',
            'fa-caret-right',
            'fa-caret-up',
            'fa-cart-arrow-down',
            'fa-cart-plus',
            'fa-certificate',
            'fa-check',
            'fa-check-circle',
            'fa-check-square',
            'fa-chevron-circle-down',
            'fa-chevron-circle-left',
            'fa-chevron-circle-right',
            'fa-chevron-circle-up',
            'fa-chevron-down',
            'fa-chevron-left',
            'fa-chevron-right',
            'fa-chevron-up',
            'fa-child',
            'fa-circle',
            'fa-clipboard',
            'fa-clone',
            'fa-cloud',
            'fa-code',
            'fa-coffee',
            'fa-cog',
            'fa-cogs',
            'fa-columns',
            'fa-comment',
            'fa-comments',
            'fa-compass',
            'fa-compress',
            'fa-copy',
            'fa-copyright',
            'fa-credit-card',
            'fa-crop',
            'fa-crosshairs',
            'fa-cube',
            'fa-cubes',
            'fa-cut',
            'fa-database',
            'fa-deaf',
            'fa-desktop',
            'fa-download',
            'fa-edit',
            'fa-eject',
            'fa-ellipsis-h',
            'fa-ellipsis-v',
            'fa-envelope',
            'fa-envelope-open',
            'fa-envelope-square',
            'fa-eraser',
            'fa-exclamation',
            'fa-exclamation-circle',
            'fa-exclamation-triangle',
            'fa-expand',
            'fa-eye',
            'fa-eye-slash',
            'fa-fast-backward',
            'fa-fast-forward',
            'fa-fax',
            'fa-female',
            'fa-fighter-jet',
            'fa-file',
            'fa-film',
            'fa-filter',
            'fa-fire',
            'fa-fire-extinguisher',
            'fa-flag',
            'fa-flag-checkered',
            'fa-flask',
            'fa-folder',
            'fa-folder-open',
            'fa-font',
            'fa-forward',
            'fa-gamepad',
            'fa-gavel',
            'fa-genderless',
            'fa-gift',
            'fa-globe',
            'fa-graduation-cap',
            'fa-h-square',
            'fa-hashtag',
            'fa-headphones',
            'fa-heart',
            'fa-heartbeat',
            'fa-history',
            'fa-home',
            'fa-hotel',
            'fa-hourglass',
            'fa-hourglass-end',
            'fa-hourglass-half',
            'fa-hourglass-start',
            'fa-i-cursor',
            'fa-id-badge',
            'fa-id-card',
            'fa-image',
            'fa-inbox',
            'fa-indent',
            'fa-industry',
            'fa-info',
            'fa-info-circle',
            'fa-italic',
            'fa-key',
            'fa-language',
            'fa-laptop',
            'fa-leaf',
            'fa-life-ring',
            'fa-link',
            'fa-list',
            'fa-list-alt',
            'fa-list-ol',
            'fa-list-ul',
            'fa-location-arrow',
            'fa-lock',
            'fa-low-vision',
            'fa-magic',
            'fa-magnet',
            'fa-male',
            'fa-map',
            'fa-map-marker',
            'fa-map-pin',
            'fa-map-signs',
            'fa-mars',
            'fa-mars-double',
            'fa-mars-stroke',
            'fa-mars-stroke-h',
            'fa-mars-stroke-v',
            'fa-medkit',
            'fa-mercury',
            'fa-microchip',
            'fa-microphone',
            'fa-microphone-slash',
            'fa-minus',
            'fa-minus-circle',
            'fa-minus-square',
            'fa-mobile',
            'fa-motorcycle',
            'fa-mouse-pointer',
            'fa-music',
            'fa-neuter',
            'fa-object-group',
            'fa-object-ungroup',
            'fa-outdent',
            'fa-paint-brush',
            'fa-paper-plane',
            'fa-paperclip',
            'fa-paragraph',
            'fa-paste',
            'fa-pause',
            'fa-pause-circle',
            'fa-paw',
            'fa-percent',
            'fa-phone',
            'fa-phone-square',
            'fa-plane',
            'fa-play',
            'fa-play-circle',
            'fa-plug',
            'fa-plus',
            'fa-plus-circle',
            'fa-plus-square',
            'fa-podcast',
            'fa-power-off',
            'fa-print',
            'fa-puzzle-piece',
            'fa-qrcode',
            'fa-question',
            'fa-question-circle',
            'fa-quote-left',
            'fa-quote-right',
            'fa-random',
            'fa-recycle',
            'fa-registered',
            'fa-reply',
            'fa-reply-all',
            'fa-retweet',
            'fa-road',
            'fa-rocket',
            'fa-rss',
            'fa-rss-square',
            'fa-save',
            'fa-search',
            'fa-search-minus',
            'fa-search-plus',
            'fa-server',
            'fa-share',
            'fa-share-alt',
            'fa-share-alt-square',
            'fa-share-square',
            'fa-ship',
            'fa-shopping-bag',
            'fa-shopping-basket',
            'fa-shopping-cart',
            'fa-shower',
            'fa-sign-language',
            'fa-signal',
            'fa-sitemap',
            'fa-sort',
            'fa-sort-down',
            'fa-sort-up',
            'fa-space-shuttle',
            'fa-spinner',
            'fa-square',
            'fa-star',
            'fa-star-half',
            'fa-step-backward',
            'fa-step-forward',
            'fa-stethoscope',
            'fa-sticky-note',
            'fa-stop',
            'fa-stop-circle',
            'fa-street-view',
            'fa-strikethrough',
            'fa-subscript',
            'fa-subway',
            'fa-suitcase',
            'fa-superscript',
            'fa-table',
            'fa-tablet',
            'fa-tag',
            'fa-tags',
            'fa-tasks',
            'fa-taxi',
            'fa-terminal',
            'fa-text-height',
            'fa-text-width',
            'fa-th',
            'fa-th-large',
            'fa-th-list',
            'fa-thermometer',
            'fa-thermometer-empty',
            'fa-thermometer-full',
            'fa-thermometer-half',
            'fa-thermometer-quarter',
            'fa-thermometer-three-quarters',
            'fa-thumbs-down',
            'fa-thumbs-up',
            'fa-times',
            'fa-times-circle',
            'fa-tint',
            'fa-toggle-off',
            'fa-toggle-on',
            'fa-trademark',
            'fa-train',
            'fa-transgender',
            'fa-transgender-alt',
            'fa-trash',
            'fa-tree',
            'fa-trophy',
            'fa-truck',
            'fa-tty',
            'fa-tv',
            'fa-umbrella',
            'fa-underline',
            'fa-undo',
            'fa-universal-access',
            'fa-university',
            'fa-unlink',
            'fa-unlock',
            'fa-unlock-alt',
            'fa-upload',
            'fa-user',
            'fa-user-circle',
            'fa-user-md',
            'fa-user-plus',
            'fa-user-secret',
            'fa-user-times',
            'fa-users',
            'fa-venus',
            'fa-venus-double',
            'fa-venus-mars',
            'fa-volume-down',
            'fa-volume-off',
            'fa-volume-up',
            'fa-wheelchair',
            'fa-wifi',
            'fa-window-close',
            'fa-window-maximize',
            'fa-window-minimize',
            'fa-window-restore',
            'fa-wrench',
        );

        return $fonts;
    }


    public function listarPlatosOfertaFamiliar($menuPlatoRepository, $baseUrl)
    {
        $result = $menuPlatoRepository->listarOfertasFamiliar();
        $response = [];
        if (is_array($result)) {
            foreach ($result as $value) {
                $value['imagen'] = $baseUrl . "/uploads/images/plato/imagen/" . $value['imagen'];
                $value['precio'] = '$' . number_format($value['precio'], 2, '.', ',');
                $response[] = $value;
            }
        }
        return $response;
    }

    public function listarPlatos($menuPlatoRepository, $baseUrl, $sugerenciaChef = false, $idEspacio, $ofertaFamiliar = false)
    {
        $filtros['p.publico'] = true;
        $filtros['p.activo'] = true;
        $filtros['p.ofertaFamilia'] = false;
        if ($sugerenciaChef) {
            $filtros['p.sugerenciaChef'] = true;
        }
        if ($ofertaFamiliar) {
            $filtros['p.ofertaFamilia'] = true;
        }
        if (-1 != $idEspacio) {
            $filtros['e.id'] = $idEspacio;
        }
        $result = $menuPlatoRepository->listarPlatos($filtros);
        $response = [];
        if (is_array($result)) {
            foreach ($result as $value) {
                $value['imagen'] = $baseUrl . "/uploads/images/plato/imagen/" . $value['imagen'];
                $value['precio'] = '$' . number_format($value['precio'], 2, '.', ',');
                $response[] = $value;
            }
        }
        return $response;
    }

    public function sendMailer2($params = [])
    {
        $params = [
            'name_from' => 'pruebaa',
            'email_from' => "no-reply@test.com",
            'name_to' => 'pepe',
            'email_to' => 'dairo@dgtalliance.com',
            'subject' => 'hi!',
            'content' => '<b>hola</b>',
            'date' => date('Y-m-d H:i:s'),
        ];
        try {
            $httpClient = new Client();
            $response = $httpClient->request('POST', "https://notifications.idxboost.com/tail/dinamic/send/mails", [
                'form_params' => $params,
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ]
            ]);
            $result = json_decode($response->getBody()->getContents(true), true);

            return $result;
        } catch (\Exception  $exception) {
            return $exception->getMessage();
        }
    }


    public function generarIdentificadorReserva()
    {
        $contador = count($this->em->getRepository(Reservacion::class)->findAll()) + 1;
        $identificador = 'RS' . str_pad($contador, 5, '0', STR_PAD_LEFT);
        return $identificador;
    }

    public function generarIdentificadorPago()
    {
        $contador = count($this->em->getRepository(Pago::class)->findAll()) + 1;
        $identificador = 'PG' . str_pad($contador, 5, '0', STR_PAD_LEFT);
        return $identificador;
    }
}
