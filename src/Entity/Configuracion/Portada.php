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
 * @ORM\Table(name="tbd_portada")
 */
class Portada extends BaseEntity
{
    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private ?bool $activo = true;
    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private ?bool $publico = false;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $descripcion;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagen = null;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $tituloImagen;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $descripcionImagen;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagen2 = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $tituloImagen2;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $descripcionImagen2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagen3 = null;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $tituloImagen3;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $descripcionImagen3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagen4 = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $tituloImagen4;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $descripcionImagen4;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagenFooter = null;

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
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * @param null $imagen
     */
    public function setImagen($imagen): void
    {
        $this->imagen = $imagen;
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
     * @return null
     */
    public function getImagen2()
    {
        return $this->imagen2;
    }

    /**
     * @param null $imagen2
     */
    public function setImagen2($imagen2): void
    {
        $this->imagen2 = $imagen2;
    }

    /**
     * @return null
     */
    public function getImagen3()
    {
        return $this->imagen3;
    }

    /**
     * @param null $imagen3
     */
    public function setImagen3($imagen3): void
    {
        $this->imagen3 = $imagen3;
    }

    /**
     * @return null
     */
    public function getImagen4()
    {
        return $this->imagen4;
    }

    /**
     * @param null $imagen4
     */
    public function setImagen4($imagen4): void
    {
        $this->imagen4 = $imagen4;
    }

    public function getImagenFooter()
    {
        return $this->imagenFooter;
    }

    /**
     * @param null $imagenFooter
     */
    public function setImagenFooter($imagenFooter): void
    {
        $this->imagenFooter = $imagenFooter;
    }

    /**
     * @return string|null
     */
    public function getTituloImagen(): ?string
    {
        return $this->tituloImagen;
    }

    /**
     * @param string|null $tituloImagen
     */
    public function setTituloImagen(?string $tituloImagen): void
    {
        $this->tituloImagen = $tituloImagen;
    }

    /**
     * @return string|null
     */
    public function getDescripcionImagen(): ?string
    {
        return $this->descripcionImagen;
    }

    /**
     * @param string|null $descripcionImagen
     */
    public function setDescripcionImagen(?string $descripcionImagen): void
    {
        $this->descripcionImagen = $descripcionImagen;
    }

    /**
     * @return string|null
     */
    public function getTituloImagen2(): ?string
    {
        return $this->tituloImagen2;
    }

    /**
     * @param string|null $tituloImagen2
     */
    public function setTituloImagen2(?string $tituloImagen2): void
    {
        $this->tituloImagen2 = $tituloImagen2;
    }

    /**
     * @return string|null
     */
    public function getDescripcionImagen2(): ?string
    {
        return $this->descripcionImagen2;
    }

    /**
     * @param string|null $descripcionImagen2
     */
    public function setDescripcionImagen2(?string $descripcionImagen2): void
    {
        $this->descripcionImagen2 = $descripcionImagen2;
    }

    /**
     * @return string|null
     */
    public function getTituloImagen3(): ?string
    {
        return $this->tituloImagen3;
    }

    /**
     * @param string|null $tituloImagen3
     */
    public function setTituloImagen3(?string $tituloImagen3): void
    {
        $this->tituloImagen3 = $tituloImagen3;
    }

    /**
     * @return string|null
     */
    public function getDescripcionImagen3(): ?string
    {
        return $this->descripcionImagen3;
    }

    /**
     * @param string|null $descripcionImagen3
     */
    public function setDescripcionImagen3(?string $descripcionImagen3): void
    {
        $this->descripcionImagen3 = $descripcionImagen3;
    }

    /**
     * @return string|null
     */
    public function getTituloImagen4(): ?string
    {
        return $this->tituloImagen4;
    }

    /**
     * @param string|null $tituloImagen4
     */
    public function setTituloImagen4(?string $tituloImagen4): void
    {
        $this->tituloImagen4 = $tituloImagen4;
    }

    /**
     * @return string|null
     */
    public function getDescripcionImagen4(): ?string
    {
        return $this->descripcionImagen4;
    }

    /**
     * @param string|null $descripcionImagen4
     */
    public function setDescripcionImagen4(?string $descripcionImagen4): void
    {
        $this->descripcionImagen4 = $descripcionImagen4;
    }

}
