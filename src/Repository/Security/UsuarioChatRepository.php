<?php

namespace App\Repository\Security;

use App\Entity\Personal\Persona;
use App\Entity\Security\User;
use App\Entity\Security\UsuarioChat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 *
 * @method UsuarioChat|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsuarioChat|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsuarioChat[]    findAll()
 * @method UsuarioChat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsuarioChatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsuarioChat::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(UsuarioChat $entity, bool $flush = true): UsuarioChat
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

     /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function edit(UsuarioChat $entity, bool $flush = true): UsuarioChat
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(UsuarioChat $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getUsuarioChatByPersona(Persona $persona) : ?UsuarioChat
    {
        return $this->findOneBy(array('persona' => $persona));
    }

    public function getUsuarioChatByUsuario(User $user) : ?UsuarioChat
    {
        $qb = $this->createQueryBuilder('uc')
              ->innerJoin('uc.persona', 'p')
              ->innerJoin('p.usuario', 'u')
              ->andWhere("u.id = :userId" )
              ->setParameter('userId', $user->getId());

        $result = $qb->getQuery()->getOneOrNullResult();

        return $result;
    }

    public function getUsuarioChatByChatId($chatId) : ?UsuarioChat
    {
        $qb = $this->createQueryBuilder('uc')             
              ->andWhere("uc.chatId = :chatId")
              ->setParameter('chatId', $chatId);

        $result = $qb->getQuery()->getOneOrNullResult();

        return $result;
    }
}
