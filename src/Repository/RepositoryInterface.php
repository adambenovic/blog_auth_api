<?php

namespace App\Repository;

interface RepositoryInterface
{
    /**
     * @param $entity
     * @param bool $persist
     * @return mixed
     */
    public function save($entity, bool $persist);

    /**
     * @param mixed $entity
     */
    public function remove($entity);
}
