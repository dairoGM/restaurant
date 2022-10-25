<?php

namespace App\Entity\Catalogo;

use App\Entity\BaseCatalogo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbn_clasificacion_ruta")
 */
class ClasificacionRuta extends BaseCatalogo
{
    /**
     * @ORM\Column(type="string", nullable=false, length="50")
     */
    private ?string $clasificacionRuta;

    /**
     * @ORM\Column(type="string", nullable=false, length="50")
     */
    private ?string $clasificacionRutaNueva;


    public function getClasificacionRuta()
    {
        return $this->clasificacionRuta;
    }

    public function setClasificacionRuta($clasificacionRuta)
    {
        $this->clasificacionRuta = $clasificacionRuta;

        return $this;
    }

    public function getClasificacionRutaNueva()
    {
        return $this->clasificacionRutaNueva;
    }

    public function setClasificacionRutaNueva($clasificacionRutaNueva)
    {
        $this->clasificacionRutaNueva = $clasificacionRutaNueva;

        return $this;
    }
}
