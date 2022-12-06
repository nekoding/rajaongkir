<?php

namespace Nekoding\Rajaongkir\Resources;

use Nekoding\Rajaongkir\Contracts\IResponse;
use Nekoding\Rajaongkir\Contracts\ISearch;
use Nekoding\Rajaongkir\Utils\FuzzySearch;

abstract class AbstractApiResource
{

    const BASE_URL = 'https://api.rajaongkir.com';

    protected $apikey;
    protected $mode;
    protected $searchEngine;
    protected $httpClient;
    protected $httpHandler = [];
    protected $httpHeader = [
        'accept' => 'application/json'
    ];

    protected $provinceId;
    protected $result;

    public function __construct(string $apikey, string $mode = "starter")
    {
        $this->apikey = $apikey;
        $this->mode = $mode;

        // default
        $this->searchEngine = new FuzzySearch();
        $this->httpClient = new \GuzzleHttp\Client($this->httpHandler);

        // attach api key
        $this->setHeader([
            'key' => $apikey
        ]);
    }

    protected function buildUrl(string $endpoint, array $data = []): string
    {

        if (strpos($endpoint, "/") === 0 || strpos($endpoint, "/") === strlen($endpoint)) {
            $endpoint = str_replace("/", "", $endpoint);
        }

        $url = sprintf("%s/%s/%s", self::BASE_URL, $this->mode, $endpoint);

        if (empty($data)) {
            return $url;
        }

        $query = http_build_query($data);
        return sprintf("%s?%s", $url, $query);
    }

    protected function request(string $httpMethod, $url): array
    {
        $req = $this->httpClient->request($httpMethod, $url, [
            'headers' => $this->getHeader()
        ]);

        $res = (string) $req->getBody();

        $json = json_decode($res, true);

        if ($json['rajaongkir']['status']['code'] != 200) {
            throw new \Nekoding\Rajaongkir\Exceptions\RajaongkirException($json['rajaongkir']['status']['description']);
        }

        return $json['rajaongkir'];
    }

    public function setHttpHandler(array $handler): self
    {
        $this->httpHandler = $handler;
        return $this;
    }

    public function setHeader(array $headers): self
    {
        $this->httpHeader = array_merge($this->httpHeader, $headers);
        return $this;
    }

    public function getHeader(): array
    {
        return $this->httpHeader;
    }

    public function setSearch(ISearch $search): self
    {
        $this->searchEngine = $search;
        return $this;
    }

    public function setSearchKeys(array $keys): self
    {
        $this->searchEngine::setSearchKeys($keys);
        return $this;
    }

    public function setSearchThreshold(float $threshold): self
    {
        $this->searchEngine::setSearchThreshold($threshold);
        return $this;
    }

    public function setSearchOptions(array $options): self
    {
        $this->searchEngine::setSearchOptions($options);
        return $this;
    }

    public abstract function find($search): array;

    public abstract function search($search): IResponse;
}
