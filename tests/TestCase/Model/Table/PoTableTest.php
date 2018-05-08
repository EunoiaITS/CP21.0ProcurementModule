<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PoTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PoTable Test Case
 */
class PoTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PoTable
     */
    public $Po;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.po',
        'app.prs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Po') ? [] : ['className' => PoTable::class];
        $this->Po = TableRegistry::get('Po', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Po);

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
