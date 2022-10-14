<?php

namespace App\Entity\Personal;

use App\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="personal.tbd_datos_fuc")
 */
class DatosFuc extends BaseEntity
{
    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     */
    private ?string $idFuc;

    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     */
    private ?string $carnetIdentidad;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private ?string $nombreCompleto;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $fechaNacimiento;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $codigoSexo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $codidoProvincia;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $codidoMunicipio;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $direccion;    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdFuc(): ?string
    {
        return $this->idFuc;
    }

    public function setIdFuc(string $idFuc): self
    {
        $this->idFuc = $idFuc;

        return $this;
    }

    public function getCarnetIdentidad(): ?string
    {
        return $this->carnetIdentidad;
    }

    public function setCarnetIdentidad(string $carnetIdentidad): self
    {
        $this->carnetIdentidad = $carnetIdentidad;

        return $this;
    }
 
    public function getNombreCompleto()
    {
        return $this->nombreCompleto;
    }
   
    public function setNombreCompleto($nombreCompleto)
    {
        $this->nombreCompleto = $nombreCompleto;

        return $this;
    }

    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    public function getCodigoSexo()
    {
        return $this->codigoSexo;
    }

    public function setCodigoSexo($codigoSexo)
    {
        $this->codigoSexo = $codigoSexo;

        return $this;
    }
   
    public function getCodidoProvincia()
    {
        return $this->codidoProvincia;
    }

    public function setCodidoProvincia($codidoProvincia)
    {
        $this->codidoProvincia = $codidoProvincia;

        return $this;
    }

    public function getCodidoMunicipio()
    {
        return $this->codidoMunicipio;
    }
    
    public function setCodidoMunicipio($codidoMunicipio)
    {
        $this->codidoMunicipio = $codidoMunicipio;

        return $this;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }
    
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }
}
