<?php

namespace Intergift\Service\Exchange;

use DateTime;
use Intergift\Model\Exchange\Exchange;
use Intergift\Model\Exchange\ExchangeRepository;
use Intergift\Service\ServiceInterface;

class Test implements ServiceInterface
{
    use Assign;

    protected $people;

    protected $date;

    public function __construct(array $people, DateTime $date)
    {
        $this->people = $people;
        $this->date = $date;
    }

    public function execute()
    {
        $hash = $this->assign();

        $repo =  new ExchangeRepository();

        $exchange = new Exchange([
            'people' => $hash,
            'date' => $this->date->getTimestamp(),
        ]);

        return $exchange;
    }
}
