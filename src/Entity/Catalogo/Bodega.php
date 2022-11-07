<?php

namespace App\Entity\Catalogo;

use App\Entity\BaseCatalogo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbd_bodega")
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
}
