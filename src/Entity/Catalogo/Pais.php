<?php

namespace App\Entity\Catalogo;

use App\Entity\BaseNomenclator;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbn_pais")
 * @UniqueEntity(fields="siglas", message="EL valor {{ value }} ya existe. Por favor inserte otro valor.")
 * @UniqueEntity(fields="codigo", message="EL valor {{ value }} ya existe. Por favor inserte otro valor.")
 */
class Pais extends BaseNomenclator
{


    /**
     * @ORM\Column(type="string", nullable=false, length="2")
     * @Assert\Regex(
     *           pattern= "/^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s]+$/",
     *           match=   true,
     *           message= "Caracteres no válidos, por favor verifique."
     * )
     */
    private ?string $iso2;

    /**
     * @ORM\Column(type="string", nullable=false, length="3")
     * @Assert\Regex(
     *           pattern= "/^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s]+$/",
     *           match=   true,
     *           message= "Caracteres no válidos, por favor verifique."
     * )
     */
    private ?string $iso3;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $extId;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $codigoTelefonico;


    public function getIso2()
    {
        return $this->iso2;
    }

    public function setIso2($iso2)
    {
        $this->iso2 = $iso2;

        return $this;
    }

    public function getExtId()
    {
        return $this->extId;
    }

    public function setExtId($extId)
    {
        $this->extId = $extId;

        return $this;
    }


    public function getIso3()
    {
        return $this->iso3;
    }

    public function setIso3($iso3)
    {
        $this->iso3 = $iso3;

        return $this;
    }

    public function getCodigoTelefonico()
    {
        return $this->codigoTelefonico;
    }

    public function setCodigoTelefonico($codigoTelefonico)
    {
        $this->codigoTelefonico = $codigoTelefonico;

        return $this;
    }
}
