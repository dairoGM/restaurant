<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\TipoExperienciaCulinaria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TipoExperienciaCulinaria>
 *
 * @method TipoExperienciaCulinaria|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoExperienciaCulinaria|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoExperienciaCulinaria[]    findAll()
 * @method TipoExperienciaCulinaria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoExperienciaCulinariaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoExperienciaCulinaria::class);
    }

    public function add(TipoExperienciaCulinaria $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(TipoExperienciaCulinaria $entity, bool $flush = true): TipoExperienciaCulinaria
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(TipoExperienciaCulinaria $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
