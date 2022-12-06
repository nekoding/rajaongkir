<?php

namespace Nekoding\Rajaongkir\Resources;

use Nekoding\Rajaongkir\Contracts\IResponse;
use Nekoding\Rajaongkir\Utils\Response;

class City extends AbstractApiResource
{

    protected $searchKeys = ["city_name"];

    public function find($cityId): array
    {
        $url = $this->httpClient->buildUrl("/city", ["id" => $cityId]);
        $res = $this->httpClient->request("GET", $url)->getBody();

        if ($res['rajaongkir']['status']['code'] != 200) {
            throw new \Nekoding\Rajaongkir\Exceptions\RajaongkirException($res['rajaongkir']['status']['description']);
        }

        return $res["rajaongkir"];
    }

    public function search($search): IResponse
    {
        $res = $this->httpClient->request("GET", $this->httpClient->buildUrl("/city"))->getBody();

        if ($res['rajaongkir']['status']['code'] != 200) {
            throw new \Nekoding\Rajaongkir\Exceptions\RajaongkirException($res['rajaongkir']['status']['description']);
        }

        return new Response($res["rajaongkir"], $this->searchEngine, $search);
    }
}
