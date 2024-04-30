<?php

namespace App\Entity\Configuracion;

use App\Entity\BaseEntity;
use App\Entity\Estructura\Provincia;
use App\Entity\Estructura\Municipio;
use App\Entity\Estructura\CategoriaEstructura;
use App\Entity\Estructura\Estructura;
use App\Entity\Estructura\Responsabilidad;
use App\Entity\Personal\Carrera;
use App\Entity\Personal\CategoriaDocente;
use App\Entity\Personal\CategoriaInvestigativa;
use App\Entity\Personal\ClasificacionPersona;
use App\Entity\Personal\GradoAcademico;
use App\Entity\Personal\NivelEscolar;
use App\Entity\Personal\Profesion;
use App\Entity\Personal\Sexo;
use App\Entity\Security\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="sq_configuracion.tbd_servicio")
 */
class Servicio extends BaseEntity
{
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagenPortada = null;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagenDetallada = null;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $activo = true;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $publico = false;

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



}