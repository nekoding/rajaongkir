<?php

namespace Nekoding\Tests\Resources;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Nekoding\Rajaongkir\Resources\City;
use Nekoding\Rajaongkir\Utils\FuzzySearch;
use Nekoding\Rajaongkir\Utils\HttpClient;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class CityTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_get_city_data_by_id()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ .  "/../mock/denpasar.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $province = new City("dummy_api_key");

        $res = $province->find(114);
        $this->assertContains("Denpasar", $res["results"]);
    }

    public function test_search_city_by_name()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/../mock/cities.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $province = new City("dummy_api_key");
        $res = $province->search("denpasar")->get();

        $this->assertContains("Denpasar", $res["results"][0]);
    }

    public function test_search_city_by_id()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/../mock/cities.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $province = new City("dummy_api_key");
        $res = $province->setSearchKeys(["city_id"])->search(114)->get();

        $this->assertContains("Denpasar", $res["results"][0]);
    }

    public function test_search_with_custom_keys()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/../mock/cities.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $key = ["custom"];
        $province = new City("dummy");
        $res = $province->setSearchKeys($key)->search("test");

        $reflect = new ReflectionClass($province);
        $prop = $reflect->getProperty("fuzzySearch");
        $prop->setAccessible(true);

        $fuse = $prop->getValue($province);
        $reflect = new ReflectionClass($fuse);
        
        $prop = $reflect->getProperty("configurations");
        $prop->setAccessible(true);

        $this->assertEquals($key, $prop->getValue($fuse)["keys"]);
    }

    public function test_search_with_custom_threshold()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/../mock/cities.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $threshold = 1;
        $province = new City("dummy");
        $res = $province->setSearchThreshold($threshold)->search("test");

        $reflect = new ReflectionClass($province);
        $prop = $reflect->getProperty("fuzzySearch");
        $prop->setAccessible(true);

        $fuse = $prop->getValue($province);
        $reflect = new ReflectionClass($fuse);
        
        $prop = $reflect->getProperty("configurations");
        $prop->setAccessible(true);

        $this->assertEquals($threshold, $prop->getValue($fuse)["threshold"]);
    }

    public function test_first_data()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/../mock/cities.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $province = new City("dummy_api_key");
        $res = $province->search("denpasar")->first();

        $this->assertArrayHasKey("province", $res["results"]);
        $this->assertEquals("Denpasar", $res["results"]["city_name"]);
    }

    public function test_last_data()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/../mock/cities.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $province = new City("dummy_api_key");

        $res = $province->search("madiun")->last();

        $this->assertArrayHasKey("province", $res["results"]);
        $this->assertEquals("Madiun", $res["results"]["city_name"]);
    }

    public function test_count_data()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/../mock/cities.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $province = new City("dummy_api_key");
        $res = $province->search("denpasar")->count();

        $this->assertEquals(1, $res);
    }

    public function test_get_data()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/../mock/cities.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $province = new City("dummy_api_key");
        $res = $province->search("denpasar")->get();

        $this->assertEquals("Denpasar", $res["results"][0]["city_name"]);
    }

    public function test_nth_data()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/../mock/cities.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $province = new City("dummy_api_key");

        $res = $province->search("denpasar")->nth(0);

        $this->assertEquals("Denpasar", $res["results"]["city_name"]);
    }

    public function test_init_api_with_rajaongkir_wrapper()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/../mock/denpasar.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        \Nekoding\Rajaongkir\Utils\Config::setApiKey("api_key");
        \Nekoding\Rajaongkir\Utils\Config::setApiMode("starter");

        $result = \Nekoding\Rajaongkir\Rajaongkir::province()->find(1);

        $this->assertContains("Denpasar", $result["results"]);
    }

    public function test_get_cities()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ .  "/../mock/cities.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $province = new City("dummy_api_key");

        $res = $province->get();
        $this->assertContains("Denpasar", array_column($res["results"], "city_name"));
    }
}
