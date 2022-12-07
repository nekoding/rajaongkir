<?php

namespace Nekoding\Rajaongkir\Utils;

use Nekoding\Rajaongkir\Contracts\ISearch;
use Nekoding\Rajaongkir\Contracts\ISearchOptions;

class FuzzySearch implements ISearch, ISearchOptions
{

    protected $searchEngine;
    protected static $searchOptions = [
        "keys"      => [],
        "threshold" => 0.2
    ];

    public function setUp(array $data = []): ISearch
    {
        $this->searchEngine = new \Fuse\Fuse($data, self::$searchOptions);
        return $this;
    }

    public static function setSearchOptions(array $options)
    {
        self::$searchOptions = $options;
    }

    public static function getSearchOptions(): array
    {
        return self::$searchOptions;
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

    public function setOptions(array $options): ISearch
    {
        self::$searchOptions = $options;
        return $this;
    }

    public function getOptions(): array
    {
        return self::$searchOptions;
    }

    public function getKeys(): array
    {
        return self::$searchOptions["keys"];
    }

    public function setKeys(array $keys): ISearchOptions
    {
        self::$searchOptions["keys"] = $keys;
        return $this;
    }

    public function getThreshold(): float
    {
        return self::$searchOptions["threshold"];
    }

    public function setThreshold(float $threshold): ISearchOptions
    {
        self::$searchOptions["threshold"] = $threshold;
        return $this;
    }

    public function search(string $search): array
    {
        return $this->searchEngine->search($search);
    }
}
