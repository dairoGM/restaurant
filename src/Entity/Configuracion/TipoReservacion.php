<?php

namespace App\Entity\Configuracion;

use App\Entity\BaseNomenclator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbn_tipo_reservacion")
 */
class TipoReservacion extends BaseNomenclator
{
    /**
     * @ORM\Column(type="string")
     */
    private $montoAPagar;

    /**
     * @ORM\Column(type="string")
     */
    private $metodoPago;

    /**
     * @return mixed
     */
    public function getMontoAPagar()
    {
        return $this->montoAPagar;
    }

    /**
     * @param mixed $montoAPagar
     */
    public function setMontoAPagar($montoAPagar): void
    {
        $this->montoAPagar = $montoAPagar;
    }

    /**
     * @return mixed
     */
    public function getMetodoPago()
    {
        return $this->metodoPago;
    }

    /**
     * @param mixed $metodoPago
     */
    public function setMetodoPago($metodoPago): void
    {
        $this->metodoPago = $metodoPago;
    }


}
