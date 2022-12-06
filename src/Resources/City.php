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
        return $this->httpClient->request("GET", $url);
    }

    public function search($search): IResponse
    {
        $res = $this->httpClient->request("GET", $this->httpClient->buildUrl("/city"));
        return new Response($res, $this->searchEngine, $search);
    }

}