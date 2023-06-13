<?php

namespace App\Entity\Catalogo;

use App\Entity\BaseNomenclator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sq_catalogo.tbn_sucursal")
 */
class Sucursal extends BaseNomenclator
{


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
