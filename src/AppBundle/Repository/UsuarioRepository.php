<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class UsuarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    public function findTodosOrdenados()
    {
        return $this->createQueryBuilder('u')
            ->addOrderBy('u.administrador', 'desc')
            ->addOrderBy('u.moderador', 'desc')
            ->addOrderBy('u.nombre')
            ->getQuery()
            ->getResult();
    }
}
