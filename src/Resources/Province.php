<?php

namespace Nekoding\Rajaongkir\Resources;

use Nekoding\Rajaongkir\Contracts\IResponse;
use Nekoding\Rajaongkir\Contracts\ISearch;
use Nekoding\Rajaongkir\Utils\FuzzySearch;
use Nekoding\Rajaongkir\Utils\Response;

class Province extends AbstractApiResource
{
    public function find($provinceId): array
    {
        $url = $this->buildUrl("/province", ['id' => $provinceId]);
        return $this->request('GET', $url);
    }

    public function search($search): IResponse
    {
        $res = $this->request("GET", $this->buildUrl("/province"));
    }
}
