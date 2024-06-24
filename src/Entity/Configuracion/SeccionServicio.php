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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbd_seccion_servicio")
 */
class SeccionServicio extends BaseEntity
{

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private ?string $nombre = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $descripcion = null;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagen = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $galeria = null;

    /**
     * @ORM\ManyToOne(targetEntity="Servicio")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private ?Servicio $servicio;

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
     * @return Servicio|null
     */
    public function getServicio(): ?Servicio
    {
        return $this->servicio;
    }

    /**
     * @param Servicio|null $servicio
     */
    public function setServicio(?Servicio $servicio): void
    {
        $this->servicio = $servicio;
    }

    /**
     * @return string|null
     */
    public function getGaleria(): ?string
    {
        return $this->galeria;
    }

    /**
     * @param string|null $galeria
     */
    public function setGaleria(?string $galeria): void
    {
        $this->galeria = $galeria;
    }


}
