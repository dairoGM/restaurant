<?php

namespace App\Entity\Catalogo;

use App\Entity\BaseCatalogo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sq_catalogo.tbn_region")
 */
class Region extends BaseCatalogo
{
    /**
     * @ORM\Column(type="string", nullable=false, length="50")
     */
    private ?string $region;

    /**
     * @ORM\Column(type="string", nullable=false, length="50")
     */
    private ?string $regionNuevo;

    public function getRegion()
    {
        return $this->region;
    }

    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    public function getRegionNuevo()
    {
        return $this->regionNuevo;
    }

    public function setRegionNuevo($regionNuevo)
    {
        $this->regionNuevo = $regionNuevo;

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
