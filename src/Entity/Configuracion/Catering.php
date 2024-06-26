<?php

namespace App\Entity\Configuracion;

use App\Entity\BaseEntity;
use App\Entity\BaseNomenclator;
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
 * @ORM\Table(name="tbd_catering")
 */
class Catering extends BaseNomenclator
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Configuracion\TipoCatering")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?TipoCatering $tipoCatering;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $fecha;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $cantidadParticipantes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $cantidadPlantosPersonas;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $cantidadTragosPersonas;

    /**
     * @return TipoCatering|null
     */
    public function getTipoCatering(): ?TipoCatering
    {
        return $this->tipoCatering;
    }

    /**
     * @param TipoCatering|null $tipoCatering
     */
    public function setTipoCatering(?TipoCatering $tipoCatering): void
    {
        $this->tipoCatering = $tipoCatering;
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


}
