<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\ExperienciaGastronomica;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExperienciaGastronomica>
 *
 * @method ExperienciaGastronomica|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExperienciaGastronomica|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExperienciaGastronomica[]    findAll()
 * @method ExperienciaGastronomica[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExperienciaGastronomicaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExperienciaGastronomica::class);
    }

    public function add(ExperienciaGastronomica $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(ExperienciaGastronomica $entity, bool $flush = true): ExperienciaGastronomica
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(ExperienciaGastronomica $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listarExperienciaGastronomica()
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
                        teg.nombre as nombreEipoExperienciaGastronomica, 
                        teg.id as idTipoExperienciaGastronomica')
            ->innerJoin('qb.tipoExperienciaGastronomica', 'teg');

        $qb->orderBy('qb.orden');
        $resul = $qb->getQuery()->getResult();

        return $resul;
    }
}
