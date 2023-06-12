<?php

namespace App\Entity\Catalogo;

use App\Entity\BaseCatalogo;
use App\Entity\Estructura\Provincia;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sq_catalogo.tbd_cliente")
 */
class Cliente extends BaseCatalogo
{
    /**
     * @ORM\Column(type="string", nullable=false, length="50")
     */
    private ?string $nombre;

    /**
     * @ORM\Column(type="string", nullable=false, length="50")
     */
    private ?string $identificadorFiscal;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Catalogo\TipoIdentificadorFiscal")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?TipoIdentificadorFiscal $tipoIdentificadorFiscal = null;


    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getIdentificadorFiscal()
    {
        return $this->identificadorFiscal;
    }

    public function setIdentificadorFiscal($identificadorFiscal)
    {
        $this->identificadorFiscal = $identificadorFiscal;

        return $this;
    }

    public function getTipoIdentificadorFiscal()
    {
        return $this->tipoIdentificadorFiscal;
    }

    public function setTipoIdentificadorFiscal($tipoIdentificadorFiscal)
    {
        $this->tipoIdentificadorFiscal = $tipoIdentificadorFiscal;

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
