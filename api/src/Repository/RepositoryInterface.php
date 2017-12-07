<?php

namespace PhpFirebase\Entities\Repository;

interface RepositoryInterface
{
    public function store($entity);

    public function find($id);

    public function fetch(array $searchCriteria);
}
