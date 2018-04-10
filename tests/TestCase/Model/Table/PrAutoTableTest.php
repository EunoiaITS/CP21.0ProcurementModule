<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PrAutoTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PrAutoTable Test Case
 */
class PrAutoTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PrAutoTable
     */
    public $PrAuto;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.pr_auto',
        'app.pr_auto_items'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PrAuto') ? [] : ['className' => PrAutoTable::class];
        $this->PrAuto = TableRegistry::get('PrAuto', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PrAuto);

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
