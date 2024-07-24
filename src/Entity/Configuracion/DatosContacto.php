<?php

namespace App\Entity\Configuracion;

use App\Entity\BaseNomenclator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbd_datos_contacto")
 */
class DatosContacto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected ?int $id;
    /**
     * @ORM\Column(type="string")
     */
    private $telefono;

    /**
     * @ORM\Column(type="string")
     */
    private $telefonoCelular;
    /**
     * @ORM\Column(type="string")
     */
    private $correo;
    /**
     * @ORM\Column(type="string")
     */
    private $direccionPostal;
    /**
     * @ORM\Column(type="string")
     */
    private $urlGoogle;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return mixed
     */
    public function getTelefonoCelular()
    {
        return $this->telefonoCelular;
    }

    /**
     * @param mixed $telefonoCelular
     */
    public function setTelefonoCelular($telefonoCelular): void
    {
        $this->telefonoCelular = $telefonoCelular;
    }

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param mixed $correo
     */
    public function setCorreo($correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @return mixed
     */
    public function getDireccionPostal()
    {
        return $this->direccionPostal;
    }

    /**
     * @param mixed $direccionPostal
     */
    public function setDireccionPostal($direccionPostal): void
    {
        $this->direccionPostal = $direccionPostal;
    }

    /**
     * @return mixed
     */
    public function getUrlGoogle()
    {
        return $this->urlGoogle;
    }

    /**
     * @param mixed $urlGoogle
     */
    public function setUrlGoogle($urlGoogle): void
    {
        $this->urlGoogle = $urlGoogle;
    }


}
