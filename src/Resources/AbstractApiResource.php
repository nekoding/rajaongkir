<?php

namespace Nekoding\Rajaongkir\Resources;

use Nekoding\Rajaongkir\Contracts\IResponse;
use Nekoding\Rajaongkir\Contracts\IResponseSearch;
use Nekoding\Rajaongkir\Contracts\ISearch;
use Nekoding\Rajaongkir\Contracts\ISearchOptions;
use Nekoding\Rajaongkir\Utils\Config;
use Nekoding\Rajaongkir\Utils\FuzzySearch;
use Nekoding\Rajaongkir\Utils\HttpClient;

abstract class AbstractApiResource
{
    protected $searchEngine;
    protected $httpClient;

    protected $result;
    protected $searchKeys = [];

    /**
     * construct object
     *
     * @param string $apikey
     * @param string $mode
     */
    public function __construct(string $apikey, string $mode = "starter")
    {
        Config::setApiKey($apikey);
        Config::setApiMode($mode);

        $this->searchEngine = new FuzzySearch();
        $this->searchEngine::setSearchKeys($this->searchKeys);

        $this->httpClient = new HttpClient();
    }

    /**
     * Find data by id
     *
     * @param int|string $search
     * @return array
     */
    public abstract function find($search): array;

    /**
     * Search data by array keys
     *
     * @param string $search
     * @return IResponseSearch
     */
    public abstract function search($search): IResponseSearch;
}
