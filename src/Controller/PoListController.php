<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PoList Controller
 *
 *
 * @method \App\Model\Entity\PoList[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PoListController extends AppController
{

    public function initialize(){
        parent::initialize();
        $this->viewBuilder()->setLayout('mainframe');
        set_time_limit(0);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        //
    }

    public function mds(){
        //
    }

    public function report(){
        //
    }

    public function search(){
        //
    }

    public function partDetails(){
        //
    }

}
