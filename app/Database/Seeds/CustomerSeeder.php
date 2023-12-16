<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $query = "ALTER TABLE customers AUTO_INCREMENT = 1";
        $this->db->query($query);
        for ($i = 1; $i <= 250; $i++) {
            $this->db->table('customers')->insert([
                'nama' => 'Customer ' . $i,
                'username' => 'customer' . $i,
                'password' => password_hash('customer' . $i . 'password', PASSWORD_BCRYPT, ['cost' => 10]),
            ]);
        }
    }
}
