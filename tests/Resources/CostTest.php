<?php

namespace Nekoding\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Nekoding\Rajaongkir\Resources\Cost;
use Nekoding\Rajaongkir\Utils\HttpClient;
use PHPUnit\Framework\TestCase;

class CostTest extends TestCase
{

    public function test_get_cost()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/mock/cost.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $cost = new Cost("xxx");

        $cost->setOrigin(501);
        $cost->setDestination(114);
        $cost->setWeight(1700);
        $cost->setCourier("jne");

        $result = $cost->get();

        $this->assertEquals("Denpasar", $result["destination_details"]["city_name"]);
    }

    public function test_get_cost_with_array_data()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/mock/cost.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $cost = new Cost("xxx");
        $cost->setData([
            "origin"        => 501,
            "destination"   => 114,
            "weight"        => 1700,
            "courier"       => "jne"
        ]);

        $result = $cost->get();

        $this->assertEquals("Denpasar", $result["destination_details"]["city_name"]);
    }
}
