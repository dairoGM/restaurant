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
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Perfil $perfil;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Configuracion\Espacio")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Espacio $espacio;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $cantidadPersona;


    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $fechaReservacion;

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


}
