<?php
/**
 * Intergift.
 *
 * @link      https://github.com/adrosoftware/intergift
 *
 * @copyright Copyright (c) 2017 Adro Rocker
 * @author    Adro Rocker <mes@adro.rocks>
 */
namespace Intergift;

class Root
{
    private $root;

    public static function instance($root)
    {
        return new self($root);
    }

    public function __construct($base)
    {
        defined('ROOT_PATH') || define('ROOT_PATH', (getenv('ROOT_PATH') ? getenv('ROOT_PATH') : realpath($base)));

        $this->root = ROOT_PATH;
    }

    public function get()
    {
        return $this->root;
    }

    public function __toString()
    {
        return (string) $this->root;
    }
}
