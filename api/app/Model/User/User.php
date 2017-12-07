<?php

namespace Intergift\Model\User;

use PhpFirebase\Entities\Entity;

class User extends Entity
{
    protected $id;

    public $firstName;

    public $lastName;
}
