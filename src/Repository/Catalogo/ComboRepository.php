<?php

namespace App\Repository\Catalogo;

use App\Entity\Catalogo\Combo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Combo>
 *
 * @method Combo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Combo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Combo[]    findAll()
 * @method Combo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComboRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Combo::class);
    }

    public function add(Combo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Combo $entity, bool $flush = true): Combo
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Combo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
