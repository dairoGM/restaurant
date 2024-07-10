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
 * @ORM\Table(name="tbd_reservacion")
 */
class Reservacion extends BaseEntity
{

    /**
     * @ORM\ManyToOne(targetEntity="Perfil")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private ?Perfil $perfil;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Configuracion\Espacio")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private ?Espacio $espacio;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Configuracion\Plato")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private ?Plato $plato;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $cantidadPersona;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $cantidad;


    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected $fechaReservacion;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected $horaInicio;
    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected $horaFin;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $descripcion = null;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private ?string $estado = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $nombreCompleto = null;

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
    private ?string $ticket = null;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private ?string $precioUsd = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $numeroTransferencia = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $politicaCancelacion = null;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Configuracion\MetodoPago")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?MetodoPago $metodoPago;

    /**
     * @return Perfil|null
     */
    public function getPerfil(): ?Perfil
    {
        return $this->perfil;
    }

    /**
     * @param Perfil|null $perfil
     */
    public function setPerfil(?Perfil $perfil): void
    {
        $this->perfil = $perfil;
    }

    /**
     * @return Espacio|null
     */
    public function getEspacio(): ?Espacio
    {
        return $this->espacio;
    }

    /**
     * @param Espacio|null $espacio
     */
    public function setEspacio(?Espacio $espacio): void
    {
        $this->espacio = $espacio;
    }

    /**
     * @return int|null
     */
    public function getCantidadPersona(): ?int
    {
        return $this->cantidadPersona;
    }

    /**
     * @param int|null $cantidadPersona
     */
    public function setCantidadPersona(?int $cantidadPersona): void
    {
        $this->cantidadPersona = $cantidadPersona;
    }


    /**
     * @return string|null
     */
    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    /**
     * @param string|null $descripcion
     */
    public function setDescripcion(?string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return string|null
     */
    public function getEstado(): ?string
    {
        return $this->estado;
    }

    /**
     * @param string|null $estado
     */
    public function setEstado(?string $estado): void
    {
        $this->estado = $estado;
    }

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

    /**
     * @return mixed
     */
    public function getFechaReservacion()
    {
        return $this->fechaReservacion;
    }

    /**
     * @param mixed $fechaReservacion
     */
    public function setFechaReservacion($fechaReservacion): void
    {
        $this->fechaReservacion = $fechaReservacion;
    }

    /**
     * @return mixed
     */
    public function getHoraInicio()
    {
        return $this->horaInicio;
    }

    /**
     * @param mixed $horaInicio
     */
    public function setHoraInicio($horaInicio): void
    {
        $this->horaInicio = $horaInicio;
    }

    /**
     * @return mixed
     */
    public function getHoraFin()
    {
        return $this->horaFin;
    }

    /**
     * @param mixed $horaFin
     */
    public function setHoraFin($horaFin): void
    {
        $this->horaFin = $horaFin;
    }

    /**
     * @return string|null
     */
    public function getPrecioUsd(): ?string
    {
        return $this->precioUsd;
    }

    /**
     * @param string|null $precioUsd
     */
    public function setPrecioUsd(?string $precioUsd): void
    {
        $this->precioUsd = $precioUsd;
    }

    /**
     * @return string|null
     */
    public function getPoliticaCancelacion(): ?string
    {
        return $this->politicaCancelacion;
    }

    /**
     * @param string|null $politicaCancelacion
     */
    public function setPoliticaCancelacion(?string $politicaCancelacion): void
    {
        $this->politicaCancelacion = $politicaCancelacion;
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
     * @return Plato|null
     */
    public function getPlato(): ?Plato
    {
        return $this->plato;
    }

    /**
     * @param Plato|null $plato
     */
    public function setPlato(?Plato $plato): void
    {
        $this->plato = $plato;
    }

    /**
     * @return int|null
     */
    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    /**
     * @param int|null $cantidad
     */
    public function setCantidad(?int $cantidad): void
    {
        $this->cantidad = $cantidad;
    }


}
