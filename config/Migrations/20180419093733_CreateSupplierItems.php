<?php
use Migrations\AbstractMigration;

class CreateSupplierItems extends AbstractMigration
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
        $table = $this->table('supplier_items');
        $table->addColumn('supplier_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('part_no', 'string', [
            'default' => null,
            'limit' => 130,
            'null' => false,
        ]);
        $table->addColumn('part_name', 'string', [
            'default' => null,
            'limit' => 130,
            'null' => false,
        ]);
        $table->addColumn('uom', 'string', [
            'default' => null,
            'limit' => 130,
            'null' => false,
        ]);
        $table->addColumn('unit_price', 'string', [
            'default' => null,
            'limit' => 110,
            'null' => false,
        ]);
        $table->addColumn('capability_m', 'string', [
            'default' => null,
            'limit' => 110,
            'null' => false,
        ]);
        $table->addColumn('doc_file', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('ranking', 'integer', [
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
