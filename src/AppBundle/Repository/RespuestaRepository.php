<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Respuesta;
use AppBundle\Entity\Tema;
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
}
