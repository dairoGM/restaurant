<?php

namespace App\Repository\Catalogo;

use App\Entity\Catalogo\Almacen;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Almacen>
 *
 * @method Almacen|null find($id, $lockMode = null, $lockVersion = null)
 * @method Almacen|null findOneBy(array $criteria, array $orderBy = null)
 * @method Almacen[]    findAll()
 * @method Almacen[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlmacenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Almacen::class);
    }

    public function add(Almacen $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Almacen $entity, bool $flush = true): Almacen
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Almacen $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
