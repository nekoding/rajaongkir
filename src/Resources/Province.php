<?php

namespace Nekoding\Rajaongkir\Resources;

use Nekoding\Rajaongkir\Contracts\IResponse;
use Nekoding\Rajaongkir\Contracts\IResponseSearch;
use Nekoding\Rajaongkir\Contracts\ISearch;
use Nekoding\Rajaongkir\Utils\FuzzySearch;
use Nekoding\Rajaongkir\Utils\Response;
use Nekoding\Rajaongkir\Utils\SearchData;

class Province extends AbstractApiResource
{

    protected $searchKeys = ["province"];

    public function find($provinceId): array
    {
        $url = $this->httpClient->buildUrl("/province", ['id' => $provinceId]);
        $res = $this->httpClient->request('GET', $url)->getBody();

        if ($res['rajaongkir']['status']['code'] != 200) {
            throw new \Nekoding\Rajaongkir\Exceptions\RajaongkirException($res['rajaongkir']['status']['description']);
        }

        return $res["rajaongkir"];
    }

    public function search($search): IResponseSearch
    {
        $res = $this->httpClient->request("GET", $this->httpClient->buildUrl("/province"))->getBody();

        if ($res['rajaongkir']['status']['code'] != 200) {
            throw new \Nekoding\Rajaongkir\Exceptions\RajaongkirException($res['rajaongkir']['status']['description']);
        }

        $fuzzySearch = new FuzzySearch();
        $fuzzySearch->setKeys($this->searchKeys);

        return new SearchData(
            $res["rajaongkir"],
            $fuzzySearch,
            $search
        );
    }
}
