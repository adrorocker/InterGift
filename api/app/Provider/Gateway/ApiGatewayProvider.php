<?php
/**
 * Intergift.
 *
 * @link      https://github.com/adrosoftware/intergift
 *
 * @copyright Copyright (c) 2017 Adro Rocker
 * @author    Adro Rocker <mes@adro.rocks>
 */
namespace Intergift\Provider\Gateway;

use Intergift\Provider\ServiceProviderInterface;
use Interop\Container\ContainerInterface;
use Intergift\Http\Controller\HomeController;
use Intergift\Http\Controller\ExchangeController;

class ApiGatewayProvider implements ServiceProviderInterface
{
    public function register(ContainerInterface $container)
    {
    }

    public function boot(ContainerInterface $container)
    {
        $slim = $container->get('slim');
        $slim->options('/{routes:.+}', function ($request, $response, $args) {
            return $response;
        });

        $slim->add(function ($req, $res, $next) {
            $response = $next($req, $res);
            return $response
                    ->withHeader('Access-Control-Allow-Origin', '*')
                    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        });

        $slim->group('/api', function () use ($slim) {
            $slim->get('/', HomeController::class.':welcome');
            $slim->post('/create', ExchangeController::class.':create');
            $slim->post('/test', ExchangeController::class.':test');
            $slim->get('/get/{id}', ExchangeController::class.':get');
            $slim->get('/version', HomeController::class.':version');
        });
    }
}
