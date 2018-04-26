<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PiTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PiTable Test Case
 */
class PiTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PiTable
     */
    public $Pi;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.pi'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Pi') ? [] : ['className' => PiTable::class];
        $this->Pi = TableRegistry::get('Pi', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Pi);

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
