<?php

namespace App\Entity\Catalogo;

use App\Entity\BaseCatalogo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sq_catalogo.tbd_bodega")
 */
class Bodega extends BaseCatalogo
{

    /**
     * @ORM\Column(type="string", nullable=true, length="50")
     */
    private ?string $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Catalogo\Cedis")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Cedis $cedis = null;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Catalogo\Compania")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Compania $compania = null;

    public function getCedis()
    {
        return $this->cedis;
    }

    public function setCedis($cedis)
    {
        $this->cedis = $cedis;

        return $this;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

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
