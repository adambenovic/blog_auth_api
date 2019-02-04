<?php

namespace App\Repository;

use App\Entity\Login;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Login|null find($id, $lockMode = null, $lockVersion = null)
 * @method Login|null findOneBy(array $criteria, array $orderBy = null)
 * @method Login[]    findAll()
 * @method Login[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoginRepository extends BaseRepository
{
    /**
     * LoginRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Login::class);
    }
}
