<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\MenuPlato;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MenuPlato>
 *
 * @method MenuPlato|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuPlato|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuPlato[]    findAll()
 * @method MenuPlato[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuPlatoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuPlato::class);
    }

    public function add(MenuPlato $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(MenuPlato $entity, bool $flush = true): MenuPlato
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(MenuPlato $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    private function listarPlatosSinOfertasFamilia($filters = [], $orderBy = [], $limit = null)
    {
        $filters['p.ofertaFamilia'] = false;
        $query = $this->createQueryBuilder('qb')
            ->select("p.id, 
                        p.nombre, 
                        e.nombreCorto as nombreCortoEspacio, 
                        e.id as idEspacio, 
                        p.precio,    
                        p.nombreLargo,    
                        p.activo,                                           
                        p.publico,                                           
                        p.sugerenciaChef,                                           
                        p.ofertaFamilia,                                           
                        p.descripcion,
                         p.imagen")
            ->innerJoin('qb.menu', 'm')
            ->innerJoin('m.espacio', 'e')
            ->innerJoin('qb.plato', 'p');
        if (!is_null($limit)) {
            $query->setMaxResults($limit);
        }
        if (is_array($filters)) {
            foreach ($filters as $key => $value) {
                $query->andWhere("$key = '$value'");
            }
        }

        $query->addOrderBy('p.nombre', 'ASC');
        return $query->getQuery()->getResult(1);
    }

    private function listarPlatosConOfertasFamilia($filters = [], $orderBy = [], $limit = null)
    {
        $filters['p.ofertaFamilia'] = true;
        $query = $this->createQueryBuilder('qb')
            ->select("p.id, 
                        p.nombre, 
                        e.nombreCorto as nombreCortoEspacio, 
                        e.id as idEspacio, 
                        p.precio,    
                        p.nombreLargo,    
                        p.activo,                                           
                        p.publico,                                           
                        p.sugerenciaChef,                                           
                        p.ofertaFamilia,                                           
                        p.descripcion,
                         p.imagen")
            ->innerJoin('qb.menu', 'm')
            ->innerJoin('m.espacio', 'e')
            ->innerJoin('qb.plato', 'p');
        if (!is_null($limit)) {
            $query->setMaxResults($limit);
        }
        if (is_array($filters)) {
            foreach ($filters as $key => $value) {
                $query->andWhere("$key = '$value'");
            }
        }

        $query->orderBy('p.ofertaFamilia', 'desc')
            ->addOrderBy('p.nombre', 'ASC')
            ->setMaxResults(6);

        return $query->getQuery()->getResult(1);
    }

    public function listarPlatos($filters = [], $orderBy = [], $limit = null)
    {
        $platosSinOfertas = $this->listarPlatosSinOfertasFamilia($filters, $orderBy, $limit);
        $platosConOfertas = $this->listarPlatosConOfertasFamilia($filters, $orderBy, $limit);
        $result = array_merge($platosConOfertas, $platosSinOfertas);
        return $result;

    }

    public function getPrecioMenu($idMenu)
    {
        $query = $this->createQueryBuilder('qb')
            ->select('sum(p.precio) as precio')
            ->innerJoin('qb.plato', 'p')
            ->innerJoin('qb.menu', 'm')
            ->where("m.id = $idMenu");
        return $query->getQuery()->getResult();
    }

    public function listarOfertasFamiliar()
    {
        $filters['p.publico'] = 1;
        $filters['p.activo'] = 1;
        $filters['p.ofertaFamilia'] = 1;
        $query = $this->createQueryBuilder('qb')
            ->select("p.id, 
                        p.nombre, 
                        e.nombreCorto as nombreCortoEspacio, 
                        e.id as idEspacio, 
                        p.precio,    
                        p.nombreLargo,    
                        p.activo,                                           
                        p.publico,                                           
                        p.sugerenciaChef,                                           
                        p.ofertaFamilia,                                           
                        p.descripcion,
                         p.imagen")
            ->innerJoin('qb.menu', 'm')
            ->innerJoin('m.espacio', 'e')
            ->innerJoin('qb.plato', 'p');

        if (is_array($filters)) {
            foreach ($filters as $key => $value) {
                $query->andWhere("$key = '$value'");
            }
        }

        $query->orderBy('p.ofertaFamilia', 'desc')
            ->addOrderBy('p.nombre', 'ASC')
            ->setMaxResults(6);
pr($query->getQuery()->getSQL());
        return $query->getQuery()->getResult();
    }
}
