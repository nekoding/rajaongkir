<?php

namespace Nekoding\Rajaongkir\Resources;

use Nekoding\Rajaongkir\Contracts\IResponse;
use Nekoding\Rajaongkir\Contracts\ISearch;
use Nekoding\Rajaongkir\Utils\FuzzySearch;
use Nekoding\Rajaongkir\Utils\Response;

class Province extends AbstractApiResource
{

    protected $searchKeys = ["province"];

    public function find($provinceId): array
    {
        $url = $this->httpClient->buildUrl("/province", ['id' => $provinceId]);
        return $this->httpClient->request('GET', $url);
    }

    public function search($search): IResponse
    {
        $res = $this->httpClient->request("GET", $this->httpClient->buildUrl("/province"));
        return new Response($res, $this->searchEngine, $search);
    }
}
