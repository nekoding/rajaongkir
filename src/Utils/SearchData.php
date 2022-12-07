<?php

namespace Nekoding\Rajaongkir\Utils;

use Nekoding\Rajaongkir\Contracts\IResponseSearch;
use Nekoding\Rajaongkir\Contracts\ISearch;

class SearchData implements IResponseSearch
{

    protected $data;
    protected $searchInstance;
    protected $search;

    public function __construct(array $data, ISearch $searchInstance, string $search = "")
    {
        $this->data = $data;
        $this->searchInstance = $searchInstance;
        $this->search = $search;
    }

    protected function searchResult(): array
    {
        $results = $this->searchInstance->setUp($this->data)->search($this->search);

        if (empty($results)) {
            return [];
        }

        $results = array_map(function ($result) {
            return $result['item'];
        }, $results);

        return $results;
    }

    public function count(): int
    {
        return count($this->searchResult());
    }

    public function first(): array
    {
        $data = $this->data;

        if ($this->count() < 1) {
            $data["results"] = [];
        } else {
            $data["results"] = $this->searchResult()[0];
        }

        return $data;
    }

    public function last(): array
    {
        $data = $this->data;

        if ($this->count() < 1) {
            $data["results"] = [];
        } else {
            $data["results"] = $this->searchResult()[$this->count() - 1];
        }

        return $data;
    }

    public function nth(int $index): array
    {
        $data = $this->data;

        if ($this->count() < 1 || !isset($this->searchResult()[$index])) {
            $data["results"] = [];
        } else {
            $data["results"] = $this->searchResult()[$index];
        }

        return $data;
    }

    public function get(): array
    {
        $data = $this->data;

        if ($this->count() < 1) {
            $data["results"] = [];
        } else {
            $data["results"] = $this->searchResult();
        }

        return $data;
    }
}
