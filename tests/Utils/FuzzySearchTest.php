<?php

namespace Nekoding\Tests\Utils;

use PHPUnit\Framework\TestCase;
use ReflectionClass;

class FuzzySearchTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_initialize_fuzzy_search()
    {
        $fuzzySearch = new \Nekoding\Rajaongkir\Utils\FuzzySearch();

        $fuzzySearch->setUp([]);

        $reflection = new ReflectionClass($fuzzySearch);

        $prop = $reflection->getProperty("fuse");

        $prop->setAccessible(true);

        $this->assertInstanceOf(\Fuse\Fuse::class, $prop->getValue($fuzzySearch));
    }

    public function test_set_search_keys()
    {
        $fuzzySearch = new \Nekoding\Rajaongkir\Utils\FuzzySearch();

        $fuzzySearch->setKeys(["testing"]);

        $reflection = new ReflectionClass($fuzzySearch);

        $prop = $reflection->getProperty("configurations");

        $prop->setAccessible(true);

        $config = $prop->getValue($fuzzySearch);

        $this->assertEquals(["testing"], $config["keys"]);
    }

    public function test_get_search_keys()
    {
        $fuzzySearch = new \Nekoding\Rajaongkir\Utils\FuzzySearch();

        $fuzzySearch->setKeys(["testing1"]);

        $this->assertEquals(["testing1"], $fuzzySearch->getKeys());
    }

    public function test_set_search_threshold()
    {
        $fuzzySearch = new \Nekoding\Rajaongkir\Utils\FuzzySearch();

        $fuzzySearch->setThreshold(5);

        $reflection = new ReflectionClass($fuzzySearch);

        $prop = $reflection->getProperty("configurations");

        $prop->setAccessible(true);

        $config = $prop->getValue($fuzzySearch);

        $this->assertEquals(5, $config["threshold"]);
    }

    public function test_get_search_threshold()
    {
        $fuzzySearch = new \Nekoding\Rajaongkir\Utils\FuzzySearch();

        $fuzzySearch->setThreshold(10);

        $this->assertEquals(10, $fuzzySearch->getThreshold());
    }

    public function test_set_search_config()
    {
        $fuzzySearch = new \Nekoding\Rajaongkir\Utils\FuzzySearch();

        $fake = [
            "keys" => ["dummy"],
            "threshold" => 1
        ];

        $fuzzySearch->setConfig($fake);

        $reflection = new ReflectionClass($fuzzySearch);

        $prop = $reflection->getProperty("configurations");

        $prop->setAccessible(true);

        $config = $prop->getValue($fuzzySearch);

        $this->assertEquals($fake, $config);
    }

    public function test_get_search_config()
    {
        $fuzzySearch = new \Nekoding\Rajaongkir\Utils\FuzzySearch();

        $fake = [
            "keys" => ["dummy"],
            "threshold" => 1
        ];

        $fuzzySearch->setConfig($fake);

        $this->assertEquals($fake, $fuzzySearch->getConfig());
    }

    public function test_search_data()
    {
        $list = [
            [
                'title' => "Old Man's War",
                'author' => 'John Scalzi',
            ],
            [
                'title' => 'The Lock Artist',
                'author' => 'Steve Hamilton',
            ],
            [
                'title' => 'HTML5',
                'author' => 'Remy Sharp',
            ],
            [
                'title' => 'Right Ho Jeeves',
                'author' => 'P.D Woodhouse',
            ],
        ];

        $options = [
            'keys' => ['title', 'author'],
            'threshold' => 0.3
        ];

        $fuse = new \Nekoding\Rajaongkir\Utils\FuzzySearch();
        $result = $fuse->setConfig($options)->setUp($list)->search("steve");

        $this->assertCount(1, $result);
        $this->assertStringContainsString("Steve", $result[0]["item"]["author"]);
    }
}
