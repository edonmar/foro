<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Tema;
use AppBundle\Entity\Categoria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class TemaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tema::class);
    }

    public function findByCategoria(Categoria $categoria)
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.categoria = :categoria')
            ->setParameter('categoria', $categoria)
            ->orderBy('t.fijado', 'desc')
            ->getQuery()
            ->getResult();
    }

    public function contarPorCategoria(Categoria $categoria){
        return $this->createQueryBuilder('t')
            ->select('count(t)')
            ->where('t.categoria = :categoria')
            ->setParameter('categoria', $categoria)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
