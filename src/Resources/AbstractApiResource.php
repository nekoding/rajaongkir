<?php

namespace Nekoding\Rajaongkir\Resources;

use Nekoding\Rajaongkir\Contracts\IResponse;
use Nekoding\Rajaongkir\Contracts\ISearch;
use Nekoding\Rajaongkir\Contracts\ISearchOptions;
use Nekoding\Rajaongkir\Utils\Config;
use Nekoding\Rajaongkir\Utils\FuzzySearch;
use Nekoding\Rajaongkir\Utils\HttpClient;

abstract class AbstractApiResource implements ISearchOptions
{
    protected $searchEngine;
    protected $httpClient;

    protected $provinceId;
    protected $result;
    protected $searchKeys = [];

    public function __construct(string $apikey, string $mode = "starter")
    {
        Config::setApiKey($apikey);
        Config::setApiMode($mode);

        $this->searchEngine = new FuzzySearch();
        $this->searchEngine::setSearchKeys($this->searchKeys);

        $this->httpClient = new HttpClient();
    }

    public function setSearch(ISearch $search): self
    {
        $this->searchEngine = $search;
        return $this;
    }

    public function getSearchInstance(): ISearch
    {
        return $this->searchEngine;
    }

    public function setSearchKeys(array $keys): AbstractApiResource
    {
        $this->searchEngine::setSearchKeys($keys);
        return $this;
    }

    public function setSearchThreshold(float $threshold): AbstractApiResource
    {
        $this->searchEngine::setSearchThreshold($threshold);
        return $this;
    }

    public abstract function find($search): array;

    public abstract function search($search): IResponse;
}
