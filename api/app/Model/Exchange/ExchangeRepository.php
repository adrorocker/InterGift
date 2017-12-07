<?php

namespace Intergift\Model\Exchange;

use PhpFirebase\Entities\Repository\Repository;

class ExchangeRepository extends Repository
{
    public function __construct()
    {
        $base = env('FIREBASE.BASE');
        $token = env('FIREBASE.TOKEN');

        $this->class = Exchange::class;

        parent::__construct($base, $token, '/exchanges');
    }
}
