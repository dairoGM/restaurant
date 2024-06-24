<?php

namespace App\Entity\Configuracion;

use App\Entity\BaseNomenclator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tbd_tasa_cambio")
 */
class TasaCambio
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
    private $cup;

    /**
     * @ORM\Column(type="string")
     */
    private $mlc;

    /**
     * @ORM\Column(type="string")
     */
    private $tropipay;

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
    public function getCup()
    {
        return $this->cup;
    }

    /**
     * @param mixed $cup
     */
    public function setCup($cup): void
    {
        $this->cup = $cup;
    }

    /**
     * @return mixed
     */
    public function getMlc()
    {
        return $this->mlc;
    }

    /**
     * @param mixed $mlc
     */
    public function setMlc($mlc): void
    {
        $this->mlc = $mlc;
    }


    /**
     * @return mixed
     */
    public function getTropipay()
    {
        return $this->tropipay;
    }

    /**
     * @param mixed $tropipay
     */
    public function setTropipay($tropipay): void
    {
        $this->tropipay = $tropipay;
    }


}
