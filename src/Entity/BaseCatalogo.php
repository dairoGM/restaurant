<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass()
 */
abstract class BaseCatalogo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected ?int $id;

    /**
     * @ORM\Column(type="string", nullable=false, length="10")
     * @Assert\Regex(
     *           pattern= "/^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s]+$/",
     *           match=   true,
     *           message= "Caracteres no válidos, por favor verifique."
     * )
     */
    protected ?string $clave = null;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $creado;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $actualizado;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected ?bool $activo = true;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreado()
    {
        return $this->creado;
    }

    public function getActualizado()
    {
        return $this->actualizado;
    }


    public function getActivo()
    {
        return $this->activo;
    }

    public function getClave()
    {
        return $this->clave;
    }

    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }
}
