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

use Intergift\Provider\ServiceProviderInterface;
use Intergift\Infrastructure\Application\View\View;
use League\Plates\Engine;
use Interop\Container\ContainerInterface;

class ViewProvider implements ServiceProviderInterface
{
    public function register(ContainerInterface $container)
    {
        $request = $container->get('request');
        $engine = new Engine(ROOT_PATH . '/resources/views', 'phtml');

        $container['view'] = function ($container) use ($engine) {
            return new View($engine);
        };
    }

    public function boot(ContainerInterface $container)
    {
    }
}
