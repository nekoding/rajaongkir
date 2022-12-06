<?php

use Nekoding\Rajaongkir\Resources\Cost;

require "../vendor/autoload.php";

// basic init
$cost = new Cost("xx");

// custom dengan api mode
$cost = new Cost("xx", "starter");

$cost->setData([
    'origin' => '1223',
    'asdas'  => 'asdasd',
    'asdasd' => 'asdasd',
    'asdasd' => 'asdasd'
])->get();  // global set data

// atau menggunakan API
$cost->setOrigin(501); // lokasi pengiriman Yogyakarta
$cost->setOriginType("city");   // set origin id sebagai city
$cost->setDestination(574);     // set lokasi tujuan pengiriman (Banyumas)
$cost->setDestinationType("subdistrict");   // set tipe destinasi subdistrict / kecamatan
$cost->setWeight(1800); // set berat paket
$cost->setCourier("jne");   // set nama kurir
$cost->setLength(100);  // set panjang paket
$cost->setWidth(100);   // set lebar paket
$cost->setHeight(100);  // set tinggi pake
$cost->setDiameter(100);    // set diameter paket

$cost->get(); // api call ke rajaongkir
