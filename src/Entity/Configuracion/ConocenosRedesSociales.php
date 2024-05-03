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
 * @ORM\Table(name="sq_configuracion.tbr_conocenos_redes_sociales")
 */
class ConocenosRedesSociales extends BaseEntity
{

    /**
     * @ORM\ManyToOne(targetEntity="Conocenos")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Conocenos $conocenos;

    /**
     * @ORM\ManyToOne(targetEntity="RedSocial")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?RedSocial $redSocial;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $enlace;

    /**
     * @return Conocenos|null
     */
    public function getConocenos(): ?Conocenos
    {
        return $this->conocenos;
    }

    /**
     * @param Conocenos|null $conocenos
     */
    public function setConocenos(?Conocenos $conocenos): void
    {
        $this->conocenos = $conocenos;
    }

    /**
     * @return \App\Entity\Configuracion\RedSocial|null
     */
    public function getRedSocial(): ?\App\Entity\Configuracion\RedSocial
    {
        return $this->redSocial;
    }

    /**
     * @param \App\Entity\Configuracion\RedSocial|null $redSocial
     */
    public function setRedSocial(?\App\Entity\Configuracion\RedSocial $redSocial): void
    {
        $this->redSocial = $redSocial;
    }

    /**
     * @return mixed
     */
    public function getEnlace()
    {
        return $this->enlace;
    }

    /**
     * @param mixed $enlace
     */
    public function setEnlace($enlace): void
    {
        $this->enlace = $enlace;
    }

}
