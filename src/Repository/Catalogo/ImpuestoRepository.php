<?php

namespace App\Repository\Catalogo;

use App\Entity\Catalogo\Impuesto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Impuesto>
 *
 * @method Impuesto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Impuesto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Impuesto[]    findAll()
 * @method Impuesto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImpuestoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Impuesto::class);
    }

    public function add(Impuesto $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Impuesto $entity, bool $flush = true): Impuesto
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Impuesto $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
