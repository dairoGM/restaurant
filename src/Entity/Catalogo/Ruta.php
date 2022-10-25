<?php

namespace App\Entity\Catalogo;

use App\Entity\BaseCatalogo;
use App\Entity\Estructura\Provincia;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbd_ruta")
 */
class Ruta extends BaseCatalogo
{
    /**
     * @ORM\Column(type="string", nullable=false, length="50")
     */
    private ?string $keyRuta;

    /**
     * @ORM\Column(type="string", nullable=false, length="50")
     */
    private ?string $keyRutaNueva;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Catalogo\Region")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Region $region = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Catalogo\ClasificacionRuta")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?ClasificacionRuta $clasificacionRuta = null;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Catalogo\TipoRuta")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?TipoRuta $tiponRuta = null;


    public function getKeyRuta()
    {
        return $this->keyRuta;
    }

    public function setKeyRuta($keyRuta)
    {
        $this->keyRuta = $keyRuta;

        return $this;
    }

    public function getKeyRutaNueva()
    {
        return $this->keyRutaNueva;
    }

    public function setKeyRutaNueva($keyRutaNueva)
    {
        $this->keyRutaNueva = $keyRutaNueva;

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

    public function getClasificacionRuta()
    {
        return $this->clasificacionRuta;
    }

    public function setClasificacionRuta($clasificacionRuta)
    {
        $this->clasificacionRuta = $clasificacionRuta;

        return $this;
    }

    public function getTipoRuta()
    {
        return $this->tiponRuta;
    }

    public function setTipoRuta($tiponRuta)
    {
        $this->tiponRuta = $tiponRuta;

        return $this;
    }
}
