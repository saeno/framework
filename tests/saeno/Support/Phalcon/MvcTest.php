<?php

namespace Saeno\Support\Phalcon;

use Saeno\Facades\Route;
use Saeno\Support\Phalcon\Mvc\URL;
use Saeno\Support\Phalcon\Mvc\Router;

class MvcTest extends \PHPUnit_Framework_TestCase
{
    public function testUrl()
    {
        $old = config()->toArray();

        # since we're loading the default 'main' module
        # located at root/autoload.php
        $this->assertEquals('http://', di()->get('url')->getScheme());
        $this->assertEquals('saeno.app', di()->get('url')->getHost());
        $this->assertEquals('http://saeno.app', di()->get('url')->getFullUrl());

        # https check
        config([
            'app' => [
                'ssl' => [
                    'acme' => true,
                ],
                'base_uri' => [
                    'acme' => 'acme.app',
                ],
            ],
        ]);
        $this->assertEquals('https://', di()->get('url')->getScheme('acme'));
        $this->assertEquals('acme.app', di()->get('url')->getHost('acme'));
        $this->assertEquals('https://acme.app', di()->get('url')->getFullUrl('acme'));

        # revert config
        config($old, false);

        # http check
        $this->assertEquals('http://', di()->get('url')->getScheme('main'));
        $this->assertEquals('saeno.app', di()->get('url')->getHost('main'));
        $this->assertEquals('http://saeno.app', di()->get('url')->getFullUrl('main'));

        # let's call the di 'route' to register these routes
        route()->add('/test', [
            'controller' => 'Something',
            'action' => 'someone',
        ])->setName('test');

        route()->add('/test/{id}', [
            'controller' => 'Something',
            'action' => 'someone',
        ])->setName('testWithId');

        route()->add('/test/{id}', [
            'controller' => 'Something',
            'action' => 'someone',
        ])->setName('testWithParamsAndRaw');

        # we need to call the url() helper to be able to call
        # the registered 'router'
        $simple_route = url()->route('test');
        $params_route = url()->route('testWithId', ['id' => 1]);
        $raw_route = url()->route('testWithParamsAndRaw', ['id' => 1], ['debug' => true]);

        $this->assertEquals($simple_route, 'http://saeno.app/test');
        $this->assertEquals($params_route, 'http://saeno.app/test/1');
        $this->assertEquals($raw_route, 'http://saeno.app/test/1?debug=1');
    }
}
