<?php

namespace App\Repository;

use App\Entity\Api_User;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ApiUserRepository extends BaseRepository
{
    /**
     * ApiUserRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Api_User::class);
    }

    /**
     * @param int $id ID of user to get
     * @return Api_User|null The user from DB
     */
    public function getUserByID(int $id): Api_User
    {
        $user = null;

        try {
            $user = $this->createQueryBuilder('a')
                ->andWhere('a.id= :val')
                ->setParameter('val', $id)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (\Doctrine\ORM\NonUniqueResultException $ex) {
            echo "ApiUser not unique. NEVER HAPPENS";
        }

        return $user;
    }

    /**
     * @param string $name ID of user to get
     * @return Api_User|null
     */
    public function getUserByName(string $name)
    {
        $user = null;

        try {
            $user = $this->createQueryBuilder('a')
                ->andWhere('a.name= :val')
                ->setParameter('val', $name)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (\Doctrine\ORM\NonUniqueResultException $ex) {
            echo "ApiUser not unique. NEVER HAPPENS";
        }

        return $user;
    }
}
