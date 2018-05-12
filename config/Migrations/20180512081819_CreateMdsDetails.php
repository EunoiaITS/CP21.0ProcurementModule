<?php
use Migrations\AbstractMigration;

class CreateMdsDetails extends AbstractMigration
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
        $table = $this->table('mds_details');
        $table->addColumn('mds_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('del_date', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('del_qty', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->create();
    }
}
