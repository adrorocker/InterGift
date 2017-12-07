<?php

namespace PhpFirebase\Entities;

interface EntityInterface
{
    public function toArray();

    public function toJson();

    public static function fromJson($string);
}
