<?php
use Migrations\AbstractMigration;

class CreatePr extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('pr');
        $table->addColumn('date', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('section', 'string', [
            'default' => null,
            'limit' => 30,
            'null' => false,
        ]);
        $table->addColumn('so_no', 'string', [
            'default' => null,
            'limit' => 130,
            'null' => false,
        ]);
        $table->addColumn('purchase_type', 'string', [
            'default' => null,
            'limit' => 130,
            'null' => true,
        ]);
        $table->addColumn('status', 'string', [
            'default' => null,
            'limit' => 130,
            'null' => true,
        ]);
        $table->addColumn('created_by', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('verified_by', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('approved_by', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
