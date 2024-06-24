<?php

namespace App\Entity\Configuracion;

use App\Entity\BaseEntity;

//use App\Entity\Personal\Carrera;
//use App\Entity\Personal\CategoriaDocente;
//use App\Entity\Personal\CategoriaInvestigativa;
//use App\Entity\Personal\ClasificacionPersona;
//use App\Entity\Personal\GradoAcademico;
//use App\Entity\Personal\NivelEscolar;
//use App\Entity\Personal\Profesion;
//use App\Entity\Personal\Sexo;
use App\Entity\BaseNomenclator;
use App\Entity\Security\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbd_metodo_pago")
 */
class MetodoPago extends BaseNomenclator
{

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $numeroTarjeta;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $telefonoConfirmacion;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $tipoMoneda;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagenQk = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkPago = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Configuracion\TipoMetodoPago")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?TipoMetodoPago $tipoMetodoPago;

    /**
     * @return string|null
     */
    public function getNumeroTarjeta(): ?string
    {
        return $this->numeroTarjeta;
    }

    /**
     * @param string|null $numeroTarjeta
     */
    public function setNumeroTarjeta(?string $numeroTarjeta): void
    {
        $this->numeroTarjeta = $numeroTarjeta;
    }

    /**
     * @return string|null
     */
    public function getTelefonoConfirmacion(): ?string
    {
        return $this->telefonoConfirmacion;
    }

    /**
     * @param string|null $telefonoConfirmacion
     */
    public function setTelefonoConfirmacion(?string $telefonoConfirmacion): void
    {
        $this->telefonoConfirmacion = $telefonoConfirmacion;
    }

    /**
     * @return string|null
     */
    public function getTipoMoneda(): ?string
    {
        return $this->tipoMoneda;
    }

    /**
     * @param string|null $tipoMoneda
     */
    public function setTipoMoneda(?string $tipoMoneda): void
    {
        $this->tipoMoneda = $tipoMoneda;
    }

    /**
     * @return null
     */
    public function getImagenQk()
    {
        return $this->imagenQk;
    }

    /**
     * @param null $imagenQk
     */
    public function setImagenQk($imagenQk): void
    {
        $this->imagenQk = $imagenQk;
    }

    /**
     * @return null
     */
    public function getLinkPago()
    {
        return $this->linkPago;
    }

    /**
     * @param null $linkPago
     */
    public function setLinkPago($linkPago): void
    {
        $this->linkPago = $linkPago;
    }

    /**
     * @return TipoMetodoPago|null
     */
    public function getTipoMetodoPago(): ?TipoMetodoPago
    {
        return $this->tipoMetodoPago;
    }

    /**
     * @param TipoMetodoPago|null $tipoMetodoPago
     */
    public function setTipoMetodoPago(?TipoMetodoPago $tipoMetodoPago): void
    {
        $this->tipoMetodoPago = $tipoMetodoPago;
    }

}
