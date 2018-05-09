<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PrItemsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PrItemsTable Test Case
 */
class PrItemsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PrItemsTable
     */
    public $PrItems;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.pr_items',
        'app.prs',
        'app.bom_parts',
        'app.suppliers',
        'app.supplier_items',
        'app.supplier'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PrItems') ? [] : ['className' => PrItemsTable::class];
        $this->PrItems = TableRegistry::get('PrItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PrItems);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
