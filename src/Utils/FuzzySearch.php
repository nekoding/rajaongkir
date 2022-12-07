<?php

namespace Nekoding\Rajaongkir\Utils;

use Nekoding\Rajaongkir\Contracts\ISearch;
use Nekoding\Rajaongkir\Contracts\ISearchOptions;

class FuzzySearch implements ISearch, ISearchOptions
{

    protected $fuse;
    protected $configurations = [
        "keys"      => [],
        "threshold" => 0.2
    ];

    public function setUp(array $data = []): ISearch
    {
        $this->fuse = new \Fuse\Fuse($data, $this->configurations);
        return $this;
    }

    public function search(string $search): array
    {
        return $this->fuse->search($search);
    }

    public function setKeys(array $keys): ISearchOptions
    {
        $this->configurations["keys"] = $keys;
        return $this;
    }

    public function getKeys(): array
    {
        return $this->configurations["keys"];
    }

    public function setThreshold(float $threshold): ISearchOptions
    {
        $this->configurations["threshold"] = $threshold;
        return $this;
    }

    public function getThreshold(): float
    {
        return $this->configurations["threshold"];
    }

    public function setConfig(array $config): ISearch
    {
        $this->configurations = $config;
        return $this;
    }

    public function getConfig(): array
    {
        return $this->configurations;
    }
}
