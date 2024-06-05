<?php

namespace App\Entity\Restaurant;

use App\Entity\BaseNomenclator;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbd_perfil")
 * @UniqueEntity(fields="usuario", message="EL valor {{ value }} ya existe. Por favor inserte otro valor.")
 */
class Perfil extends BaseNomenclator
{

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $usuario = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $clave = null;

    /**
     * @return string|null
     */
    public function getUsuario(): ?string
    {
        return $this->usuario;
    }

    /**
     * @param string|null $usuario
     */
    public function setUsuario(?string $usuario): void
    {
        $this->usuario = $usuario;
    }

    /**
     * @return string|null
     */
    public function getClave(): ?string
    {
        return $this->clave;
    }

    /**
     * @param string|null $clave
     */
    public function setClave(?string $clave): void
    {
        $this->clave = $clave;
    }


}