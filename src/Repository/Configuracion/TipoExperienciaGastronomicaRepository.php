<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\TipoExperienciaGastronomica;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TipoExperienciaGastronomica>
 *
 * @method TipoExperienciaGastronomica|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoExperienciaGastronomica|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoExperienciaGastronomica[]    findAll()
 * @method TipoExperienciaGastronomica[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoExperienciaGastronomicaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoExperienciaGastronomica::class);
    }

    public function add(TipoExperienciaGastronomica $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(TipoExperienciaGastronomica $entity, bool $flush = true): TipoExperienciaGastronomica
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(TipoExperienciaGastronomica $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
