<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ReviewMigration extends Migration
{
    public function up()
    {
        $this->db->query('SET foreign_key_checks = 0');
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'pesanan_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'furniture_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'rating' => [
                'type' => 'FLOAT',
            ],
            'durability_score' => [
                'type' => 'FLOAT',
            ],
            'texture_score' => [
                'type' => 'FLOAT',
            ],
            'maintainability_score' => [
                'type' => 'FLOAT',
            ],
            'date_created' => [
                'type' => 'DATE',
            ],
        ]);

        $this->forge->addForeignKey('furniture_id', 'furnitures', 'id');
        $this->forge->addForeignKey('pesanan_id', 'pesanan', 'id');
        $this->forge->addKey('id', true);
        $this->forge->createTable('reviews');
        $this->db->query('SET foreign_key_checks = 1');
    }

    public function down()
    {
        $this->forge->dropTable('reviews');
    }
}
