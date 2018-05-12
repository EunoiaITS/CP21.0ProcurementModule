<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MdsDetailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MdsDetailsTable Test Case
 */
class MdsDetailsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MdsDetailsTable
     */
    public $MdsDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.mds_details',
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
        $config = TableRegistry::exists('MdsDetails') ? [] : ['className' => MdsDetailsTable::class];
        $this->MdsDetails = TableRegistry::get('MdsDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MdsDetails);

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
