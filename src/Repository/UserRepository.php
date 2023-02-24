<?php

namespace App\Repository;

use App\Entity\User;
use App\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getAllByName()
    {
        $qb = $this->createQueryBuilder('u')
            ->orderBy('u.lastName', 'asc')
            ->getQuery();

        return $qb->getResult();
    }
}