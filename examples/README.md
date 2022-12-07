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