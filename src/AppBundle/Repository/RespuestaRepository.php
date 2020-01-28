<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Respuesta;
use AppBundle\Entity\Tema;
use AppBundle\Entity\Categoria;
use AppBundle\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class RespuestaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Respuesta::class);
    }

    public function findByTema(Tema $tema)
    {
        return $this->createQueryBuilder('r')
            ->select('r')
            ->where('r.tema = :tema')
            ->setParameter('tema', $tema)
            ->getQuery()
            ->getResult();
    }

    public function findByUsuario(Usuario $usuario)
    {
        return $this->createQueryBuilder('r')
            ->select('r')
            ->where('r.usuario = :usuario')
            ->setParameter('usuario', $usuario)
            ->orderBy('r.fechaCreacion', 'desc')
            ->getQuery()
            ->getResult();
    }

    public function contarPorCategoria(Categoria $categoria){
        return $this->createQueryBuilder('r')
            ->select('count(r)')
            ->innerJoin('r.tema', 't')
            ->where('t.categoria = :categoria')
            ->setParameter('categoria', $categoria)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function contarPorUsuario(Usuario $usuario){
        return $this->createQueryBuilder('r')
            ->select('count(r)')
            ->where('r.usuario = :usuario')
            ->setParameter('usuario', $usuario)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function ultimaRespuestaTema(Tema $tema){
        return $this->createQueryBuilder('r')
            ->select('r')
            ->where('r.tema = :tema')
            ->setParameter('tema', $tema)
            ->orderBy('r.id', 'desc')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }

    public function ultimaRespuestaCategoria(Categoria $categoria){
        return $this->createQueryBuilder('r')
            ->select('r')
            ->innerJoin('r.tema', 't')
            ->where('t.categoria = :categoria')
            ->setParameter('categoria', $categoria)
            ->orderBy('r.id', 'desc')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }
}
