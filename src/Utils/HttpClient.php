<?php

namespace Nekoding\Rajaongkir\Utils;

class HttpClient
{

    const BASE_URL = 'https://api.rajaongkir.com';

    protected $httpClient;
    protected static $httpHeader = [
        'accept' => 'application/json'
    ];

    protected static $config = [];

    public function __construct()
    {
        $this->httpClient = new \GuzzleHttp\Client(self::$config);
    }

    public function buildUrl(string $endpoint, array $data = []): string
    {

        if (strpos($endpoint, "/") === 0 || strpos($endpoint, "/") === strlen($endpoint)) {
            $endpoint = str_replace("/", "", $endpoint);
        }

        $url = sprintf("%s/%s/%s", self::BASE_URL, Config::getApiMode(), $endpoint);

        if (empty($data)) {
            return $url;
        }

        $query = http_build_query($data);
        return sprintf("%s?%s", $url, $query);
    }

    public function request(string $httpMethod, $url): array
    {
        $req = $this->httpClient->request($httpMethod, $url, [
            'headers' => array_merge(
                self::getHeader(),
                [
                    'key'   => Config::getApiKey()
                ]
            )
        ]);

        $res = (string) $req->getBody();

        $json = json_decode($res, true);

        if ($json['rajaongkir']['status']['code'] != 200) {
            throw new \Nekoding\Rajaongkir\Exceptions\RajaongkirException($json['rajaongkir']['status']['description']);
        }

        return $json['rajaongkir'];
    }

    public static function setConfig($configurations)
    {
        self::$config  = $configurations;
    }

    public static function getConfig(): array
    {
        return self::$config;
    }

    public static function setHeader(array $headers)
    {
        self::$httpHeader = array_merge(self::$httpHeader, $headers);
    }

    public static function getHeader(): array
    {
        return self::$httpHeader;
    }
}
