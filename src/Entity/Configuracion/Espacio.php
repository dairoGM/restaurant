<?php

namespace App\Entity\Configuracion;

use App\Entity\BaseEntity;

//use App\Entity\Personal\Carrera;
//use App\Entity\Personal\CategoriaDocente;
//use App\Entity\Personal\CategoriaInvestigativa;
//use App\Entity\Personal\ClasificacionPersona;
//use App\Entity\Personal\GradoAcademico;
//use App\Entity\Personal\NivelEscolar;
//use App\Entity\Personal\Profesion;
//use App\Entity\Personal\Sexo;
use App\Entity\Security\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbd_espacio")
 */
class Espacio extends BaseEntity
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $categoria;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $nombreCorto;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $nombreLargo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $descripcion;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $codigoReel;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagenPortada = null;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagenDetallada = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagenBanner = null;
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $activo = true;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $reservar = true;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $publico = false;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $orden;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $cantidadMesa;

    /**
     * @return string|null
     */
    public function getNombreCorto(): ?string
    {
        return $this->nombreCorto;
    }

    /**
     * @param string|null $nombreCorto
     */
    public function setNombreCorto(?string $nombreCorto): void
    {
        $this->nombreCorto = $nombreCorto;
    }

    /**
     * @return string|null
     */
    public function getNombreLargo(): ?string
    {
        return $this->nombreLargo;
    }

    /**
     * @param string|null $nombreLargo
     */
    public function setNombreLargo(?string $nombreLargo): void
    {
        $this->nombreLargo = $nombreLargo;
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
     * @return null
     */
    public function getImagenPortada()
    {
        return $this->imagenPortada;
    }

    /**
     * @param null $imagenPortada
     */
    public function setImagenPortada($imagenPortada): void
    {
        $this->imagenPortada = $imagenPortada;
    }

    /**
     * @return null
     */
    public function getImagenDetallada()
    {
        return $this->imagenDetallada;
    }

    /**
     * @param null $imagenDetallada
     */
    public function setImagenDetallada($imagenDetallada): void
    {
        $this->imagenDetallada = $imagenDetallada;
    }

    /**
     * @return bool|null
     */
    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    /**
     * @param bool|null $activo
     */
    public function setActivo(?bool $activo): void
    {
        $this->activo = $activo;
    }

    /**
     * @return bool|null
     */
    public function getPublico(): ?bool
    {
        return $this->publico;
    }

    /**
     * @param bool|null $publico
     */
    public function setPublico(?bool $publico): void
    {
        $this->publico = $publico;
    }

    /**
     * @return int|null
     */
    public function getOrden(): ?int
    {
        return $this->orden;
    }

    /**
     * @param int|null $orden
     */
    public function setOrden(?int $orden): void
    {
        $this->orden = $orden;
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
     * @return string|null
     */
    public function getCategoria(): ?string
    {
        return $this->categoria;
    }

    /**
     * @param string|null $categoria
     */
    public function setCategoria(?string $categoria): void
    {
        $this->categoria = $categoria;
    }


    /**
     * @return null
     */
    public function getImagenBanner()
    {
        return $this->imagenBanner;
    }

    /**
     * @param null $imagenBanner
     */
    public function setImagenBanner($imagenBanner): void
    {
        $this->imagenBanner = $imagenBanner;
    }

    /**
     * @return bool|null
     */
    public function getReservar(): ?bool
    {
        return $this->reservar;
    }

    /**
     * @param bool|null $reservar
     */
    public function setReservar(?bool $reservar): void
    {
        $this->reservar = $reservar;
    }

    /**
     * @return string|null
     */
    public function getCodigoReel(): ?string
    {
        return $this->codigoReel;
    }

    /**
     * @param string|null $codigoReel
     */
    public function setCodigoReel(?string $codigoReel): void
    {
        $this->codigoReel = $codigoReel;
    }


}
