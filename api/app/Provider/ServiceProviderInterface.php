<?php
/**
 * Intergift.
 *
 * @link      https://github.com/adrosoftware/intergift
 *
 * @copyright Copyright (c) 2017 Adro Rocker
 * @author    Adro Rocker <mes@adro.rocks>
 */
namespace Intergift\Provider;

use Interop\Container\ContainerInterface;

interface ServiceProviderInterface
{
    public function register(ContainerInterface $container);

    public function boot(ContainerInterface $container);
}
