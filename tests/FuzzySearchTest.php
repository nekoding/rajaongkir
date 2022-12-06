<?php

namespace Nekoding\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;

class FuzzySearchTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        // make sure data rollback to default after test
        \Nekoding\Rajaongkir\Utils\FuzzySearch::setSearchOptions([
            "keys"      => [],
            "threshold" => 0.2
        ]);
    }

    public function test_initialize_fuzzy_search()
    {
        $fuzzySearch = new \Nekoding\Rajaongkir\Utils\FuzzySearch();

        $fuzzySearch->setUp();

        $reflection = new ReflectionClass($fuzzySearch);

        $prop = $reflection->getProperty("searchEngine");

        $prop->setAccessible(true);

        $this->assertInstanceOf(\Fuse\Fuse::class, $prop->getValue($fuzzySearch));
    }

    public function test_set_search_options()
    {
        \Nekoding\Rajaongkir\Utils\FuzzySearch::setSearchOptions([
            "keys"      => ["xxx"],
            "threshold" => 0.5
        ]);

        $this->assertEquals(["xxx"], \Nekoding\Rajaongkir\Utils\FuzzySearch::getSearchKeys());
        $this->assertEquals(0.5, \Nekoding\Rajaongkir\Utils\FuzzySearch::getSearchThreshold());
    }

    public function test_set_search_keys()
    {
        \Nekoding\Rajaongkir\Utils\FuzzySearch::setSearchKeys(["testing"]);

        $fuzzySearch = new \Nekoding\Rajaongkir\Utils\FuzzySearch();

        $reflection = new ReflectionClass($fuzzySearch);

        $prop = $reflection->getProperty("searchOptions");

        $prop->setAccessible(true);

        $searchOptions = $prop->getValue($fuzzySearch);

        $this->assertEquals(["testing"], $searchOptions["keys"]);
    }

    public function test_get_search_keys()
    {
        \Nekoding\Rajaongkir\Utils\FuzzySearch::setSearchKeys(["testing_get_search"]);

        $this->assertEquals(
            ["testing_get_search"],
            \Nekoding\Rajaongkir\Utils\FuzzySearch::getSearchKeys()
        );
    }

    public function test_set_search_threshold()
    {
        \Nekoding\Rajaongkir\Utils\FuzzySearch::setSearchThreshold(100);

        $fuzzySearch = new \Nekoding\Rajaongkir\Utils\FuzzySearch();

        $reflection = new ReflectionClass($fuzzySearch);

        $prop = $reflection->getProperty("searchOptions");

        $prop->setAccessible(true);

        $searchOptions = $prop->getValue($fuzzySearch);

        $this->assertEquals(100, $searchOptions["threshold"]);
    }

    public function test_get_search_threshold()
    {
        \Nekoding\Rajaongkir\Utils\FuzzySearch::setSearchThreshold(50);

        $this->assertEquals(
            50,
            \Nekoding\Rajaongkir\Utils\FuzzySearch::getSearchThreshold()
        );
    }

    public function test_load_search_options()
    {
        $fuzzySearch = new \Nekoding\Rajaongkir\Utils\FuzzySearch();

        $fuzzySearch->loadSearchOptions([
            "keys"      => ["load_options"],
            "threshold" => 90
        ]);

        $reflection = new ReflectionClass($fuzzySearch);

        $prop = $reflection->getProperty("searchOptions");

        $prop->setAccessible(true);

        $searchOptions = $prop->getValue($fuzzySearch);

        $this->assertEquals(["load_options"], $searchOptions["keys"]);

        $this->assertEquals(90, $searchOptions["threshold"]);
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
        $result = $fuse->loadSearchOptions($options)->setUp($list)->search("steve");

        $this->assertCount(1, $result);
        $this->assertStringContainsString("Steve", $result[0]["item"]["author"]);
    }
}
