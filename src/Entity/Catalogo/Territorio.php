<?php

namespace App\Entity\Catalogo;

use App\Entity\BaseCatalogo;
use App\Entity\Estructura\Provincia;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sq_catalogo.tbd_territorio")
 */
class Territorio extends BaseCatalogo
{
    /**
     * @ORM\Column(type="string", nullable=false, length="50")
     */
    private ?string $territorio;

    /**
     * @ORM\Column(type="string", nullable=false, length="50")
     */
    private ?string $territorioNuevo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Catalogo\Region")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Region $region = null;


    public function getTerritorio()
    {
        return $this->territorio;
    }

    public function setTerritorio($territorio)
    {
        $this->territorio = $territorio;

        return $this;
    }

    public function getTerritorioNuevo()
    {
        return $this->territorioNuevo;
    }

    public function setTerritorioNuevo($territorioNuevo)
    {
        $this->territorioNuevo = $territorioNuevo;

        return $this;
    }


    public function getRegion()
    {
        return $this->region;
    }

    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }


}
