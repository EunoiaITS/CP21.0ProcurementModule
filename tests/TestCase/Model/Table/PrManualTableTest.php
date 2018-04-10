<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PrManualTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PrManualTable Test Case
 */
class PrManualTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PrManualTable
     */
    public $PrManual;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.pr_manual',
        'app.pr_manual_items'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PrManual') ? [] : ['className' => PrManualTable::class];
        $this->PrManual = TableRegistry::get('PrManual', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PrManual);

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
}
