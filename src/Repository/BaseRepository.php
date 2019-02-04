<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

abstract class BaseRepository extends ServiceEntityRepository implements RepositoryInterface
{
    /**
     * BaseRepository constructor.
     * @param RegistryInterface $registry
     * @param string $entity
     */
    public function __construct(RegistryInterface $registry, string $entity)
    {
        parent::__construct($registry, $entity);
    }

    /**
     * @param $entity
     * @param bool $persist
     * @return mixed|null
     */
    public function save($entity, bool $persist)
    {
        try {
            if ($persist)
                $this->_em->persist($entity);
        } catch (\Doctrine\ORM\ORMException $exception) {
            return null;
        }

        try {
            $this->_em->flush($entity);
        } catch (\Doctrine\ORM\ORMException $exception) {
            return null;
        }
    }

    /**
     * @param mixed $entity
     * @return null only when unsuccessful
     */
    public function remove($entity)
    {
        try {
            $this->_em->remove($entity);
        }
        catch(\Doctrine\ORM\ORMException $ex) {
            return null;
        }

        try {
            $this->_em->flush($entity);
        }
        catch(\Doctrine\ORM\ORMException $ex) {
            return null;
        }
    }
}