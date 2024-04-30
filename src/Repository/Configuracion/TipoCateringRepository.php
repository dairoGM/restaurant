<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\TipoCatering;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TipoCatering>
 *
 * @method TipoCatering|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoCatering|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoCatering[]    findAll()
 * @method TipoCatering[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoCateringRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoCatering::class);
    }

    public function add(TipoCatering $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(TipoCatering $entity, bool $flush = true): TipoCatering
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(TipoCatering $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
