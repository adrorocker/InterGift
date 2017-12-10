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
use Intergift\Infrastructure\Application\Mail\Mailer;

class MailProvider implements ServiceProviderInterface
{
    public function register(ContainerInterface $container)
    {
        $config = $container->get('app.settings')['mail'];
        $container['mailer'] = function ($container) use ($config) {
            return new Mailer($container);
        };
    }

    public function boot(ContainerInterface $container)
    {
    }
}
