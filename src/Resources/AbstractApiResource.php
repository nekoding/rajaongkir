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
    protected $httpClient;
    protected $fuzzySearch;
    protected $result;
    protected $searchKeys = [];
    protected $wrapperDefaultKeys = "rajaongkir";


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

        $this->boot();
    }

    protected function boot()
    {
        $this->httpClient = new HttpClient();

        // init fuse with default keys
        $fuzzySearch = new FuzzySearch();
        $fuzzySearch->setKeys($this->searchKeys);

        $this->fuzzySearch = $fuzzySearch;
    }

    public function setSearchKeys(array $keys): self
    {
        $this->searchKeys = $keys;

        if ($this->fuzzySearch instanceof ISearchOptions) {
            $this->fuzzySearch->setKeys($keys);
        }

        return $this;
    }

    public function getSearchKeys(): array
    {
        return $this->searchKeys;
    }

    public function setSearchThreshold(float $threshold): self
    {
        if ($this->fuzzySearch instanceof ISearchOptions) {
            $this->fuzzySearch->setThreshold($threshold);
        }

        return $this;
    }

    public function getWrapperKeys(): string
    {
        return $this->wrapperDefaultKeys;
    }

    /**
     * Find data by id
     *
     * @param int|string|array $search
     * @return array
     */
    public abstract function find($search): array;

    /**
     * Get all data
     *
     * @return array
     */
    public abstract function get(): array;

    /**
     * Search data by array keys
     *
     * @param string $search
     * @return IResponseSearch
     */
    public abstract function search($search): IResponseSearch;
}
