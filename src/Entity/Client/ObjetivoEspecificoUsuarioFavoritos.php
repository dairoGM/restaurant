<?php

namespace App\Entity\Client;

use App\Entity\Planificacion\ObjetivoEspecifico;
use App\Entity\Security\User;
use App\Repository\Client\ObjetivoEspecificoUsuarioFavoritosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ObjetivoEspecificoUsuarioFavoritosRepository::class)
 */
class ObjetivoEspecificoUsuarioFavoritos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Planificacion\ObjetivoEspecifico")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?ObjetivoEspecifico $objetivoEspecifico;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Security\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?User $usuario;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return ObjetivoEspecifico|null
     */
    public function getObjetivoEspecifico(): ?ObjetivoEspecifico
    {
        return $this->objetivoEspecifico;
    }

    /**
     * @param ObjetivoEspecifico|null $objetivoEspecifico
     */
    public function setObjetivoEspecifico(?ObjetivoEspecifico $objetivoEspecifico): void
    {
        $this->objetivoEspecifico = $objetivoEspecifico;
    }

    /**
     * @return User|null
     */
    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    /**
     * @param User|null $usuario
     */
    public function setUsuario(?User $usuario): void
    {
        $this->usuario = $usuario;
    }




}
