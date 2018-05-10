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
        $this->loadModel('Pr');
        $this->loadModel('PrItems');
        $this->loadModel('Supplier');
        $pr = $this->Pr->find('all')
            ->Where(['status' => 'requested']);
        $count = 0;
        foreach ($pr as $pa){
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
            $auto_items = $this->PrItems->find('all')
                ->Where(['pr_id'=>$pa->id]);
            foreach($auto_items as $i){
                $supplier = '';
                if($i->supplier_id !== null){
                    $supplier = $this->Supplier->get($i->supplier_id, [
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
                    $stockAvailable = 0;
                    $urlToStore = 'http://storemodule.acumenits.com/in-stock-code/stock-available';
                    $sendToStore = [
                        'part_no' => $dataFromEng->partNo,
                        'part_name' => $dataFromEng->partName
                    ];


                    $optionsForStore = [
                        'http' => [
                            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                            'method'  => 'POST',
                            'content' => http_build_query($sendToStore)
                        ]
                    ];
                    $contextForStore = stream_context_create($optionsForStore);
                    $resultFromStore = file_get_contents($urlToStore, false, $contextForStore);
                    if($resultFromStore != FALSE){
                        $dataFromStore = json_decode($resultFromStore);
                        $stockAvailable = abs($dataFromStore->stock_available);
                    }
                    $i->stock = $stockAvailable;
                }

            }
            $pa->items = $auto_items;
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
    public function generate()
    {
        $this->loadModel('Pr');
        $this->loadModel('PrItems');
        $this->loadModel('Supplier');
        $rad_val = $this->request->getData('radio_btn');
        $pr_no = $this->request->getData('pr_no'.$rad_val);
        $pr = $this->Pr->get($pr_no, [
            'contain' => []
        ]);
        $urlToSales = 'http://salesmodule.acumenits.com/api/so-data?so='.rawurlencode($pr->so_no);

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
                $pr->del_date = $s->delivery_date;
                $pr->customer = $s->cus->name;
                foreach ($s->soi as $smv){
                    $pr->model = $smv->model;
                    $pr->version = $smv->version;
                }
            }
        }
        $auto_items = $this->PrItems->find('all')
            ->Where(['pr_id' => $pr->id]);
        foreach($auto_items as $i){
            $supplier = '';
            if($i->supplier_id !== null){
                $supplier = $this->Supplier->get($i->supplier_id, [
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
                $stockAvailable = 0;
                $urlToStore = 'http://storemodule.acumenits.com/in-stock-code/stock-available';
                $sendToStore = [
                    'part_no' => $dataFromEng->partNo,
                    'part_name' => $dataFromEng->partName
                ];


                $optionsForStore = [
                    'http' => [
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method'  => 'POST',
                        'content' => http_build_query($sendToStore)
                    ]
                ];
                $contextForStore = stream_context_create($optionsForStore);
                $resultFromStore = file_get_contents($urlToStore, false, $contextForStore);
                if($resultFromStore != FALSE){
                    $dataFromStore = json_decode($resultFromStore);
                    $stockAvailable = abs($dataFromStore->stock_available);
                }
                $i->stock = $stockAvailable;
            }

        }
        $pr->items = $auto_items;
        $last_po = $this->Po->find('all',['fields'=>'id'])->last();
        $this->set('po', (isset($last_po->id) ? ($last_po->id + 1) : 1));
        $this->set('pr',$pr);
        $this->set('pr_id',$pr_no);
    }
    public function submit(){
        $this->autoRender = false;
        if($this->request->is('post')){
            $po = $this->Po->newEntity();
            $po->pr_id = $this->request->getData('pr_id');
            $po->status = $this->request->getData('status');
            $po->created_by = $this->request->getData('created_by');
            if($this->Po->save($po)){
                $this->Flash->success(__('The Po has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Po could not be saved. Please, try again.'));
        }
    }


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
