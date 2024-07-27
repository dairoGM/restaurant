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
 * @ORM\Table(name="tbr_espacio_redes_sociales")
 */
class EspacioRedesSociales extends BaseEntity
{

    /**
     * @ORM\ManyToOne(targetEntity="Espacio")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Espacio $espacio;

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
     * @ORM\Column(type="string", nullable=true)
     */
    protected $nombreCorto;

    /**
     * @return \App\Entity\Configuracion\Espacio|null
     */
    public function getEspacio(): ?\App\Entity\Configuracion\Espacio
    {
        return $this->espacio;
    }

    /**
     * @param \App\Entity\Configuracion\Espacio|null $espacio
     */
    public function setEspacio(?\App\Entity\Configuracion\Espacio $espacio): void
    {
        $this->espacio = $espacio;
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

    /**
     * @return mixed
     */
    public function getNombreCorto()
    {
        return $this->nombreCorto;
    }

    /**
     * @param mixed $nombreCorto
     */
    public function setNombreCorto($nombreCorto): void
    {
        $this->nombreCorto = $nombreCorto;
    }

}
