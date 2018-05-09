<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PrTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PrTable Test Case
 */
class PrTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PrTable
     */
    public $Pr;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.pr',
        'app.po',
        'app.prs',
        'app.pr_items'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Pr') ? [] : ['className' => PrTable::class];
        $this->Pr = TableRegistry::get('Pr', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Pr);

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
