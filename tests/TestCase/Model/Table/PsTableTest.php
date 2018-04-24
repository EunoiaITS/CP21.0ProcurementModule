<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PsTable Test Case
 */
class PsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PsTable
     */
    public $Ps;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ps'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Ps') ? [] : ['className' => PsTable::class];
        $this->Ps = TableRegistry::get('Ps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Ps);

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
