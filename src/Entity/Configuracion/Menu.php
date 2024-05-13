<?php

namespace App\Entity\Configuracion;

use App\Entity\BaseNomenclator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbd_menu")
 */
class Menu extends BaseNomenclator
{
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $publico = false;

    /**
     * @ORM\ManyToOne(targetEntity="Espacio")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Espacio $espacio;

    /**
     * @return bool|null
     */
    public function getPublico(): ?bool
    {
        return $this->publico;
    }

    /**
     * @param bool|null $publico
     */
    public function setPublico(?bool $publico): void
    {
        $this->publico = $publico;
    }

    /**
     * @return Espacio|null
     */
    public function getEspacio(): ?Espacio
    {
        return $this->espacio;
    }

    /**
     * @param Espacio|null $espacio
     */
    public function setEspacio(?Espacio $espacio): void
    {
        $this->espacio = $espacio;
    }


}
