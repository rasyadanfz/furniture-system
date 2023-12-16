<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FurnitureMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nama' => ['type' => 'VARCHAR', 'constraint' => 255],
            'harga' => ['type' => 'INT', 'constraint' => 11],
            'jenisMaterial' => ['type' => 'VARCHAR', 'constraint' => 255],
            'merekMaterial' => ['type' => 'VARCHAR', 'constraint' => 255],
            'berat' => ['type' => 'FLOAT'],
            'warna' => ['type' => 'VARCHAR', 'constraint' => 255],
            'stok' => ['type' => 'INT', 'constraint' => 11],
            'rating' => ['type' => 'FLOAT'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('furnitures');
        echo ("Table 'furnitures' created\n");
    }

    public function down()
    {
        $this->forge->dropTable('furnitures');
    }
}
