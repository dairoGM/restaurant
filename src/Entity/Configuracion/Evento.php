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
 * @ORM\Table(name="tbd_evento")
 */
class Evento extends BaseNomenclator
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Configuracion\TipoEvento")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?TipoEvento $tipoEvento;

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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $gestionarBuffet = false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $ambientacion = false;

    /**
     * @return TipoEvento|null
     */
    public function getTipoEvento(): ?TipoEvento
    {
        return $this->tipoEvento;
    }

    /**
     * @param TipoEvento|null $tipoEvento
     */
    public function setTipoEvento(?TipoEvento $tipoEvento): void
    {
        $this->tipoEvento = $tipoEvento;
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


}