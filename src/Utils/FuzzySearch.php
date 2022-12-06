<?php

namespace Nekoding\Rajaongkir\Utils;

use Nekoding\Rajaongkir\Contracts\ISearch;

class FuzzySearch implements ISearch
{

    protected $searchEngine;
    protected static $searchOptions = [
        "keys"      => [],
        "threshold" => 0.2
    ];

    public function setUp(array $data = []): ISearch
    {
        if (!$this->searchEngine) {
            $this->searchEngine = new \Fuse\Fuse($data, self::$searchOptions);
        }

        return $this;
    }

    public static function setSearchOptions(array $options)
    {
        self::$searchOptions = $options;
    }

    public static function getSearchKeys(): array
    {
        return self::$searchOptions["keys"];
    }

    public static function setSearchKeys(array $keys)
    {
        self::$searchOptions["keys"] = $keys;
    }

    public static function getSearchThreshold(): float
    {
        return self::$searchOptions["threshold"];
    }

    public static function setSearchThreshold(float $threshold)
    {
        self::$searchOptions["threshold"] = $threshold;
    }

    public function loadSearchOptions(array $options): ISearch
    {
        self::$searchOptions = $options;
        return $this;
    }

    public function search(string $search): array
    {
        return $this->searchEngine->search($search);
    }
}
