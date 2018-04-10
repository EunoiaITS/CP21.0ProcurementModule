<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PrAutoItemsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PrAutoItemsTable Test Case
 */
class PrAutoItemsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PrAutoItemsTable
     */
    public $PrAutoItems;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.pr_auto_items',
        'app.pr_autos',
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
        $config = TableRegistry::exists('PrAutoItems') ? [] : ['className' => PrAutoItemsTable::class];
        $this->PrAutoItems = TableRegistry::get('PrAutoItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PrAutoItems);

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
