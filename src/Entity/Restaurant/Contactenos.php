<?php

namespace App\Entity\Restaurant;

use App\Entity\BaseEntity;
use App\Entity\BaseNomenclator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sq_restaurant.tbd_contactenos")
 */
class Contactenos extends BaseEntity
{


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $nombre = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $correo = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $mensaje = null;

    /**
     * @return string|null
     */
    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    /**
     * @param string|null $correo
     */
    public function setCorreo(?string $correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @return string|null
     */
    public function getMensaje(): ?string
    {
        return $this->mensaje;
    }

    /**
     * @param string|null $mensaje
     */
    public function setMensaje(?string $mensaje): void
    {
        $this->mensaje = $mensaje;
    }

    /**
     * @return string|null
     */
    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    /**
     * @param string|null $nombre
     */
    public function setNombre(?string $nombre): void
    {
        $this->nombre = $nombre;
    }


}