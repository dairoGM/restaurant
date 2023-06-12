<?php

namespace App\Entity\Catalogo;

use App\Entity\BaseCatalogo;
use App\Entity\Estructura\Provincia;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sq_catalogo.tbn_tipo_identificador_fiscal")
 */
class TipoIdentificadorFiscal extends BaseCatalogo
{
    /**
     * @ORM\Column(type="string", nullable=true, length="50")
     */
    private ?string $descripcion;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Catalogo\Pais")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Pais $paisId = null;


    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }


    public function getPais()
    {
        return $this->paisId;
    }

    public function setPais($paisId)
    {
        $this->paisId = $paisId;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Catalogo\Compania")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Compania $compania = null;

    /**
     * @return Compania|null
     */
    public function getCompania(): ?Compania
    {
        return $this->compania;
    }

    /**
     * @param Compania|null $compania
     */
    public function setCompania(?Compania $compania): void
    {
        $this->compania = $compania;
    }
}
