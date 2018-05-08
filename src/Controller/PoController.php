<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Po Controller
 *
 * @property \App\Model\Table\PoTable $Po
 *
 * @method \App\Model\Entity\Po[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PoController extends AppController
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
        $this->loadModel('PrManual');
        $this->loadModel('PrManualItems');
        $this->loadModel('PrAuto');
        $this->loadModel('PrAutoItems');
        $this->loadModel('Supplier');
        $pr = new \stdClass();
        $pr_auto = $this->PrAuto->find('all')
            ->Where(['status' => 'requested']);
        $count = 0;
        foreach ($pr_auto as $pa){
            $count++;
            $urlToSales = 'http://salesmodule.acumenits.com/api/so-data?so='.rawurlencode($pa->so_no);

            $optionsForSales = [
                'http' => [
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'GET'
                ]
            ];
            $contextForSales  = stream_context_create($optionsForSales);
            $resultFromSales = file_get_contents($urlToSales, false, $contextForSales);
            if ($resultFromSales !== FALSE) {
                $dataFromSales = json_decode($resultFromSales);
                foreach($dataFromSales as $s){
                    $pa->del_date = $s->delivery_date;
                    $pa->customer = $s->cus->name;
                    foreach ($s->soi as $smv){
                        $pa->model = $smv->model;
                        $pa->version = $smv->version;
                    }
                }
            }
            $auto_items = $this->PrAutoItems->find('all')
                ->Where(['pr_auto_id'=>$pa->id]);
            foreach($auto_items as $i){
                $supplier = '';
                if($i->supplier !== ''){
                    $supplier = $this->Supplier->get($i->supplier, [
                        'contain' => []
                    ]);
                }
                $i->supplier_name = $supplier;

                $urlToEng = 'http://engmodule.acumenits.com/api/bom-part/'.$i->bom_part_id;

                $optionsForEng = [
                    'http' => [
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method'  => 'GET'
                    ]
                ];
                $contextForEng  = stream_context_create($optionsForEng);
                $resultFromEng = file_get_contents($urlToEng, false, $contextForEng);
                if ($resultFromEng !== FALSE) {
                    $dataFromEng = json_decode($resultFromEng);
                    $i->eng = $dataFromEng;
                }

            }
            $pa->items = $auto_items;
            $pa->section = 'auto';
            $pr->$count = $pa;
        }

        $this->set('pr',$pr);
    }

    /**
     * View method
     *
     * @param string|null $id Po id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $po = $this->Po->get($id, [
            'contain' => ['Prs']
        ]);

        $this->set('po', $po);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $po = $this->Po->newEntity();
        if ($this->request->is('post')) {
            $po = $this->Po->patchEntity($po, $this->request->getData());
            if ($this->Po->save($po)) {
                $this->Flash->success(__('The po has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The po could not be saved. Please, try again.'));
        }
        $prs = $this->Po->Prs->find('list', ['limit' => 200]);
        $this->set(compact('po', 'prs'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Po id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $po = $this->Po->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $po = $this->Po->patchEntity($po, $this->request->getData());
            if ($this->Po->save($po)) {
                $this->Flash->success(__('The po has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The po could not be saved. Please, try again.'));
        }
        $prs = $this->Po->Prs->find('list', ['limit' => 200]);
        $this->set(compact('po', 'prs'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Po id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $po = $this->Po->get($id);
        if ($this->Po->delete($po)) {
            $this->Flash->success(__('The po has been deleted.'));
        } else {
            $this->Flash->error(__('The po could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}