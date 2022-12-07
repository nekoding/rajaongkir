# Rajaongkir PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nekoding/rajaongkir.svg?style=flat-square)](https://packagist.org/packages/nekoding/rajaongkir)
[![Total Downloads](https://img.shields.io/packagist/dt/nekoding/rajaongkir.svg?style=flat-square)](https://packagist.org/packages/nekoding/rajaongkir)
![GitHub Actions](https://github.com/nekoding/rajaongkir/actions/workflows/main.yml/badge.svg)

Library PHP sederhana untuk konek ke API Rajaongkir. Projek ini terinspirasi dari [https://github.com/kavist/rajaongkir](https://github.com/kavist/rajaongkir)

## Installation

You can install the package via composer:

```bash
composer require nekoding/rajaongkir
```

## Usage

```php

// Menggunakan class resource
$province = new \Nekoding\Rajaongkir\Resources\Province("api_key_rajaongkir", "api_mode");
$province->find(1);

// Menggunakan wrapper class rajaongkir
\Nekoding\Rajaongkir\Utils\Config::setApiKey("api_key_rajaongkir");
\Nekoding\Rajaongkir\Utils\Config::setApiMode("starter");
$rajaongkir = new \Nekoding\Rajaongkir\Rajaongkir::province()->find(1);

// Jika ingin melakukan pencarian data berdasarkan nama provinsi
$province = new \Nekoding\Rajaongkir\Resources\Province("api_key_rajaongkir", "api_mode");
$province->search("bali")->get();

// Jika ingin melakukan pencarian data berdasarkan nama kota
$city = new \Nekoding\Rajaongkir\Resources\City("api_key_rajaongkir", "api_mode");
$city->search("denpasar")->get();

// Jika ingin melakukan pengecekan biaya ongkos kirim
$cost = new \Nekoding\Rajaongkir\Resources\Cost("api_key_rajaongkir", "api_mode");
$cost->setOrigin(501);
$cost->setDestination(114);
$cost->setWeight(1700);
$cost->setCourier("jne");

$result = $cost->get();
```

Untuk contoh lainnya cek folder `examples` atau `tests`

### Default Value

| Property    | Value       | 
| ----------- | ----------- |
| `fuse threshold` | `0.2`       | 
| `api mode`  | `starter`   |
| `province search keys`  | `province`   |
| `city search keys`  | `city_name`   |

### Testing

```bash
composer test
```

### Feature

- [x] Starter API (Province, City, Cost)
- [x] Get data by province_name, city_name (using PHP Fuse)
- [x] Support PHP 7.4, PHP 8.0, PHP 8.1

### TODO

- [ ] Basic API
- [ ] Pro API

### Province
| Method      | Parameter | Return | Deskripsi |
| ----------- | ----------- | ----------- | ----------- |
| `find` | `string $provinceId` | `array` | digunakan untuk mengambil data provinsi berdasarkan id (menggunakan api asli milik rajaongkir) |
| `search` | `string $search` | `\Nekoding\Rajaongkir\Contracts\IResponse` | digunakan untuk mengambil data berdasarkan pencarian tertentu (data diambil dari endpoint `/province` kemudian diolah menggunakan `Fuse PHP`) |



### City
| Method      | Parameter | Return | Deskripsi |
| ----------- | ----------- | ----------- | ----------- |
| `find` | `string $cityId` | `array` | digunakan untuk mengambil data kota berdasarkan id (menggunakan api asli milik rajaongkir) |
| `search` | `string $search` | `\Nekoding\Rajaongkir\Contracts\IResponse` | digunakan untuk mengambil data berdasarkan pencarian tertentu (data diambil dari endpoint `/city` kemudian diolah menggunakan `Fuse PHP`) |

### Cost
| Method      | Parameter | Return | Value | Deskripsi |
| ----------- | ----------- | ----------- | ----------- | ----------- |
| `setOrigin` | `string $origin` | `\Nekoding\Rajaongkir\Contracts\ICost` | `ID kota/kabupaten atau kecamatan asal` | Digunakan untuk mengeset nilai asal pengiriman |
| `getOrigin` | - | `string $origin` | `ID kota/kabupaten atau kecamatan asal` | Digunakan untuk mengambil nilai origin yang telah diset |
| `setOriginType` | `string $originType` | `\Nekoding\Rajaongkir\Contracts\ICost` | `city, subdistrict`  | Digunakan untuk mengeset nilai tipe asal pengiriman |
| `getOriginType` | - | `string $originType` | `city, subdistrict` | Digunakan untuk mengambil nilai tipe asal pengiriman yang telah diset |
| `setDestination` | `string $destination` | `\Nekoding\Rajaongkir\Contracts\ICost` | `ID kota/kabupaten atau kecamatan tujuan` | Digunakan untuk mengeset nilai tujuan pengiriman |
| `getDestination` | - | `string $destination` | `ID kota/kabupaten atau kecamatan tujuan` | Digunakan untuk mengambil nilai tujuan pengiriman |
| `setDestinationType` | `string $destinationType` | `\Nekoding\Rajaongkir\Contracts\ICost` | `city, subdistrict` | Digunakan untuk mengeset nilai tipe tujuan pengiriman |
| `getDestinationType` | - | `string $destinationType` | `city, subdistrict` | Digunakan untuk mengambil nilai tipe tujuan pengiriman yang telah diset |
| `setWeight` | `int $weight` | `\Nekoding\Rajaongkir\Contracts\ICost` | `gram` | Digunakan untuk mengeset nilai berat produk |
| `getWeight` | - | `int $weight`  | `gram` | Digunakan untuk mengambil nilai berat produk |
| `setCourier` | `string $courier` | `\Nekoding\Rajaongkir\Contracts\ICost` | `jne, pos, tiki, rpx, pandu, wahana, sicepat, jnt, pahala, sap, jet, indah, dse, slis, first, ncs, star, ninja, lion, idl, rex, ide, sentral, anteraja, jtl` | Digunakan untuk mengeset kode kurir |
| `getCourier` | - | `string $courier` | `jne, pos, tiki, rpx, pandu, wahana, sicepat, jnt, pahala, sap, jet, indah, dse, slis, first, ncs, star, ninja, lion, idl, rex, ide, sentral, anteraja, jtl` | Digunakan untuk mengambil kode kurir yang telah diset |
| `setLength` | `float $length` | `\Nekoding\Rajaongkir\Contracts\ICost` | `cm` | Digunakan untuk mengeset nilai panjang paket kiriman |
| `getLength` | - | `float $length` | `cm` | Digunakan untuk mengambil nilai panjang paket kiriman |
| `setWidth` | `float $width` | `\Nekoding\Rajaongkir\Contracts\ICost` | `cm` | Digunakan untuk mengeset nilai lebar paket kiriman |
| `getWidth` | - | `float $width` | `cm` | Digunakan untuk mengambil nilai lebar paket kiriman |
| `setHeight` | `float $height` | `\Nekoding\Rajaongkir\Contracts\ICost` | `cm` | Digunakan untuk mengeset nilai tinggi paket kiriman |
| `getHeight` | - | `float $height` | `cm` | Digunakan untuk mengambil nilai tinggi paket kiriman |
| `setDiameter` | `float $diameter` | `\Nekoding\Rajaongkir\Contracts\ICost` | `cm` | Digunakan untuk mengeset nilai diameter paket kiriman |
| `getDiameter` | - | `float $diameter` | `cm` | Digunakan untuk mengambil nilai diameter paket kiriman |
| `setData` | `array $data` | `\Nekoding\Rajaongkir\Resources\AbstractApiTarif` |  | Digunakan untuk mengeset form data menggunakan array |
| `getData` | - | `array $data` |  | Digunakan untuk mengambil nilai form data yang telah diset |
| `get` | - | `array` | - | Digunakan untuk melakukan pemanggilan API rajaongkir |


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
