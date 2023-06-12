<?php

namespace App\Entity\Catalogo;

use App\Entity\BaseNomenclator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbn_banco")
 */
class Banco extends BaseNomenclator
{


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




}
