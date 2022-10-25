<?php

namespace App\Repository\Catalogo;

use App\Entity\Catalogo\ClasificacionRuta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ClasificacionRuta>
 *
 * @method ClasificacionRuta|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClasificacionRuta|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClasificacionRuta[]    findAll()
 * @method ClasificacionRuta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClasificacionRutaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClasificacionRuta::class);
    }

    public function add(ClasificacionRuta $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(ClasificacionRuta $entity, bool $flush = true): ClasificacionRuta
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(ClasificacionRuta $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
