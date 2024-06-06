<?php

namespace App\Entity\Restaurant;

use App\Entity\BaseEntity;
use App\Entity\Configuracion\Espacio;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbd_reservacion_mesa")
 */
class ReservacionMesa extends BaseEntity
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $cantidadMesa;


    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $fechaReservacion;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $descripcion = null;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private ?string $estado = null;


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
    public function getCantidadMesa(): ?int
    {
        return $this->cantidadMesa;
    }

    /**
     * @param int|null $cantidadMesa
     */
    public function setCantidadMesa(?int $cantidadMesa): void
    {
        $this->cantidadMesa = $cantidadMesa;
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


}
