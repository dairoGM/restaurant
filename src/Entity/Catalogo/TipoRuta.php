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
}
