<?php

namespace Nekoding\Rajaongkir\Utils;

class HttpClient
{

    const STARTER_BASE_URL = 'https://api.rajaongkir.com/starter';
    const BASIC_BASE_URL = "https://api.rajaongkir.com/basic";
    const PRO_BASE_URL = "https://pro.rajaongkir.com/api";

    protected $httpClient;
    protected $result;

    protected static $httpHeader = [
        'accept' => 'application/json'
    ];
    protected static $config = [];
    protected static $forms = [];

    public function __construct()
    {
        $this->boot();
    }

    public function boot()
    {
        $this->httpClient = new \GuzzleHttp\Client(self::$config);
    }

    public function buildUrl(string $endpoint, array $data = []): string
    {

        if (strpos($endpoint, "/") === 0) {
            $endpoint = trim($endpoint, "/");
        }

        if (strpos($endpoint, "/") === strlen($endpoint) - 1) {
            $endpoint = rtrim($endpoint, "/");
        }

        switch (Config::getApiMode()) {
            case Config::STARTER:
                $url = sprintf("%s/%s", self::STARTER_BASE_URL, $endpoint);
                break;

            case Config::BASIC:
                $url = sprintf("%s/%s", self::BASIC_BASE_URL, $endpoint);
                break;

            case Config::PRO:
                $url = sprintf("%s/%s", self::PRO_BASE_URL, $endpoint);
                break;

            default:
                throw new \InvalidArgumentException("api mode only accept starter, basic, or pro");
                break;
        }

        if (empty($data)) {
            return $url;
        }

        $query = http_build_query($data);
        return sprintf("%s?%s", $url, $query);
    }

    public function request(string $httpMethod, $url): self
    {
        $req = $this->httpClient->request($httpMethod, $url, [
            "headers" => array_merge(
                self::getHeader(),
                [
                    'key'   => Config::getApiKey()
                ]
            ),
            "form_params" => self::getFormParams()
        ]);

        $this->result = (string) $req->getBody();
        return $this;
    }

    public function getBody(): array
    {
        $json = json_decode($this->result, true);
        return $json;
    }

    public static function setConfig(array $configurations)
    {
        self::$config  = $configurations;
    }

    public static function getConfig(): array
    {
        return self::$config;
    }

    public static function resetConfig()
    {
        self::$config = [];
    }

    public static function setHeader(array $headers)
    {
        self::$httpHeader = array_merge(self::$httpHeader, $headers);
    }

    public static function getHeader(): array
    {
        return self::$httpHeader;
    }

    public static function resetHeader()
    {
        self::$httpHeader = [];
    }

    public static function setFormParams(array $data)
    {
        self::$forms = $data;
    }

    public static function getFormParams(): array
    {
        return self::$forms;
    }
}
