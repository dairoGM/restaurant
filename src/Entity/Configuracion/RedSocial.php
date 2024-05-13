<?php

namespace App\Entity\Configuracion;

use App\Entity\BaseNomenclator;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbd_red_social")
 */
class RedSocial
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected ?int $id;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private ?string $nombre = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $enlace;
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $activo = true;

    public function getActivo()
    {
        return $this->activo;
    }

    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnlace(): ?string
    {
        return $this->enlace;
    }

    public function setEnlace(string $enlace): self
    {
        $this->enlace = $enlace;

        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }


}
