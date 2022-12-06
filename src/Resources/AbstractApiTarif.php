<?php

namespace Nekoding\Rajaongkir\Resources;

use Nekoding\Rajaongkir\Utils\Config;
use Nekoding\Rajaongkir\Utils\HttpClient;

abstract class AbstractApiTarif
{
    protected $httpClient;

    protected $result;
    protected $body;

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

    public function setData(array $data): self
    {
        $this->body = $data;
        return $this;
    }

    public function getData(): ?array
    {
        return $this->body;
    }

    public abstract function get(): array;
}
