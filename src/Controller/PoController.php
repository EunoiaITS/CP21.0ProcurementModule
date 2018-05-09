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
    public function generate()
    {
        $pr = new \stdClass();
        $j = $this->request->getData('radio-btn');
        $pr->so_no = $this->request->getData('so_no'.$j);
        $pr->date = $this->request->getData('date'.$j);
        $pr->del_date = $this->request->getData('delivery_date'.$j);
        $pr->desc = $this->request->getData('description'.$j);
        $pr->cus = $this->request->getData('customer'.$j);
        $pr->pr_id = $this->request->getData('pr_id'.$j);
        $last_po = $this->Po->find('all',['fields'=>'id'])->last();
        $pr_items = array();
        if($this->request->getData('item_count-'.$j) != null){
            $item_count = $this->request->getData('item_count-'.$j);
            for($i = 1; $i <= $item_count;$i++){
                $pr_items[$i]['part_no'] = $this->request->getData('part_no-'.$j.'-'.$i);
                $pr_items[$i]['part_name'] = $this->request->getData('part_name-'.$j.'-'.$i);
                $pr_items[$i]['category'] = $this->request->getData('category-'.$j.'-'.$i);
                $pr_items[$i]['req_quantity'] = $this->request->getData('req_quantity-'.$j.'-'.$i);
                $pr_items[$i]['stock_available'] = $this->request->getData('stock_available-'.$j.'-'.$i);
                $pr_items[$i]['order_qty'] = $this->request->getData('order_qty-'.$j.'-'.$i);
                $pr_items[$i]['supplier'] = $this->request->getData('supplier-'.$j.'-'.$i);
                $pr_items[$i]['sub_total'] = $this->request->getData('sub_total-'.$j.'-'.$i);
                $pr_items[$i]['gst'] = $this->request->getData('gst-'.$j.'-'.$i);
                $pr_items[$i]['total'] = $this->request->getData('total-'.$j.'-'.$i);
            }
        }
        $this->set('pr_items',$pr_items);
        $this->set('pr',$pr);
        $this->set('po',(isset($last_po->id) ? ($last_po->id + 1) : 1));
    }
    public function submit(){
        $this->loadModel('Po');
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
