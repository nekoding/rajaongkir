<?php

use Nekoding\Rajaongkir\Resources\City;

require "../vendor/autoload.php";

// basic init
$city = new City("apikey");

// init dengan mode api
$city = new City("apikey", "starter");

// ambil data berdasarkan id kota
$city->find(114); // 

// ambil data berdasarkan nama kota (default: city_name)
$city->search("bali")->get();

// jika ingin melakukan custom config search
$city->setSearchThreshold(1)->setSearchKeys(["city_name"])->search("bali");

// jika inging menampilkan 1 data pertama dari hasil pencarian
$city->search("buleleng")->first();

// jika ingin menampilkan 1 data terakhir dari hasil pencarian
$city->search("buleleng")->last();

// jika ingin menampilkan semua data pencarian
$city->search("buleleng")->get();

// jika ingin menghitung jumlah data yang ditemukan
$city->search("bangli")->count();

// jika ingin menampilkan data berdasarkan index tertentu
$city->search("bangli")->nth(1);
