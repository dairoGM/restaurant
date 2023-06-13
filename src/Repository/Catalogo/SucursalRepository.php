<?php

namespace App\Repository\Catalogo;

use App\Entity\Catalogo\Sucursal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sucursal>
 *
 * @method Sucursal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sucursal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sucursal[]    findAll()
 * @method Sucursal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SucursalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sucursal::class);
    }

    public function add(Sucursal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Sucursal $entity, bool $flush = true): Sucursal
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Sucursal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
