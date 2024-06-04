<?php

namespace App\Entity\Configuracion;

use App\Entity\BaseEntity;

//use App\Entity\Estructura\Provincia;
//use App\Entity\Estructura\Municipio;
//use App\Entity\Estructura\CategoriaEstructura;
//use App\Entity\Estructura\Estructura;
//use App\Entity\Estructura\Responsabilidad;
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
 * @ORM\Table(name="tbd_servicio")
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
     * @ORM\ManyToOne(targetEntity="TipoServicio")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private ?TipoServicio $tipoServicio;

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
     * @ORM\Column(type="string", nullable=true)
     */
    protected $fecha;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $locacion = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $telefonoAuspiciador = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $cantidadParticipantes;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $orden;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $cantidadPlantosPersonas;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $cantidadTragosPersonas;
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $gestionarBuffet = false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $ambientacion = false;

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
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * @return string|null
     */
    public function getLocacion(): ?string
    {
        return $this->locacion;
    }

    /**
     * @param string|null $locacion
     */
    public function setLocacion(?string $locacion): void
    {
        $this->locacion = $locacion;
    }

    /**
     * @return string|null
     */
    public function getTelefonoAuspiciador(): ?string
    {
        return $this->telefonoAuspiciador;
    }

    /**
     * @param string|null $telefonoAuspiciador
     */
    public function setTelefonoAuspiciador(?string $telefonoAuspiciador): void
    {
        $this->telefonoAuspiciador = $telefonoAuspiciador;
    }

    /**
     * @return int|null
     */
    public function getCantidadParticipantes(): ?int
    {
        return $this->cantidadParticipantes;
    }

    /**
     * @param int|null $cantidadParticipantes
     */
    public function setCantidadParticipantes(?int $cantidadParticipantes): void
    {
        $this->cantidadParticipantes = $cantidadParticipantes;
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
    public function getCantidadPlantosPersonas(): ?int
    {
        return $this->cantidadPlantosPersonas;
    }

    /**
     * @param int|null $cantidadPlantosPersonas
     */
    public function setCantidadPlantosPersonas(?int $cantidadPlantosPersonas): void
    {
        $this->cantidadPlantosPersonas = $cantidadPlantosPersonas;
    }

    /**
     * @return int|null
     */
    public function getCantidadTragosPersonas(): ?int
    {
        return $this->cantidadTragosPersonas;
    }

    /**
     * @param int|null $cantidadTragosPersonas
     */
    public function setCantidadTragosPersonas(?int $cantidadTragosPersonas): void
    {
        $this->cantidadTragosPersonas = $cantidadTragosPersonas;
    }

    /**
     * @return bool|null
     */
    public function getGestionarBuffet(): ?bool
    {
        return $this->gestionarBuffet;
    }

    /**
     * @param bool|null $gestionarBuffet
     */
    public function setGestionarBuffet(?bool $gestionarBuffet): void
    {
        $this->gestionarBuffet = $gestionarBuffet;
    }

    /**
     * @return bool|null
     */
    public function getAmbientacion(): ?bool
    {
        return $this->ambientacion;
    }

    /**
     * @param bool|null $ambientacion
     */
    public function setAmbientacion(?bool $ambientacion): void
    {
        $this->ambientacion = $ambientacion;
    }

    /**
     * @return TipoServicio|null
     */
    public function getTipoServicio(): ?TipoServicio
    {
        return $this->tipoServicio;
    }

    /**
     * @param TipoServicio|null $tipoServicio
     */
    public function setTipoServicio(?TipoServicio $tipoServicio): void
    {
        $this->tipoServicio = $tipoServicio;
    }


}
