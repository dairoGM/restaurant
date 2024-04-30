<?php

namespace App\Entity\Configuracion;

use App\Entity\BaseEntity;
use App\Entity\BaseNomenclator;
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
 * @ORM\Table(name="sq_configuracion.tbd_experiencia_gastronomica")
 */
class ExperienciaGastronomica extends BaseNomenclator
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Configuracion\TipoExperienciaGastronomica")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?TipoExperienciaGastronomica $tipoExperienciaGastronomica;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $fecha;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $cantidadParticipantes;

    /**
     * @return TipoExperienciaGastronomica|null
     */
    public function getTipoExperienciaGastronomica(): ?TipoExperienciaGastronomica
    {
        return $this->tipoExperienciaGastronomica;
    }

    /**
     * @param TipoExperienciaGastronomica|null $tipoExperienciaGastronomica
     */
    public function setTipoExperienciaGastronomica(?TipoExperienciaGastronomica $tipoExperienciaGastronomica): void
    {
        $this->tipoExperienciaGastronomica = $tipoExperienciaGastronomica;
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


}
