<?php
use Migrations\AbstractMigration;

class CreatePrItems extends AbstractMigration
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
        $table = $this->table('pr_items');
        $table->addColumn('pr_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false
        ]);
        $table->addColumn('bom_part_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false
        ]);
        $table->addColumn('order_qty', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false
        ]);
        $table->addColumn('supplier_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true
        ]);
        $table->addColumn('supplier_item_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true
        ]);
        $table->addColumn('sub_total', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false
        ]);
        $table->addColumn('gst', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true
        ]);
        $table->addColumn('total', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false
        ]);
        $table->addColumn('docs', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true
        ]);
        $table->addColumn('remark', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true
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
