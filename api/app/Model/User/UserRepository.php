<?php

namespace Intergift\Model\User;

use PhpFirebase\Entities\Repository\Repository;

class UserRepository extends Repository
{
    public function __construct()
    {
        $base = env('FIREBASE.BASE');
        $token = env('FIREBASE.TOKEN');

        $this->class = User::class;

        parent::__construct($base, $token, '/users');
    }
}
