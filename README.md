# Rajaongkir PHP
<!-- ALL-CONTRIBUTORS-BADGE:START - Do not remove or modify this section -->
[![All Contributors](https://img.shields.io/badge/all_contributors-1-orange.svg?style=flat-square)](#contributors-)
<!-- ALL-CONTRIBUTORS-BADGE:END -->

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

## Contributors

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->
<table>
  <tbody>
    <tr>
      <td align="center"><a href="https://blog.enggartivandi.com"><img src="https://avatars.githubusercontent.com/u/64598048?v=4?s=100" width="100px;" alt="Enggar Tivandi"/><br /><sub><b>Enggar Tivandi</b></sub></a><br /><a href="https://github.com/nekoding/rajaongkir/commits?author=nekoding" title="Code">💻</a> <a href="https://github.com/nekoding/rajaongkir/commits?author=nekoding" title="Documentation">📖</a> <a href="#example-nekoding" title="Examples">💡</a> <a href="https://github.com/nekoding/rajaongkir/commits?author=nekoding" title="Tests">⚠️</a></td>
    </tr>
  </tbody>
</table>

<!-- markdownlint-restore -->
<!-- prettier-ignore-end -->

<!-- ALL-CONTRIBUTORS-LIST:END -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->

<!-- markdownlint-restore -->
<!-- prettier-ignore-end -->

<!-- ALL-CONTRIBUTORS-LIST:END -->

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
