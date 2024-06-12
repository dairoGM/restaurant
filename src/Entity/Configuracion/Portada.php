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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagen2 = null;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagen3 = null;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagen4 = null;

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

}
