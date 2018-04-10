<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PrManualItemsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PrManualItemsTable Test Case
 */
class PrManualItemsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PrManualItemsTable
     */
    public $PrManualItems;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.pr_manual_items',
        'app.pr_manuals',
        'app.bom_parts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PrManualItems') ? [] : ['className' => PrManualItemsTable::class];
        $this->PrManualItems = TableRegistry::get('PrManualItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PrManualItems);

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
