<?php

namespace App\Repository\Catalogo;

use App\Entity\Catalogo\Kardex;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Kardex>
 *
 * @method Kardex|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kardex|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kardex[]    findAll()
 * @method Kardex[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KardexRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kardex::class);
    }

    public function add(Kardex $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Kardex $entity, bool $flush = true): Kardex
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Kardex $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
