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

class HomeController extends BaseController
{
    public function welcome($request, $response)
    {
        return $response->withJson(['InterGift' => 'Simple app to make gift exchange easy and a real surprise for everyone.']);
    }

    public function version($request, $response)
    {
        return $response->withJson(['version' => VERSION]);
    }
}
