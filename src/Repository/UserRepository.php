<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param int $id ID of user to get
     * @return User|null The user from DB
     */
    public function getUserByID(int $id): User
    {
        $user = null;

        try
        {
            $user = $this->createQueryBuilder('a')
                ->andWhere('a.id= :val')
                ->setParameter('val', $id)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }
        catch (\Doctrine\ORM\NonUniqueResultException $ex)
        {
            echo "User not unique. NEVER HAPPENS";
        }

        return $user;
    }

    /**
     * @param string $name ID of user to get
     * @return User|null
     */
    public function getUserByName(string $name)
    {
        $user = null;

        try
        {
            $user = $this->createQueryBuilder('a')
                ->andWhere('a.name= :val')
                ->setParameter('val', $name)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }
        catch (\Doctrine\ORM\NonUniqueResultException $ex)
        {
            echo "User not unique. NEVER HAPPENS";
        }

        return $user;
    }
}
