<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\TipoEvento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TipoEvento>
 *
 * @method TipoEvento|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoEvento|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoEvento[]    findAll()
 * @method TipoEvento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoEventoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoEvento::class);
    }

    public function add(TipoEvento $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(TipoEvento $entity, bool $flush = true): TipoEvento
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(TipoEvento $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
