<?php

namespace Nekoding\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Nekoding\Rajaongkir\Utils\HttpClient;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class HttpClientTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        \Nekoding\Rajaongkir\Utils\Config::setApiKey("xxx");
    }

    protected function tearDown(): void
    {
        // make sure Http Client refreshed
        \Nekoding\Rajaongkir\Utils\HttpClient::resetConfig();
        \Nekoding\Rajaongkir\Utils\HttpClient::resetHeader();
        \Nekoding\Rajaongkir\Utils\HttpClient::setFormParams([]);
        \Nekoding\Rajaongkir\Utils\Config::setApiKey("");
    }

    public function test_starter_api_buildurl()
    {
        \Nekoding\Rajaongkir\Utils\Config::setApiKey("api_key");
        \Nekoding\Rajaongkir\Utils\Config::setApiMode("starter");

        $httpClient = new HttpClient();
        $url = $httpClient->buildUrl("/province");

        $this->assertStringContainsString(HttpClient::STARTER_BASE_URL, $url);
    }

    public function test_basic_api_buildurl()
    {
        \Nekoding\Rajaongkir\Utils\Config::setApiKey("api_key");
        \Nekoding\Rajaongkir\Utils\Config::setApiMode("basic");

        $httpClient = new HttpClient();
        $url = $httpClient->buildUrl("/province");

        $this->assertStringContainsString(HttpClient::BASIC_BASE_URL, $url);
    }

    public function test_pro_api_buildurl()
    {
        \Nekoding\Rajaongkir\Utils\Config::setApiKey("api_key");
        \Nekoding\Rajaongkir\Utils\Config::setApiMode("pro");

        $httpClient = new HttpClient();
        $url = $httpClient->buildUrl("/province");

        $this->assertStringContainsString(HttpClient::PRO_BASE_URL, $url);
    }

    public function test_set_config()
    {
        \Nekoding\Rajaongkir\Utils\HttpClient::setConfig([
            "test"      => "test"
        ]);

        $httpClient = new HttpClient();

        $reflection = new ReflectionClass($httpClient);

        $prop = $reflection->getProperty("httpClient");

        $prop->setAccessible(true);

        $client = $prop->getValue($httpClient);

        $this->assertContains("test", $client->getConfig());
    }

    public function test_get_config()
    {

        $config = ["test" => "x"];

        \Nekoding\Rajaongkir\Utils\HttpClient::setConfig($config);

        $res = \Nekoding\Rajaongkir\Utils\HttpClient::getConfig();

        $this->assertEquals($config, $res);
    }

    public function test_set_header()
    {
        $header = ["test" => "x"];

        \Nekoding\Rajaongkir\Utils\HttpClient::setHeader($header);

        $res = \Nekoding\Rajaongkir\Utils\HttpClient::getHeader();

        $this->assertEquals($header, $res);
    }

    public function test_get_header()
    {
        $res = \Nekoding\Rajaongkir\Utils\HttpClient::getHeader();

        $this->assertEquals([], $res);
    }

    public function test_set_form_data()
    {
        $data = ["test" => "x"];

        \Nekoding\Rajaongkir\Utils\HttpClient::setFormParams($data);

        $res = \Nekoding\Rajaongkir\Utils\HttpClient::getFormParams();

        $this->assertEquals($data, $res);
    }

    public function test_get_form_data()
    {
        $res = \Nekoding\Rajaongkir\Utils\HttpClient::getFormParams();

        $this->assertEquals([], $res);
    }

    public function test_http_request()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(["name" => "nekoding"])),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $httpClient = new HttpClient();

        $res = $httpClient->request("GET", "https://github.com");

        $this->assertInstanceOf(HttpClient::class, $res);
    }

    public function test_parse_json_response_data()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(["name" => "nekoding"])),
        ]);

        $handlerStack = HandlerStack::create($mock);

        HttpClient::setConfig(["handler" => $handlerStack]);

        $httpClient = new HttpClient();

        $res = $httpClient->request("GET", "https://github.com");

        $json = $res->getBody();

        $this->assertEquals([
            "name" => "nekoding"
        ], $json);
    }
}
