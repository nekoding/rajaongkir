<?php

namespace Nekoding\Rajaongkir\Utils;

use Nekoding\Rajaongkir\Contracts\IResponse;
use Nekoding\Rajaongkir\Contracts\ISearch;

class Response extends AbstractResponse implements IResponse
{
    protected $searchEngine;
    protected $origin = [];
    protected $result = [];

    protected $searchData = "";

    public function __construct(array $data, ISearch $search, string $searchData, array $searchKeys = [])
    {
        $this->origin = $data;
        $this->searchEngine = $search;
        $this->searchData = $searchData;

        // start search
        $this->searchEngine::setSearchKeys($searchKeys);
        $this->result = $this->searchEngine->setUp($data[$this->getKeys()])->search($searchData);
    }

    public function count(): int
    {
        return count($this->result);
    }

    public function first(): array
    {
        $data = $this->origin;
        $firstData = $this->result[0];
        $data['results'] = $firstData;

        return $data;
    }

    public function last(): array
    {
        $data = $this->origin;
        $lastData = $this->result[count($this->result) - 1];
        $data['results'] = $lastData;

        return $data;
    }

    public function nth(int $index): array
    {
        $data = $this->origin;
        $lastData = $this->result[$index];
        $data['results'] = $lastData;

        return $data;
    }

    public function get(): array
    {
        $data = $this->origin;
        $data['results'] = $this->result;

        return $data;
    }

    public function slice(int $start, ?int $length = null): array
    {
        $data = $this->origin;
        $data['results'] = array_slice($this->result, $start, $length);

        return $data;
    }
}
