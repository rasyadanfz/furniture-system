<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PesananMigration extends Migration
{
    public function up()
    {
        $this->db->query('SET foreign_key_checks = 0');
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'waktuPesanan' => [
                'type' => 'DATE',
            ],
            'customer_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'kuantitas' => [
                'type' => 'INT',
            ],
            'total_harga' => [
                'type' => 'INT',
            ],
            'furniture_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('customer_id', 'customers', 'id');
        $this->forge->addForeignKey('furniture_id', 'furnitures', 'id');
        $this->forge->createTable('pesanan');
        $this->db->query('SET foreign_key_checks = 1');
    }

    public function down()
    {
        $this->forge->dropTable('pesanan');
    }
}
