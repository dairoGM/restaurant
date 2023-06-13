<?php

namespace App\Repository\Catalogo;

use App\Entity\Catalogo\Moneda;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Moneda>
 *
 * @method Moneda|null find($id, $lockMode = null, $lockVersion = null)
 * @method Moneda|null findOneBy(array $criteria, array $orderBy = null)
 * @method Moneda[]    findAll()
 * @method Moneda[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonedaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Moneda::class);
    }

    public function add(Moneda $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Moneda $entity, bool $flush = true): Moneda
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Moneda $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
