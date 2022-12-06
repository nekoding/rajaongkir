<?php

namespace Nekoding\Rajaongkir;

use Nekoding\Rajaongkir\Resources\City;
use Nekoding\Rajaongkir\Resources\Cost;
use Nekoding\Rajaongkir\Resources\Province;
use Nekoding\Rajaongkir\Utils\Config;

class Rajaongkir
{
    public static function province(): Province
    {
        return new Province(Config::getApiKey(), Config::getApiMode());
    }

    public static function city(): City
    {
        return new City(Config::getApiKey(), Config::getApiMode());
    }

    public static function cost(): Cost
    {
        return new Cost(Config::getApiKey(), Config::getApiMode());
    }
}
