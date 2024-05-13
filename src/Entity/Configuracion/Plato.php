<?php

namespace App\Entity\Configuracion;

use App\Entity\BaseEntity;
use App\Entity\BaseNomenclator;
use App\Entity\Estructura\Provincia;
use App\Entity\Estructura\Municipio;
use App\Entity\Estructura\CategoriaEstructura;
use App\Entity\Estructura\Estructura;
use App\Entity\Estructura\Responsabilidad;
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
 * @ORM\Table(name="tbd_plato")
 */
class Plato extends BaseNomenclator
{

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagen = null;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $precio = null;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $publico = false;

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
     * @return null
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param null $precio
     */
    public function setPrecio($precio): void
    {
        $this->precio = $precio;
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
