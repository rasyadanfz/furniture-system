<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FurnitureSeeder extends Seeder
{
    public function run()
    {
        $query = "ALTER TABLE furnitures AUTO_INCREMENT = 1";
        $this->db->query($query);
        // Generate seeders data
        $data = 
        [
            [
                "nama" => "Kursi Kecil",
                "harga" => 35000,
                "jenisMaterial" => "Walnut",
                "merekMaterial" => "Mizuno",
                "berat" => 3.0,
                "warna" => "Coklat Muda",
                "stok" => 20,
                "rating" => 4.3
            ],
            [
                "nama" => "Bangku",
                "harga" => 100000,
                "jenisMaterial" => "Birch",
                "merekMaterial" => "Wilson",
                "berat" => 7.0,
                "warna" => "Hitam",
                "stok" => 15,
                "rating" => 4.5
            ],
            [
                "nama" => "Meja Kecil",
                "harga" => 50000,
                "jenisMaterial" => "Oak",
                "merekMaterial" => "Wilson",
                "berat" => 5.0,
                "warna" => "Coklat Tua",
                "stok" => 18,
                "rating" => 4.6
            ],
            [
                "nama" => "Meja Besar",
                "harga" => 120000,
                "jenisMaterial" => "Pine",
                "merekMaterial" => "Bridgestone",
                "berat" => 6.0,
                "warna" => "Silver",
                "stok" => 10,
                "rating" => 4.8
            ],
            [
                "nama" => "Lemari Pakaian",
                "harga" => 55000,
                "jenisMaterial" => "Birch",
                "merekMaterial" => "Adams",
                "berat" => 7.0,
                "warna" => "Hitam",
                "stok" => 12,
                "rating" => 4.4
            ],
            [
                "nama" => "Kasur",
                "harga" => 75000,
                "jenisMaterial" => "Cedar",
                "merekMaterial" => "Ping",
                "berat" => 6.0,
                "warna" => "Abu-abu",
                "stok" => 5,
                "rating" => 4.9
            ],
            [
                "nama" => "Meja Lipat",
                "harga" => 20000,
                "jenisMaterial" => "Teak",
                "merekMaterial" => "Titleist",
                "berat" => 3.0,
                "warna" => "Putih",
                "stok" => 25,
                "rating" => 4.2
            ],
            [
                "nama" => "Sofa",
                "harga" => 100000,
                "jenisMaterial" => "Ash",
                "merekMaterial" => "Srixon",
                "berat" => 5.5,
                "warna" => "Merah",
                "stok" => 10,
                "rating" => 4.7
            ],
            [
                "nama" => "Lemari Buku",
                "harga" => 45000,
                "jenisMaterial" => "Pine",
                "merekMaterial" => "TaylorMade",
                "berat" => 7,
                "warna" => "Abu-abu",
                "stok" => 15,
                "rating" => 4.6
            ],
            [
                "nama" => "Meja TV",
                "harga" => 100000,
                "jenisMaterial" => "Maple",
                "merekMaterial" => "Cobra",
                "berat" => 6.5,
                "warna" => "Silver",
                "stok" => 20,
                "rating" => 4.4
            ],
        ];

        foreach ($data as $key => $value) {
            $this->db->table('furnitures')->insert($value);
        }
    }
}
