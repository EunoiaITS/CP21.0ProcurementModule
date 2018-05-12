<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MdsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MdsTable Test Case
 */
class MdsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MdsTable
     */
    public $Mds;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.mds',
        'app.pr_items',
        'app.pr',
        'app.po'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Mds') ? [] : ['className' => MdsTable::class];
        $this->Mds = TableRegistry::get('Mds', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Mds);

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
