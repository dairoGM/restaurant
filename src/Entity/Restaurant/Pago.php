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
 * @ORM\Table(name="tbd_pago")
 */
class Pago extends BaseEntity
{

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $nombreCompleto = null;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $alias = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $dni = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $celular = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $numeroTransferencia = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Configuracion\MetodoPago")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?MetodoPago $metodoPago;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $ticket = null;

    /**
     * @return string|null
     */
    public function getNombreCompleto(): ?string
    {
        return $this->nombreCompleto;
    }

    /**
     * @param string|null $nombreCompleto
     */
    public function setNombreCompleto(?string $nombreCompleto): void
    {
        $this->nombreCompleto = $nombreCompleto;
    }

    /**
     * @return string|null
     */
    public function getAlias(): ?string
    {
        return $this->alias;
    }

    /**
     * @param string|null $alias
     */
    public function setAlias(?string $alias): void
    {
        $this->alias = $alias;
    }

    /**
     * @return string|null
     */
    public function getDni(): ?string
    {
        return $this->dni;
    }

    /**
     * @param string|null $dni
     */
    public function setDni(?string $dni): void
    {
        $this->dni = $dni;
    }

    /**
     * @return string|null
     */
    public function getCelular(): ?string
    {
        return $this->celular;
    }

    /**
     * @param string|null $celular
     */
    public function setCelular(?string $celular): void
    {
        $this->celular = $celular;
    }

    /**
     * @return string|null
     */
    public function getNumeroTransferencia(): ?string
    {
        return $this->numeroTransferencia;
    }

    /**
     * @param string|null $numeroTransferencia
     */
    public function setNumeroTransferencia(?string $numeroTransferencia): void
    {
        $this->numeroTransferencia = $numeroTransferencia;
    }

    /**
     * @return MetodoPago|null
     */
    public function getMetodoPago(): ?MetodoPago
    {
        return $this->metodoPago;
    }

    /**
     * @param MetodoPago|null $metodoPago
     */
    public function setMetodoPago(?MetodoPago $metodoPago): void
    {
        $this->metodoPago = $metodoPago;
    }

    /**
     * @return string|null
     */
    public function getTicket(): ?string
    {
        return $this->ticket;
    }

    /**
     * @param string|null $ticket
     */
    public function setTicket(?string $ticket): void
    {
        $this->ticket = $ticket;
    }

}
