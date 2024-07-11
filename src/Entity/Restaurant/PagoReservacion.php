<?php

namespace App\Entity\Restaurant;

use App\Entity\BaseEntity;
use App\Entity\Configuracion\Espacio;
use App\Entity\Configuracion\MetodoPago;
use App\Entity\Configuracion\Plato;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbr_pago_reservacion")
 */
class PagoReservacion extends BaseEntity
{

    /**
     * @ORM\ManyToOne(targetEntity="Pago")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Pago $pago;

    /**
     * @ORM\ManyToOne(targetEntity="Reservacion")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Reservacion $reservacion;

    /**
     * @return Pago|null
     */
    public function getPago(): ?Pago
    {
        return $this->pago;
    }

    /**
     * @param Pago|null $pago
     */
    public function setPago(?Pago $pago): void
    {
        $this->pago = $pago;
    }

    /**
     * @return Reservacion|null
     */
    public function getReservacion(): ?Reservacion
    {
        return $this->reservacion;
    }

    /**
     * @param Reservacion|null $reservacion
     */
    public function setReservacion(?Reservacion $reservacion): void
    {
        $this->reservacion = $reservacion;
    }


}
