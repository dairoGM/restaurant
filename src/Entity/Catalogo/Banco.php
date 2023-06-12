<?php

namespace App\Entity\Catalogo;

use App\Entity\BaseNomenclator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sq_catalogo.tbn_banco")
 */
class Banco extends BaseNomenclator
{


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Catalogo\Compania")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Compania $compania = null;

    /**
     * @ORM\Column(type="string", nullable=true, length="50")
     */
    private ?string $nombreCorto;


    /**
     * @return string|null
     */
    public function getNombreCorto(): ?string
    {
        return $this->nombreCorto;
    }

    /**
     * @param string|null $nombreCorto
     */
    public function setNombreCorto(?string $nombreCorto): void
    {
        $this->nombreCorto = $nombreCorto;
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
