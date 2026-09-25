<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbSupport extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'clinic_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'province' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'machine' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'technician' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'concern' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'machine_status' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'service_status' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'service_engr' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'support_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'waiting',
                'null' => false,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'accepted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'status_updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tb_support', true);
    }

    public function down()
    {
        $this->forge->dropTable('tb_support', true);
    }
}
