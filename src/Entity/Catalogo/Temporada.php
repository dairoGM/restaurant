<?php

namespace App\Entity\Catalogo;

use App\Entity\BaseCatalogo;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbd_temporada")
 */
class Temporada extends BaseCatalogo
{

    /**
     * @ORM\Column(type="string", nullable=true, length="50")
     */
    private ?string $descripcion;

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $fechaInicio;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $fechaFin;

    public function __construct()
    {
        $this->fechaInicio = new \DateTime();
        $this->fechaFin = new \DateTime();
    }

    /**
     * Get the value of fechaInicio
     */
    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fechaInicio;
    }

    /**
     * Set the value of fechaInicio
     *
     * @return  self
     */
    public function setFechaInicio(\DateTimeInterface $fechaInicio): self
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }


    /**
     * Get the value of fechaFin
     */
    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fechaFin;
    }

    /**
     * Set the value of fechaFin
     *
     * @return  self
     */
    public function setFechaFin(\DateTimeInterface $fechaFin): self
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }
}
