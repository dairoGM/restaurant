<?php

namespace App\Entity\Personal;

use App\Entity\BaseEntity;
use App\Entity\Estructura\Provincia;
use App\Entity\Estructura\Municipio;
use App\Entity\Estructura\CategoriaEstructura;
use App\Entity\Estructura\Estructura;
use App\Entity\Estructura\Responsabilidad;
use App\Entity\Security\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="sq_personal.tbd_cliente")
 */
class Cliente extends BaseEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="Persona")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Persona $persona;

    /**
     * @return Persona|null
     */
    public function getPersona(): ?Persona
    {
        return $this->persona;
    }

    /**
     * @param Persona|null $persona
     */
    public function setPersona(?Persona $persona): void
    {
        $this->persona = $persona;
    }




}
