<?php

namespace App\Entity\Configuracion;

use App\Entity\BaseEntity;
use App\Entity\BaseNomenclator;
use App\Entity\Configuracion\Espacio;
use App\Entity\Configuracion\RedSocial;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbr_menu_plato")
 */
class MenuPlato extends BaseEntity
{

    /**
     * @ORM\ManyToOne(targetEntity="Menu")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private ?Menu $menu;

    /**
     * @ORM\ManyToOne(targetEntity="Plato")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private ?Plato $plato;

    /**
     * @return Menu|null
     */
    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    /**
     * @param Menu|null $menu
     */
    public function setMenu(?Menu $menu): void
    {
        $this->menu = $menu;
    }

    /**
     * @return Plato|null
     */
    public function getPlato(): ?Plato
    {
        return $this->plato;
    }

    /**
     * @param Plato|null $plato
     */
    public function setPlato(?Plato $plato): void
    {
        $this->plato = $plato;
    }

}
