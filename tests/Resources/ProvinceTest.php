<?php

namespace Nekoding\Tests\Resources;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Nekoding\Rajaongkir\Resources\Province;
use Nekoding\Rajaongkir\Utils\HttpClient;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ProvinceTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_get_province_data_by_id()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ .  "/../mock/bali.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $province = new Province("dummy_api_key");

        $res = $province->find(1);
        $this->assertContains("Bali", $res["results"]);
    }

    public function test_search_province_by_name()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/../mock/provinces.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $province = new Province("dummy_api_key");
        $res = $province->search("bali")->get();

        $this->assertContains("Bali", $res["results"][0]);
    }

    public function test_search_province_by_id()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/../mock/provinces.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $province = new Province("dummy_api_key");
        $res = $province->setSearchKeys(["province_id"])->search(1)->get();

        $this->assertContains("Bali", $res["results"][0]);
    }

    public function test_search_with_custom_keys()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/../mock/provinces.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $key = ["custom"];
        $province = new Province("dummy");
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
            new Response(200, [], file_get_contents(__DIR__ . "/../mock/provinces.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $threshold = 1;
        $province = new Province("dummy");
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
            new Response(200, [], file_get_contents(__DIR__ . "/../mock/provinces.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $province = new Province("dummy_api_key");
        $res = $province->search("bali")->first();

        $this->assertArrayHasKey("province", $res["results"]);
        $this->assertEquals("Bali", $res["results"]["province"]);
    }

    public function test_last_data()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/../mock/provinces.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $province = new Province("dummy_api_key");

        $res = $province->search("kalimantan")->last();

        $this->assertArrayHasKey("province", $res["results"]);
        $this->assertEquals("Kalimantan Utara", $res["results"]["province"]);
    }

    public function test_count_data()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/../mock/provinces.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $province = new Province("dummy_api_key");
        $res = $province->search("bali")->count();

        $this->assertEquals(1, $res);
    }

    public function test_get_data()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/../mock/provinces.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $province = new Province("dummy_api_key");
        $res = $province->search("bali")->get();

        $this->assertEquals("Bali", $res["results"][0]["province"]);
    }

    public function test_nth_data()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/../mock/provinces.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $province = new Province("dummy_api_key");

        $res = $province->search("bali")->nth(0);

        $this->assertEquals("Bali", $res["results"]["province"]);
    }

    public function test_init_api_with_rajaongkir_wrapper()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/../mock/bali.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        \Nekoding\Rajaongkir\Utils\Config::setApiKey("api_key");
        \Nekoding\Rajaongkir\Utils\Config::setApiMode("starter");

        $result = \Nekoding\Rajaongkir\Rajaongkir::province()->find(1);

        $this->assertContains("Bali", $result["results"]);
    }
}
