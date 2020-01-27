<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Tema;
use AppBundle\Entity\Categoria;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Emocion;
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

    public function findByUsuario(Usuario $usuario)
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.usuario = :usuario')
            ->setParameter('usuario', $usuario)
            ->orderBy('t.fechaCreacion', 'desc')
            ->getQuery()
            ->getResult();
    }

    public function findByEmocion(Emocion $emocion)
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->innerJoin('t.emociones', 'e')
            ->where('e.id = :emocion')
            ->setParameter('emocion', $emocion)
            ->orderBy('t.fechaCreacion', 'desc')
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

    public function contarPorUsuario(Usuario $usuario){
        return $this->createQueryBuilder('t')
            ->select('count(t)')
            ->where('t.usuario = :usuario')
            ->setParameter('usuario', $usuario)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
