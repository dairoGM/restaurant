<?php

namespace App\Repository\Personal;

use App\Entity\Personal\DatosFuc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DatosFuc>
 *
 * @method DatosFuc|null find($id, $lockMode = null, $lockVersion = null)
 * @method DatosFuc|null findOneBy(array $criteria, array $orderBy = null)
 * @method DatosFuc[]    findAll()
 * @method DatosFuc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DatosFucRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DatosFuc::class);
    }

    public function add(DatosFuc $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(DatosFuc $entity, bool $flush = true): DatosFuc
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(DatosFuc $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
