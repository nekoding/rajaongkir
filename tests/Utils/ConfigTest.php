<?php

namespace Nekoding\Tests\Utils;

use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ConfigTest extends TestCase
{
    
    protected function tearDown(): void
    {
        \Nekoding\Rajaongkir\Utils\Config::setApiKey("");
        \Nekoding\Rajaongkir\Utils\Config::setApiMode("");
    }

    public function test_set_api_key()
    {
        \Nekoding\Rajaongkir\Utils\Config::setApiKey("xxx");

        $config = new \Nekoding\Rajaongkir\Utils\Config();

        $reflection = new ReflectionClass($config);

        $prop = $reflection->getStaticPropertyValue("apiKey");

        $this->assertEquals("xxx", $prop);
    }

    public function test_get_config_api_key()
    {
        \Nekoding\Rajaongkir\Utils\Config::setApiKey("xxx");

        $this->assertEquals("xxx", \Nekoding\Rajaongkir\Utils\Config::getApiKey());
    }

    public function test_set_api_mode()
    {
        \Nekoding\Rajaongkir\Utils\Config::setApiMode("basic");

        $config = new \Nekoding\Rajaongkir\Utils\Config();

        $reflection = new ReflectionClass($config);

        $prop = $reflection->getStaticPropertyValue("apiMode");

        $this->assertEquals("basic", $prop);
    }

    public function test_get_api_mode()
    {
        \Nekoding\Rajaongkir\Utils\Config::setApiMode("pro");

        $this->assertEquals("pro", \Nekoding\Rajaongkir\Utils\Config::getApiMode());
    }

}