<?php

namespace App\Entity\Catalogo;

use App\Entity\BaseCatalogo;
use App\Entity\BaseEntity;
use App\Entity\Estructura\Provincia;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbr_ruta_cliente")
 */
class RutaCliente extends BaseEntity
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Catalogo\Ruta")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Ruta $ruta = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Catalogo\Cliente")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Cliente $cliente = null;


    public function getRuta()
    {
        return $this->ruta;
    }

    public function setRuta($ruta)
    {
        $this->ruta = $ruta;

        return $this;
    }


    public function getCliente()
    {
        return $this->cliente;
    }

    public function setCliente($cliente)
    {
        $this->cliente = $cliente;

        return $this;
    }

}
