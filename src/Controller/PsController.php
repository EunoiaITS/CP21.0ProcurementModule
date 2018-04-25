<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Ps Controller
 *
 *
 * @method \App\Model\Entity\P[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('mainframe');

        $urlToSales = 'http://salesmodule.acumenits.com/api/all-data';

        $optionsForSales = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'GET'
            ]
        ];
        $contextForSales = stream_context_create($optionsForSales);
        $resultFromSales = file_get_contents($urlToSales, false, $contextForSales);
        if ($resultFromSales === FALSE) {
            echo 'ERROR!!';
        }
        $dataFromSales = json_decode($resultFromSales);

        $urlToProd = 'http://productionmodule.acumenits.com/api/all-data';
            $optionsForProd = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET',
            ]
        ];
        $contextForProd  = stream_context_create($optionsForProd);
        $resultFromProd = file_get_contents($urlToProd, false, $contextForProd);
        if ($resultFromProd === FALSE) {
            echo 'ERROR!!';
        }
        $dataFromProd = json_decode($resultFromProd);

        $this->set('sales',$dataFromProd);
    }

    /**
     * View method
     *
     * @param string|null $id P id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $p = $this->Ps->get($id, [
            'contain' => []
        ]);

        $this->set('p', $p);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
}