<?php

namespace Intergift\Service\Exchange;

use Intergift\Model\Exchange\Exchange;
use Intergift\Model\Exchange\ExchangeRepository;
use Intergift\Service\ServiceInterface;

class Get implements ServiceInterface
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function execute()
    {
        $repo =  new ExchangeRepository();

        return $repo->find($this->id);
    }
}
