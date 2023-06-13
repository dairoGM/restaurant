<?php

namespace App\Repository\Catalogo;

use App\Entity\Catalogo\Fabricante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fabricante>
 *
 * @method Fabricante|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fabricante|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fabricante[]    findAll()
 * @method Fabricante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FabricanteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fabricante::class);
    }

    public function add(Fabricante $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Fabricante $entity, bool $flush = true): Fabricante
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Fabricante $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
