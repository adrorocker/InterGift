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

use DateTime;
use Intergift\Service\Exchange;

class ExchangeController extends BaseController
{
    public function create($request, $response)
    {
        $people = $request->getParam('people', []);
        $date = new DateTime($request->getParam('date', 'now'));
        $service = new Exchange\Create($people, $date);

        $exchange = $service->execute();
        
        return $response->withJson($exchange);
    }

    public function test($request, $response)
    {
        $people = $request->getParam('people', []);
        $date = new DateTime($request->getParam('date', 'now'));
        $service = new Exchange\Test($people, $date);

        $exchange = $service->execute();
        
        return $response->withJson($exchange);
    }

    public function get($request, $response, $id)
    {
        $service = new Exchange\Get($id['id']);

        $exchange = $service->execute();
        
        return $response->withJson($exchange);
    }
}
