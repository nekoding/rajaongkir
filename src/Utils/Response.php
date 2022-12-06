<?php

namespace Nekoding\Rajaongkir\Utils;

use Nekoding\Rajaongkir\Contracts\IResponse;
use Nekoding\Rajaongkir\Contracts\ISearch;

class Response extends AbstractResponse implements IResponse
{
    protected $searchEngine;
    protected $data = [];
    protected $result = [];

    protected $searchData = "";

    public function __construct(array $data, ISearch $search, string $searchData)
    {
        $this->data = $data;
        $this->searchEngine = $search;
        $this->searchData = $searchData;
    }

    private function applyFilter(): array
    {
        // add metadata
        $this->data["query"]["search"] = $this->searchEngine::getSearchKeys();

        // filter data
        $results = $this->searchEngine->setUp($this->getData())->search($this->searchData);

        $results = array_map(function ($result) {
            return $result['item'];
        }, $results);

        return $results;
    }

    public function count(): int
    {
        $res = $this->applyFilter();
        return count($res);
    }

    public function first(): array
    {
        $results = $this->applyFilter();

        if (empty($results)) {
            $this->data['results'] = [];
            return $this->data;
        }

        // get first data
        $this->data['results'] = $results[0];
        return $this->data;
    }

    public function last(): array
    {
        $results = $this->applyFilter();

        if (empty($results)) {
            $this->data['results'] = [];
            return $this->data;
        }

        // get last data
        $this->data['results'] = $results[count($results) - 1];
        return $this->data;
    }

    public function nth(int $index): array
    {
        $results = $this->applyFilter();

        if (empty($results) || !isset($results[$index])) {
            $this->data['results'] = [];
            return $this->data;
        }

        $this->data['results'] = $results[$index];
        return $this->data;
    }

    public function get(): array
    {
        $results = $this->applyFilter();

        // append
        $this->data['results'] = $results;
        return $this->data;
    }
}
