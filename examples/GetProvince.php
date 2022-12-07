<?php

use Nekoding\Rajaongkir\Resources\Province;
use Nekoding\Rajaongkir\Utils\FuzzySearch;

require "../vendor/autoload.php";

// basic init
$province = new Province("apikey");

// init dengan mode api
$province = new Province("apikey", "starter");

// ambil data berdasarkan id provinsi
$province->find(1); // 

// ambil data berdasarkan nama provinsi (default: province)
$province->search("bali")->get();

// jika ingin melakukan custom config search
$city->setSearchThreshold(1)->setSearchKeys(["province"])->search("bali");

// jika inging menampilkan 1 data pertama dari hasil pencarian
$province->search("kalimantan")->first();

// jika ingin menampilkan 1 data terakhir dari hasil pencarian
$province->search("kalimantan")->last();

// jika ingin menampilkan semua data pencarian
$province->search("kalimantan")->get();

// jika ingin menghitung jumlah data yang ditemukan
$province->search("sumatera")->count();

// jika ingin menampilkan data berdasarkan index tertentu
$province->search("sumatera")->nth(1);
