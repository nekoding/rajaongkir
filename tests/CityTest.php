<?php

namespace Nekoding\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Nekoding\Rajaongkir\Resources\City;
use Nekoding\Rajaongkir\Utils\FuzzySearch;
use Nekoding\Rajaongkir\Utils\HttpClient;
use PHPUnit\Framework\TestCase;

class CityTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        // make sure threshold back to default
        FuzzySearch::setSearchThreshold(0.2);
    }

    public function test_get_city_data_by_id()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/mock/denpasar.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $city = new City("dummy_api_key");

        $res = $city->find(114);

        $this->assertContains("Denpasar", $res["results"]);
    }

    public function test_search_city_by_name()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/mock/cities.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $city = new City("dummy_api_key");
        $res = $city->search("Denpasar")->get();
        $this->assertContains("Denpasar", $res["results"][0]);
    }

    public function test_search_city_by_id()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/mock/cities.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $city = new City("dummy_api_key");
        $res = $city->setSearchKeys(["city_id"])->search(114)->get();

        $this->assertContains("Denpasar", $res["results"][0]);
    }

    public function test_custom_config_search_threshold()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/mock/cities.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $city = new City("dummy_api_key");
        $res = $city->setSearchThreshold(10)->search(1)->get();

        $this->assertEquals(10, $city->getSearchInstance()->getSearchThreshold());
    }

    public function test_custom_config_search_keys()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/mock/cities.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $city = new City("dummy_api_key");
        $res = $city->setSearchKeys(["name", "age"])->search(1)->get();

        $this->assertEquals(["name", "age"], $city->getSearchInstance()->getSearchKeys());
    }

    public function test_set_search_config()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/mock/cities.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $city = new City("dummy_api_key");
        $city->setSearchKeys(["name", "age"])->setSearchThreshold(10)->search(1)->get();

        $this->assertEquals(["name", "age"], $city->getSearchInstance()->getSearchKeys());
        $this->assertEquals(10, $city->getSearchInstance()->getSearchThreshold());
    }

    public function test_first_data()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/mock/cities.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $city = new City("dummy_api_key");
        $res = $city->search("Denpasar")->first();

        $this->assertArrayHasKey("city_name", $res["results"]);
        $this->assertEquals("Denpasar", $res["results"]["city_name"]);
    }

    public function test_last_data()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/mock/cities.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $city = new City("dummy_api_key");

        $res = $city->search("buleleng")->last();

        $this->assertArrayHasKey("city_name", $res["results"]);
        $this->assertEquals("Buleleng", $res["results"]["city_name"]);
    }

    public function test_count_data()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/mock/cities.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $city = new City("dummy_api_key");
        $res = $city->search("Denpasar")->count();

        $this->assertEquals(1, $res);
    }

    public function test_get_data()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/mock/cities.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $city = new City("dummy_api_key");
        $res = $city->search("Denpasar")->get();

        $this->assertEquals("Denpasar", $res["results"][0]["city_name"]);
    }

    public function test_nth_data()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/mock/cities.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $city = new City("dummy_api_key");

        $res = $city->search("Denpasar")->nth(0);

        $this->assertEquals("Denpasar", $res["results"]["city_name"]);
    }
}
