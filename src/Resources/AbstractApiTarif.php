<?php

namespace Nekoding\Rajaongkir\Resources;

use Nekoding\Rajaongkir\Utils\Config;
use Nekoding\Rajaongkir\Utils\HttpClient;

abstract class AbstractApiTarif
{
    protected $httpClient;

    protected $result;
    protected $body;

    /**
     * construcy object
     *
     * @param string $apikey
     * @param string $mode
     */
    public function __construct(string $apikey, string $mode = "starter")
    {
        Config::setApiKey($apikey);
        Config::setApiMode($mode);

        $this->httpClient = new HttpClient();

        // append header
        $this->httpClient::setHeader([
            "content-type" => "application/x-www-form-urlencoded"
        ]);
    }

    /**
     * set data
     *
     * @param array $data
     * @return self
     */
    public function setData(array $data): self
    {
        $this->body = $data;
        return $this;
    }

    /**
     * get data
     *
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->body;
    }

    /**
     * get api data
     *
     * @return array
     */
    public abstract function get(): array;
}
