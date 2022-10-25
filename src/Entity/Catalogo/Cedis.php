<?php

namespace App\Entity\Catalogo;

use App\Entity\BaseCatalogo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbd_cedis")
 */
class Cedis extends BaseCatalogo
{
    /**
     * @ORM\Column(type="string", nullable=false, length="50")
     */
    private ?string $cedis;

    /**
     * @ORM\Column(type="string", nullable=false, length="50")
     */
    private ?string $cedisNuevo;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Catalogo\Territorio")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Territorio $territorio = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Catalogo\Grupo")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Grupo $grupo = null;

    public function getCedisNuevo()
    {
        return $this->cedisNuevo;
    }

    public function setCedisNuevo($cedisNuevo)
    {
        $this->cedisNuevo = $cedisNuevo;

        return $this;
    }

    public function getCedis()
    {
        return $this->cedis;
    }

    public function setCedis($cedis)
    {
        $this->cedis = $cedis;

        return $this;
    }

    public function getTerritorio()
    {
        return $this->territorio;
    }

    public function setTerritorio($territorio)
    {
        $this->territorio = $territorio;

        return $this;
    }

    public function getGrupo()
    {
        return $this->grupo;
    }

    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;

        return $this;
    }
}
