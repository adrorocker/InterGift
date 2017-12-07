<?php
/**
 * Intergift.
 *
 * @link      https://github.com/adrosoftware/intergift
 *
 * @copyright Copyright (c) 2017 Adro Rocker
 * @author    Adro Rocker <mes@adro.rocks>
 */
namespace Intergift\Http\Controller;

use Interop\Container\ContainerInterface;

class BaseController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    /**
     * Return property
     *
     * @param string $name Name of the method
     *
     * @throws BadMethodCallException If the $name is not a property
     */
    public function __call($name, $arguments)
    {
        if (true !== $this->container->has($name)) {
            throw new \BadMethodCallException(sprintf(
                'The metod "%s" does not exist',
                $name
            ));
        }
        return $this->container->get($name);
    }
}
