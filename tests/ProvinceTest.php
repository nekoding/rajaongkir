<?php

namespace Nekoding\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Nekoding\Rajaongkir\Resources\Province;
use Nekoding\Rajaongkir\Utils\FuzzySearch;
use Nekoding\Rajaongkir\Utils\HttpClient;
use PHPUnit\Framework\TestCase;

class ProvinceTest extends TestCase
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


    public function test_get_province_data_by_id()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/mock/bali.json")),
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
            new Response(200, [], file_get_contents(__DIR__ . "/mock/provinces.json")),
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
            new Response(200, [], file_get_contents(__DIR__ . "/mock/provinces.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $province = new Province("dummy_api_key");
        $res = $province->setSearchKeys(["province_id"])->search(1)->get();

        $this->assertContains("Bali", $res["results"][0]);
    }

    public function test_custom_config_search_threshold()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/mock/provinces.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $province = new Province("dummy_api_key");
        $res = $province->setSearchThreshold(10)->search(1)->get();

        $this->assertEquals(10, $province->getSearchInstance()->getSearchThreshold());
    }

    public function test_custom_config_search_keys()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/mock/provinces.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $province = new Province("dummy_api_key");
        $res = $province->setSearchKeys(["name", "age"])->search(1)->get();

        $this->assertEquals(["name", "age"], $province->getSearchInstance()->getSearchKeys());
    }

    public function test_set_search_config()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/mock/provinces.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $province = new Province("dummy_api_key");
        $province->setSearchKeys(["name", "age"])->setSearchThreshold(10)->search(1)->get();

        $this->assertEquals(["name", "age"], $province->getSearchInstance()->getSearchKeys());
        $this->assertEquals(10, $province->getSearchInstance()->getSearchThreshold());
    }

    public function test_first_data()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/mock/provinces.json")),
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
            new Response(200, [], file_get_contents(__DIR__ . "/mock/provinces.json")),
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
            new Response(200, [], file_get_contents(__DIR__ . "/mock/provinces.json")),
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
            new Response(200, [], file_get_contents(__DIR__ . "/mock/provinces.json")),
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
            new Response(200, [], file_get_contents(__DIR__ . "/mock/provinces.json")),
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
            new Response(200, [], file_get_contents(__DIR__ . "/mock/bali.json")),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        \Nekoding\Rajaongkir\Utils\Config::setApiKey("api_key");
        \Nekoding\Rajaongkir\Utils\Config::setApiMode("starter");

        $result = \Nekoding\Rajaongkir\Rajaongkir::province()->find(1);

        $this->assertContains("Bali", $result["results"]);
    }
}
