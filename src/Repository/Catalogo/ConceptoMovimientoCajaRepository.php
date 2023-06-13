<?php

namespace App\Repository\Catalogo;

use App\Entity\Catalogo\ConceptoMovimientoCaja;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConceptoMovimientoCaja>
 *
 * @method ConceptoMovimientoCaja|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConceptoMovimientoCaja|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConceptoMovimientoCaja[]    findAll()
 * @method ConceptoMovimientoCaja[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConceptoMovimientoCajaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConceptoMovimientoCaja::class);
    }

    public function add(ConceptoMovimientoCaja $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(ConceptoMovimientoCaja $entity, bool $flush = true): ConceptoMovimientoCaja
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(ConceptoMovimientoCaja $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
