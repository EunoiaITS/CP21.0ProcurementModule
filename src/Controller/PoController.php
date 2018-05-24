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
    public function requests(){
        $po = null;
        if($this->Auth->user('role') == 'requester'){
            $po = $this->Po->find('all')
                ->Where(['status'=>'requested'])
                ->orWhere(['status' => 'rejected']);
        }
        if($this->Auth->user('role') == 'verifier'){
            $po = $this->Po->find('all')
                ->Where(['status'=>'requested']);
        }
        if($this->Auth->user('role') == 'approver-1'){
            $po = $this->Po->find('all')
                ->where(['status' => 'verified']);
        }
        if($this->Auth->user('role') == 'approver-2'){
            $po = $this->Po->find('all')
                ->where(['status' => 'approved1']);
        }
        if($this->Auth->user('role') == 'approver-3'){
            $po = $this->Po->find('all')
                ->where(['status' => 'approved2']);
        }
        $this->loadModel('Users');
        foreach ($po as $p){
            $created_by = $this->Users->get($p->created_by);
            if($p->verified_by != null ){
                $verified_by = $this->Users->get($p->verified_by);
                $p->verified_by = $verified_by;
            }
            if($p->approved_by != null ){
                $approved_by = $this->Users->get($p->approved_by);
                $p->approved_by = $approved_by;
            }
            $p->created_by = $created_by;
        }
        $this->set('po', $po);
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
            ->Where(['status' => 'approved']);
        $count = 0;
        foreach ($pr as $pa){
            $po = $this->Po->find('all')
                ->Where(['pr_id'=>$pa->id]);
            if(!$po->isEmpty()){
                $pa->po_exists = 'yes';
            }
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
        $this->loadModel('Pr');
        $this->loadModel('PrItems');
        $this->loadModel('Supplier');
        $this->loadModel('Users');
        $po = $this->Po->get($id, [
            'contain' => []
        ]);
        $created_by = $this->Users->get($po->created_by);
        if($po->verified_by != null ){
            $verified_by = $this->Users->get($po->verified_by);
            $po->verified_by = $verified_by;
        }
        if($po->approve1_by != null ){
            $approve1_by = $this->Users->get($po->approve1_by);
            $po->approve1_by = $approve1_by;
        }
        if($po->approve2_by != null ){
            $approve2_by = $this->Users->get($po->approve2_by);
            $po->approve2_by = $approve2_by;
        }
        if($po->approve3_by != null ){
            $approve3_by = $this->Users->get($po->approve3_by);
            $po->approve3_by = $approve3_by;
        }

        $po->created_by = $created_by;

        $pr = $this->Pr->get($po->pr_id, [
            'contain' => []
        ]);
        $po->so_no = $pr->so_no;

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
                $po->del_date = $s->delivery_date;
                $po->customer = $s->cus->name;
                foreach ($s->soi as $smv){
                    $po->model = $smv->model;
                    $po->version = $smv->version;
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
        $po->items = $auto_items;
        $this->set('pic',$this->Auth->user('id'));
        $this->set('pr', $po);
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
            $po->date = date('Y-m-d');
            $po->status = $this->request->getData('status');
            $po->created_by = $this->request->getData('created_by');
            if($this->Po->save($po)){
                $this->Flash->success(__('The Po has been saved.'));
                return $this->redirect(['action' => 'requests']);
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

                return $this->redirect(['action' => 'requests']);
            }
            $this->Flash->error(__('The po could not be saved. Please, try again.'));
        }
        $prs = $this->Po->Prs->find('list', ['limit' => 200]);
        $this->set(compact('po'));
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

    public function report(){
        $this->loadModel('Pr');
        $this->loadModel('PrItems');
        $this->loadModel('Supplier');
        $this->loadModel('Users');
        $po = $this->Po->find('all');
        foreach ($po as $p){
            $pr = $this->Pr->get($p->pr_id, [
                'contain' => []
            ]);
            $p->pr = $pr;
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
                    $p->del_date = $s->delivery_date;
                    $p->customer = $s->cus->name;
                    foreach ($s->soi as $smv){
                        $p->model = $smv->model;
                        $p->version = $smv->version;
                    }
                }
            }
            $items = $this->PrItems->find('all')
                ->Where(['pr_id' => $p->pr_id]);
            foreach($items as $i){
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
            $p->items = $items;
            $p->requester = $this->Users->get($p->created_by);
        }
        $this->set('po',$po);

    }

    public function approvalStatus(){
        $this->loadModel('Pr');
        $this->loadModel('PrItems');
        $this->loadModel('Supplier');
        $this->loadModel('Users');
        $po = $this->Po->find('all');
        foreach ($po as $p){
            $pr = $this->Pr->get($p->pr_id, [
                'contain' => []
            ]);
            $p->pr = $pr;
            $created_by = $this->Users->get($p->created_by);
            if($p->verified_by != null){
                $verified_by = $this->Users->get($p->verified_by);
                $p->verified_by = $verified_by;
            }
            if($p->approve1_by != null){
                $approve1_by = $this->Users->get($p->approve1_by);
                $p->approve1_by = $approve1_by;
            }
            if($p->approve2_by != null){
                $approve2_by = $this->Users->get($p->approve2_by);
                $p->approve2_by = $approve2_by;
            }
            if($p->approve3_by != null){
                $approve3_by = $this->Users->get($p->approve3_by);
                $p->approve3_by = $approve3_by;
            }
            $p->created_by = $created_by;
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
                    $p->del_date = $s->delivery_date;
                    $p->customer = $s->cus->name;
                    foreach ($s->soi as $smv){
                        $p->model = $smv->model;
                        $p->version = $smv->version;
                    }
                }
            }
            $items = $this->PrItems->find('all')
                ->Where(['pr_id' => $p->pr_id]);
            foreach($items as $i){
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
            $p->items = $items;
        }
        $this->set('po',$po);
    }


    public function statReport(){
        $month = $this->request->getQuery('month');
        $year = $this->request->getQuery('year');
        if($month == null){
            $month = date('m');
        }
        if($year == null){
            $year = date('Y');
        }
        $this->loadModel('PrItems');
        $this->loadModel('Pr');
        $total = $this->Po->find('all');
        $approve = $this->Po->find('all')
            ->Where(['status'=>'approved3']);
        $request = $this->Po->find('all')
            ->Where(['status'=>'requested'])
            ->orWhere(['status'=>'verified'])
            ->orWhere(['status'=>'approved1'])
            ->orWhere(['status'=>'approved2']);
        $reject = $this->Po->find('all')
            ->Where(['status'=>'rejected']);
        $total_count = $approve_count = $request_count = $reject_count = $am_count = 0;
        foreach ($total as $t) {
            if (date('Y-m', strtotime($t->date)) == $year . '-' . $month){
                $total_count++;
                $items = $this->PrItems->find('all')
                    ->Where(['pr_id',$t->pr_id]);
                foreach ($items as $i){
                    $am_count += $i->total;
                }
            }
        }
        foreach ($approve as $a) {
            if (date('Y-m', strtotime($a->date)) == $year . '-' . $month){
                $approve_count++;
            }
        }
        foreach ($request as $r) {
            if (date('Y-m', strtotime($r->date)) == $year . '-' . $month){
                $request_count++;
            }
        }
        foreach ($reject as $re) {
            if (date('Y-m', strtotime($re->date)) == $year . '-' . $month){
                $reject_count++;
            }
        }


        $this->set('total',$total_count);
        $this->set('approve',$approve_count);
        $this->set('request',$request_count);
        $this->set('reject',$reject_count);
        $this->set('amount',$am_count);
        $this->set('month', $month);
        $this->set('year', $year);
    }


    public function isAuthorized($user){
        if ($this->request->getParam('action') === 'requests' || $this->request->getParam('action') === 'index' || $this->request->getParam('action') === 'view' || $this->request->getParam('action') === 'submit' || $this->request->getParam('action') === 'generate' || $this->request->getParam('action') === 'edit' || $this->request->getParam('action') === 'delete' || $this->request->getParam('action') === 'requestsView' || $this->request->getParam('action') === 'report' || $this->request->getParam('action') === 'approvalStatus' || $this->request->getParam('action') === 'statReport') {
            return true;
        }
        if(isset($user['role']) && $user['role'] === 'requester'){
            if(in_array($this->request->action, ['requests','requestsView','view','generate','submit','report','approvalStatus','statReport'])){
                return true;
            }
        }
        if(isset($user['role']) && $user['role'] === 'verifier'){
            if(in_array($this->request->action, ['requests','requestsView','edit','delete','report','approvalStatus','statReport'])){
                return true;
            }
        }
        if(isset($user['role']) && $user['role'] === 'approver-1'){
            if(in_array($this->request->action, ['requests','requestsView','edit','delete','report','approvalStatus','statReport'])){
                return true;
            }
        }
        if(isset($user['role']) && $user['role'] === 'approver-2'){
            if(in_array($this->request->action, ['requests','requestsView','edit','delete','report','approvalStatus','statReport'])){
                return true;
            }
        }
        if(isset($user['role']) && $user['role'] === 'approver-3'){
            if(in_array($this->request->action, ['requests','requestsView','edit','delete','report','approvalStatus','statReport'])){
                return true;
            }
        }
        return parent::isAuthorized($user);
    }
}
