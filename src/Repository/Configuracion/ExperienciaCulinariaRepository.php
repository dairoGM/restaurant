<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\ExperienciaCulinaria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExperienciaCulinaria>
 *
 * @method ExperienciaCulinaria|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExperienciaCulinaria|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExperienciaCulinaria[]    findAll()
 * @method ExperienciaCulinaria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExperienciaCulinariaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExperienciaCulinaria::class);
    }

    public function add(ExperienciaCulinaria $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(ExperienciaCulinaria $entity, bool $flush = true): ExperienciaCulinaria
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(ExperienciaCulinaria $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listarExperienciaCulinaria()
    {
        $qb = $this->createQueryBuilder('qb')
            ->select('qb.id, 
                        qb.nombre, 
                        qb.activo, 
                        qb.fecha,                        
                        qb.publico,                         
                        qb.orden,                         
                        qb.cantidadParticipantes,                       
                        qb.descripcion, 
                        tec.nombre as nombreEipoExperienciaCulinaria, 
                        tec.id as idTipoExperienciaCulinaria')
            ->innerJoin('qb.tipoExperienciaCulinaria', 'tec');

        $qb->orderBy('qb.orden');
        $resul = $qb->getQuery()->getResult();

        return $resul;
    }
}
