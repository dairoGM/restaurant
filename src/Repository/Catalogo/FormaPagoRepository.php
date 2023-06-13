<?php

namespace App\Repository\Catalogo;

use App\Entity\Catalogo\FormaPago;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FormaPago>
 *
 * @method FormaPago|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormaPago|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormaPago[]    findAll()
 * @method FormaPago[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormaPagoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormaPago::class);
    }

    public function add(FormaPago $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(FormaPago $entity, bool $flush = true): FormaPago
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(FormaPago $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
