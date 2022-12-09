<?php

namespace Nekoding\Rajaongkir\Resources;

use Nekoding\Rajaongkir\Contracts\IResponseSearch;
use Nekoding\Rajaongkir\Utils\SearchData;

class City extends AbstractApiResource
{

    protected $searchKeys = ["city_name"];

    public function find($provinceId): array
    {
        $url = $this->httpClient->buildUrl("/city", ['id' => $provinceId]);
        $res = $this->httpClient->request('GET', $url)->getBody();

        $json = $res[$this->getWrapperKeys()];

        if ($json["status"]["code"] != 200) {
            throw new \Nekoding\Rajaongkir\Exceptions\RajaongkirException($json["status"]["description"]);
        }

        return $json;
    }

    public function get(): array
    {
        $url = $this->httpClient->buildUrl("/city");
        $res = $this->httpClient->request("GET", $url)->getBody();

        $json = $res[$this->getWrapperKeys()];

        if ($json["status"]["code"] != 200) {
            throw new \Nekoding\Rajaongkir\Exceptions\RajaongkirException($json["status"]["description"]);
        }

        return $json;
    }

    public function search($search): IResponseSearch
    {
        $data = $this->get();

        return new SearchData(
            $data["results"],
            $this->fuzzySearch,
            $search
        );
    }
}
