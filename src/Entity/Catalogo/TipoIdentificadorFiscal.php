<?php

namespace App\Entity\Catalogo;

use App\Entity\BaseCatalogo;
use App\Entity\Estructura\Provincia;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbn_tipo_identificador_fiscal")
 */
class TipoIdentificadorFiscal extends BaseCatalogo
{
    /**
     * @ORM\Column(type="string", nullable=false, length="50")
     */
    private ?string $descripcion;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Catalogo\Pais")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Pais $paisId = null;


    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }


    public function getPais()
    {
        return $this->paisId;
    }

    public function setPais($paisId)
    {
        $this->paisId = $paisId;

        return $this;
    }
}
