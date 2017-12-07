<?php

namespace Intergift\Service\Exchange;

trait Assign
{
    public function assign()
    {
        shuffle($this->people);
        $count = count($this->people);
        $hash = [];
        for ($i = 0; $i < $count; $i ++) {
            if (($i + 1) == $count) {
                $hash[] = ['Sender' => $this->people[$i], 'Reciver' => $this->people[0]];
            } else {
                $hash[] = ['Sender' => $this->people[$i], 'Reciver' => $this->people[$i+1]];
            }
        }

        return $hash;
    }
}
