<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DBSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('SET foreign_key_checks = 0');
        $this->db->table('reviews')->emptyTable();
        $this->db->table('pesanan')->emptyTable();
        $this->db->table('furnitures')->emptyTable();
        $this->db->table('customers')->emptyTable();
        $this->db->query('SET foreign_key_checks = 1');

        print_r("Seeding Furniture, please wait...\n");
        $this->call('FurnitureSeeder');
        print_r("Seeding Customer, please wait...\n");
        $this->call('CustomerSeeder');
        print_r("Seeding Pesanan, please wait...\n");
        $this->call('PesananSeeder');
        print_r("Seeding Review, please wait...\n");
        $this->call('ReviewSeeder');
    }
}