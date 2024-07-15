<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'alamat' => [
                'type' => 'TEXT',
            ],
            'ongkir' => [
                'type' => 'FLOAT',
                'constraint' => '10,2',
            ],
            'total' => [
                'type' => 'FLOAT',
                'constraint' => '10,2',
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => 'belum selesai',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
