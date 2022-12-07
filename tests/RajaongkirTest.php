<?php

namespace Nekoding\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Nekoding\Rajaongkir\Rajaongkir;
use Nekoding\Rajaongkir\Utils\HttpClient;
use PHPUnit\Framework\TestCase;

class RajaongkirTest extends TestCase
{

    public function test_get_province()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ .  "/mock/bali.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        // setup rajaonkir config
        \Nekoding\Rajaongkir\Utils\Config::setApiKey("xxx");
        \Nekoding\Rajaongkir\Utils\Config::setApiKey("basic");

        $province = Rajaongkir::province();

        $res = $province->find(1);
        $this->assertContains("Bali", $res["results"]);
    }

    public function test_get_city()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ .  "/mock/denpasar.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        // setup rajaonkir config
        \Nekoding\Rajaongkir\Utils\Config::setApiKey("xxx");
        \Nekoding\Rajaongkir\Utils\Config::setApiKey("basic");

        $city = Rajaongkir::city();

        $res = $city->find(114);
        $this->assertContains("Denpasar", $res["results"]);
    }

    public function test_get_cost()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/mock/cost.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $cost = Rajaongkir::cost();

        $cost->setOrigin(501);
        $cost->setDestination(114);
        $cost->setWeight(1700);
        $cost->setCourier("jne");

        $result = $cost->get();

        $this->assertEquals("Denpasar", $result["destination_details"]["city_name"]);
    }

}