<?php

use Nekoding\Rajaongkir\Resources\Province;

require "../vendor/autoload.php";

$rajaongkir = new Province("apikey");
$rajaongkir;
$result = $rajaongkir->find(123);

// or

$result = $rajaongkir->search('kalimantan')->get();
$result = $rajaongkir->search('kalimantan barat')->first();
