<?php

namespace App\Entity\Catalogo;

use App\Entity\BaseCatalogo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sq_catalogo.tbn_tipo_ruta")
 */
class TipoRuta extends BaseCatalogo
{
    /**
     * @ORM\Column(type="string", nullable=false, length="50")
     */
    private ?string $tipoRuta;

    public function getTipoRuta()
    {
        return $this->tipoRuta;
    }

    public function setTipoRuta($tipoRuta)
    {
        $this->tipoRuta = $tipoRuta;

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
