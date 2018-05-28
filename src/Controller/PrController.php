<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Po Controller
 *
 * @property \App\Model\Table\PoTable $Pr
 *
 * @method \App\Model\Entity\Pr[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PrController extends AppController
{

    public function initialize(){
        parent::initialize();
        $this->viewBuilder()->setLayout('mainframe');
        set_time_limit(0);
    }

    /**
     * AutoRequests method
     *
     * @return \Cake\Http\Response|void
     */

    public function autoOneRequests()
    {
        $dataFromSales = '';
        $this->loadModel('Users');
        $urlToSales = 'http://salesmodule.acumenits.com/api/all-data';
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
        }
        $this->set('pr', $dataFromSales);
    }

    public function autoRequests()
    {
        $pr = null;
        if($this->Auth->user('role') == 'requester'){
            $pr = $this->Pr->find('all')
                ->Where(['status'=>'requested'])
                ->Where(['section' => 'auto-1'])
                ->orWhere(['status' => 'rejected']);
        }
        if($this->Auth->user('role') == 'verifier'){
            $pr = $this->Pr->find('all')
                ->Where(['status'=>'requested'])
                ->Where(['section' => 'auto-1']);
        }
        if($this->Auth->user('role') == 'approver-1'){
            $pr = $this->Pr->find('all')
                ->Where(['status' => 'verified'])
                ->Where(['section' => 'auto-1']);
        }
        $this->loadModel('Users');
        foreach ($pr as $p){
            $created_by = $this->Users->get($p->created_by);
            if($p->verified_by != null ){
                $verified_by = $this->Users->get($p->verified_by);
                $p->verified_by = $verified_by;
            }
            if($p->approved_by != null ){
                $approved_by = $this->Users->get($p->approved_by);
                $p->approved_by = $approved_by;
            }
            $urlToSales = 'http://salesmodule.acumenits.com/api/so-data?so='.rawurlencode($p->so_no);

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
                    $p->date = $s->date;
                    $p->customer = $s->cus->name;
                    foreach ($s->soi as $smv){
                        $p->model = $smv->model;
                        $p->version = $smv->version;
                        $p->quantity = $smv->quantity;
                    }
                }
            }
            $p->created_by = $created_by;
        }
        $this->set('pr', $pr);
    }

    /**
     * AutoTwoRequests method
     *
     * @return \Cake\Http\Response|void
     */
    public function autoTwoRequests()
    {
        $pr = null;
        if($this->Auth->user('role') == 'requester'){
            $pr = $this->Pr->find('all')
                ->Where(['status'=>'requested'])
                ->where(['section' => 'auto-2'])
                ->orWhere(['status' => 'rejected']);
        }
        if($this->Auth->user('role') == 'verifier'){
            $pr = $this->Pr->find('all')
                ->Where(['status'=>'requested'])
                ->where(['section' => 'auto-2']);
        }
        if($this->Auth->user('role') == 'approver-1'){
            $pr = $this->Pr->find('all')
                ->where(['status' => 'verified'])
                ->where(['section' => 'auto-2']);
        }
        $this->loadModel('Users');
        foreach ($pr as $p){
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
        $this->set('pr', $pr);
    }

    /**
     * ManualRequests method
     *
     * @return \Cake\Http\Response|void
     */
    public function manualRequests()
    {
        $pr = null;
        if($this->Auth->user('role') == 'requester'){
            $pr = $this->Pr->find('all')
                ->Where(['status'=>'requested'])
                ->where(['section' => 'manual'])
                ->orWhere(['status' => 'rejected']);
        }
        if($this->Auth->user('role') == 'verifier'){
            $pr = $this->Pr->find('all')
                ->Where(['status'=>'requested'])
                ->where(['section' => 'manual']);
        }
        if($this->Auth->user('role') == 'approver-1'){
            $pr = $this->Pr->find('all')
                ->where(['status' => 'verified'])
                ->where(['section' => 'manual']);
        }
        $this->loadModel('Users');
        foreach ($pr as $p){
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
        $this->set('pr', $pr);
    }

    /**
     * ViewManual method
     *
     * @param string|null $id Pr id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function viewManual($id = null){
        $this->loadModel('Supplier');
        $this->loadModel('SupplierItems');
        $this->loadModel('PrItems');
        $this->loadModel('Users');
        $pr = $this->Pr->get($id, [
            'contain' => []
        ]);
        $created_by = $this->Users->get($pr->created_by);
        if($pr->verified_by != null ){
            $verified_by = $this->Users->get($pr->verified_by);
            $pr->verified_by = $verified_by;
        }
        if($pr->approved_by != null ){
            $approved_by = $this->Users->get($pr->approved_by);
            $pr->approved_by = $approved_by;
        }
        $pr->created_by = $created_by;

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
            }
        }

        $items = $this->PrItems->find('all')
            ->where(['pr_id' => $id]);
        foreach($items as $i){
            $supplier = $supplier_item = '';
            if($i->supplier_id !== null){
                $supplier = $this->Supplier->get($i->supplier_id, [
                    'contain' => []
                ]);
            }
            $i->supplier_name = $supplier;

            if($i->supplier_item_id !== null){
                $supplier_item = $this->SupplierItems->get($i->supplier_item_id, [
                    'contain' => []
                ]);
            }
            $i->supplier_item = $supplier_item;

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
        $pr->items = $items;

        $this->set('pic',$this->Auth->user('id'));
        $this->set('pr', $pr);
    }

    /**
     * ViewAuto method
     *
     * @param string|null $id Pr id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function viewAuto($id = null)
    {
        $this->loadModel('PrItems');
        $this->loadModel('Supplier');
        $this->loadModel('SupplierItems');
        $this->loadModel('Users');
        $pr = $this->Pr->get($id, [
            'contain' => []
        ]);
            $created_by = $this->Users->get($pr->created_by);
            if($pr->verified_by != null ){
                $verified_by = $this->Users->get($pr->verified_by);
                $pr->verified_by = $verified_by;
            }
            if($pr->approved_by != null ){
                $approved_by = $this->Users->get($pr->approved_by);
                $pr->approved_by = $approved_by;
            }
            $pr->created_by = $created_by;

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

        $items = $this->PrItems->find('all')
            ->where(['pr_id' => $id]);
        foreach($items as $i){
            $supplier = $supplier_item = '';
            if($i->supplier_id !== null){
                $supplier = $this->Supplier->get($i->supplier_id, [
                    'contain' => []
                ]);
            }
            $i->supplier_name = $supplier;

            if($i->supplier_item_id !== null){
                $supplier_item = $this->SupplierItems->get($i->supplier_item_id, [
                    'contain' => []
                ]);
            }
            $i->supplier_item = $supplier_item;

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
        $pr->items = $items;
        $this->set('pic',$this->Auth->user('id'));
        $this->set('pr', $pr);
    }

    /**
     * ViewTwoAuto method
     *
     * @param string|null $id Pr id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function viewTwoAuto($id = null)
    {
        $this->loadModel('PrItems');
        $this->loadModel('Supplier');
        $this->loadModel('SupplierItems');
        $this->loadModel('Users');
        $pr = $this->Pr->get($id, [
            'contain' => []
        ]);
        $created_by = $this->Users->get($pr->created_by);
        if($pr->verified_by != null ){
            $verified_by = $this->Users->get($pr->verified_by);
            $pr->verified_by = $verified_by;
        }
        if($pr->approved_by != null ){
            $approved_by = $this->Users->get($pr->approved_by);
            $pr->approved_by = $approved_by;
        }
        $pr->created_by = $created_by;

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

        $items = $this->PrItems->find('all')
            ->where(['pr_id' => $id]);
        foreach($items as $i){
            $supplier = $supplier_item = '';
            if($i->supplier_id !== null){
                $supplier = $this->Supplier->get($i->supplier_id, [
                    'contain' => []
                ]);
            }
            $i->supplier_name = $supplier;

            if($i->supplier_item_id !== null){
                $supplier_item = $this->SupplierItems->get($i->supplier_item_id, [
                    'contain' => []
                ]);
            }
            $i->supplier_item = $supplier_item;

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
        $pr->items = $items;
        $this->set('pic',$this->Auth->user('id'));
        $this->set('pr', $pr);
    }

    public function addAuto($id = null)
    {
        $data = new \stdClass();
        $this->loadModel('Supplier');
        $this->loadModel('SupplierItems');
        $urlToSales = 'http://salesmodule.acumenits.com/api/so-id?so='.$id;

        $optionsForSales = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET'
            ]
        ];
        $contextForSales  = stream_context_create($optionsForSales);
        $resultFromSales = file_get_contents($urlToSales, false, $contextForSales);
        if ($resultFromSales === FALSE) {
            echo 'ERROR!!';
        }
        $dataFromSales = json_decode($resultFromSales);

        foreach ($dataFromSales as $d){
            $data->so = $d->salesorder_no;
            $data->date = $d->date;
            $data->del_date = $d->delivery_date;
            foreach($d->soi as $item){
                $urlToEng = 'http://engmodule.acumenits.com/api/bom-parts';
                $sendToEng = [
                    'model' => $item->model,
                    'version' => $item->version
                ];
                $optionsForEng = [
                    'http' => [
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method'  => 'POST',
                        'content' => http_build_query($sendToEng)
                    ]
                ];
                $contextForEng  = stream_context_create($optionsForEng);
                $resultFromEng = file_get_contents($urlToEng, false, $contextForEng);
                if ($resultFromEng !== FALSE) {
                    $dataFromEng = json_decode($resultFromEng);
                    $item->eng_data = $dataFromEng;
                    foreach($dataFromEng as $eng){
                        $supplierId1 = $supplierId2 = $supplierId3 = '';
                        $supplier1 = $supplier2 = $supplier3 = '';
                        $price1 = $price2 = $price3 = 0;
                        $items = $this->SupplierItems->find('all', [
                            'order' => 'SupplierItems.unit_price'
                        ])
                            ->where(['part_no' => $eng->partNo])
                            ->where(['part_name' => $eng->partName]);
                        $count = 0;
                        foreach($items as $ii){
                            $supplier = $this->Supplier->get($ii->supplier_id, [
                                'contain' => []
                            ]);
                            $ii->supplier = $supplier;
                            $count++;
                            if($count < 4){
                                ${'supplierId'.$count} = $supplier->id;
                                ${'supplier'.$count} = $supplier->name;
                                ${'price'.$count} = $ii->unit_price;
                                ${'supItemId'.$count} = $ii->id;
                            }
                            $eng->supplier1 = $supplier1;
                            $eng->supplier2 = $supplier2;
                            $eng->supplier3 = $supplier3;
                            $eng->supplierId1 = $supplierId1;
                            $eng->supplierId2 = $supplierId2;
                            $eng->supplierId3 = $supplierId3;
                            $eng->price1 = $price1;
                            $eng->price2 = $price2;
                            $eng->price3 = $price3;
                            $eng->supplier_item1 = $supplierId1;
                            $eng->supplier_item2 = $supplierId2;
                            $eng->supplier_item3 = $supplierId3;
                            $eng->uom = $ii->uom;
                        }
                        $stockAvailable = 0;
                        $urlToStore = 'http://storemodule.acumenits.com/in-stock-code/stock-available';
                        $sendToStore = [
                            'part_no' => $eng->partNo,
                            'part_name' => $eng->partName
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
                            $eng->stockAvailable = abs($dataFromStore->stock_available);
                        }

                    }
                }
            }
            foreach ($d->soi as $s){
                $data->model = $s->model;
                $data->version = $s->version;
            }
            $data->customer = $d->cus->name;
            }
        $last_pr = $this->Pr->find('all',['fields'=>'id'])->last();

        $this->set('so',$dataFromSales);
        $this->set('so_no',$id);
        $this->set('data',$data);
        $this->set('pr_id', (isset($last_pr->id) ? ($last_pr->id + 1) : 1));
    }

    public function generateAuto()
    {
        $this->loadModel('Supplier');
        $last_pr = $this->Pr->find('all')->last();
        $allData = [];
        $showData = null;
        if ($this->request->is('post')) {
            $allData['so_no'] = $this->request->getData('so_no');
            $allData['date'] = $this->request->getData('date');
            $allData['del_date'] = $this->request->getData('delivery_date');
            $allData['desc'] = $this->request->getData('description');
            $allData['cus'] = $this->request->getData('customer');
            $allData['pr_id'] = $this->request->getData('pr_id');
            $allData['counter'] = $this->request->getData('counter');
                for ($i = 1; $i <= $this->request->getData('counter'); $i++) {
                    if ($this->request->getData('checkbox' . $i) != '') {
                        $allData['checked'][] = $i;
                        $allData['parts'][$i]['bom_part_id'] = $this->request->getData('bom_part_id' . $i);
                        $allData['parts'][$i]['part_no'] = $this->request->getData('part_no' . $i);
                        $allData['parts'][$i]['part_name'] = $this->request->getData('part_name' . $i);
                        if ($this->request->getData('supplier'.$i) == 2) {
                            if ($this->request->getData('supplier-2-'.$i) != null) {
                                $allData['parts'][$i]['supplier_det'] = $this->Supplier->get($this->request->getData('supplier-2-'.$i), [
                                    'contain' => []
                                ]);
                            }
                            $allData['parts'][$i]['supplier_id'] = $this->request->getData('supplier-2-'.$i);
                            $allData['parts'][$i]['price'] = $this->request->getData('price-2-' . $i);
                            $allData['parts'][$i]['sup_item_id'] = $this->request->getData('sup-item-2-'.$i);
                        } elseif ($this->request->getData('supplier'.$i) == 3) {
                            if ($this->request->getData('supplier-3-'.$i) != null) {
                                $allData['parts'][$i]['supplier_det'] = $this->Supplier->get($this->request->getData('supplier-3-' . $i), [
                                    'contain' => []
                                ]);
                            }
                            $allData['parts'][$i]['supplier_id'] = $this->request->getData('supplier-3-' . $i);
                            $allData['parts'][$i]['price'] = $this->request->getData('price-3-' . $i);
                            $allData['parts'][$i]['sup_item_id'] = $this->request->getData('sup-item-3-' . $i);
                        } else {
                            if ($this->request->getData('supplier-1-'.$i) != null) {
                                $allData['parts'][$i]['supplier_det'] = $this->Supplier->get($this->request->getData('supplier-1-'.$i), [
                                    'contain' => []
                                ]);
                            }
                            $allData['parts'][$i]['supplier_id'] = $this->request->getData('supplier-1-' . $i);
                            $allData['parts'][$i]['price'] = $this->request->getData('price-1-' . $i);
                            $allData['parts'][$i]['sup_item_id'] = $this->request->getData('sup-item-1-' . $i);
                        }
                        $allData['parts'][$i]['uom'] = $this->request->getData('uom' . $i);
                        $allData['parts'][$i]['category'] = $this->request->getData('category' . $i);
                        $allData['parts'][$i]['req_quantity'] = $this->request->getData('reqQuantity' . $i);
                        $allData['parts'][$i]['stock'] = $this->request->getData('stockAvailable' . $i);
                        $allData['parts'][$i]['order_qty'] = $this->request->getData('order_qty' . $i);
                        $allData['parts'][$i]['supplier'] = $this->request->getData('supplier' . $i);
                        $allData['parts'][$i]['sub_total'] = $this->request->getData('sub_total' . $i);
                        $allData['parts'][$i]['gst'] = $this->request->getData('gst' . $i);
                        $allData['parts'][$i]['total'] = $this->request->getData('total' . $i);
                    }
                }
            $showData = (object)$allData;
        }
        $this->set('allData', $showData);
        $this->set('last_pr', (isset($last_pr->id) ? ($last_pr->id + 1) : 1));
    }

    /**
     * SubmitAuto method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function submitAuto(){
        if($this->request->is('post')){
            $this->loadModel('PrItems');
            $pr = $this->Pr->newEntity();
            $pr->date = $this->request->getData('date');
            $pr->so_no = $this->request->getData('so_no');
            $pr->created_by = $this->request->getData('created_by');
            $pr->purchase_type = null;
            $pr->status = 'requested';
            $pr->section = 'auto-1';
            $pr_itm = array();
            $count = 0;
            $prChild = TableRegistry::get('PrItems');
            $allData['counter'] = $this->request->getData('counter');
            if($this->Pr->save($pr)){
                $pr_id = $this->Pr->find('all',['fields'=>'id'])->last();
                if($this->request->getData('total') != ''){
                    for ($i = 1 ;$i <= $this->request->getData('total');$i++){
                        if($this->request->getData('selected'.$i) != ''){
                            $pr_itm[$count]['pr_id'] = $pr_id['id'];
                            $pr_itm[$count]['bom_part_id'] = $this->request->getData('bom_part_id'.$i);
                            $pr_itm[$count]['order_qty'] = $this->request->getData('order_qty'.$i);
                            $pr_itm[$count]['supplier_id'] = $this->request->getData('supplier'.$i);
                            $pr_itm[$count]['supplier_item_id'] = $this->request->getData('supp-item-id'.$i);
                            $pr_itm[$count]['sub_total'] = $this->request->getData('sub_total'.$i);
                            $pr_itm[$count]['gst'] = $this->request->getData('gst'.$i);
                            $pr_itm[$count]['total'] = $this->request->getData('total'.$i);
                            $count++;
                        }
                    }
                    $prs = $prChild->newEntities($pr_itm);
                    foreach ($prs as $p){
                        $prChild->save($p);
                    }
                }
                $this->Flash->success(__('The pr has been saved.'));

                return $this->redirect(['action' => 'autoRequests']);
            }
            $this->Flash->error(__('The pr could not be saved. Please, try again.'));
        }
    }

    /**
     * AddTwoAuto method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function addTwoAuto(){
        $this->loadModel('Supplier');
        $this->loadModel('SupplierItems');
        $urlToSales = 'http://salesmodule.acumenits.com/api/all-data';

        $optionsForSales = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET'
            ]
        ];
        $contextForSales  = stream_context_create($optionsForSales);
        $resultFromSales = file_get_contents($urlToSales, false, $contextForSales);
        if ($resultFromSales === FALSE) {
            echo 'ERROR!!';
        }
        $dataFromSales = json_decode($resultFromSales);

        $so_no = $customer = $model = $version = null;
        foreach ($dataFromSales as $d){
            $parts = '';
            foreach($d->soi as $item){
                $urlToEng = 'http://engmodule.acumenits.com/api/bom-parts';
                $sendToEng = [
                    'model' => $item->model,
                    'version' => $item->version
                ];
                $optionsForEng = [
                    'http' => [
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method'  => 'POST',
                        'content' => http_build_query($sendToEng)
                    ]
                ];
                $contextForEng  = stream_context_create($optionsForEng);
                $resultFromEng = file_get_contents($urlToEng, false, $contextForEng);
                if ($resultFromEng !== FALSE) {
                    $dataFromEng = json_decode($resultFromEng);
                    $item->eng_data = $dataFromEng;
                    foreach($dataFromEng as $eng){
                        $supplierId1 = $supplierId2 = $supplierId3 = '';
                        $uom = $supplier1 = $supplier2 = $supplier3 = '';
                        $price1 = $price2 = $price3 = 0;
                        $supItemId1 = $supItemId2 = $supItemId3 = '';
                        $items = $this->SupplierItems->find('all', [
                            'order' => 'SupplierItems.unit_price'
                        ])
                            ->where(['part_no' => $eng->partNo])
                            ->where(['part_name' => $eng->partName]);
                        $count = 0;
                        foreach($items as $ii){
                            $supplier = $this->Supplier->get($ii->supplier_id, [
                                'contain' => []
                            ]);
                            $ii->supplier = $supplier;
                            $count++;
                            if($count < 4){
                                ${'supplierId'.$count} = $supplier->id;
                                ${'supplier'.$count} = $supplier->name;
                                ${'price'.$count} = $ii->unit_price;
                                ${'supItemId'.$count} = $ii->id;
                            }
                            $uom = $ii->uom;
                        }
                        $stockAvailable = 0;
                        $urlToStore = 'http://storemodule.acumenits.com/in-stock-code/stock-available';
                        $sendToStore = [
                            'part_no' => $eng->partNo,
                            'part_name' => $eng->partName
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
                        $parts .= '{partNo:"'.$eng->partNo.
                            '",bomId:"'.$eng->id.
                            '",partName:"'.$eng->partName.
                            '",reqQuantity:"'.$eng->quality.
                            '",category:"'.$eng->category.
                            '",stockAvailable:"'.$stockAvailable.
                            '",supplier1id:"'.$supplierId1.
                            '",supplier2id:"'.$supplierId2.
                            '",supplier3id:"'.$supplierId3.
                            '",supplier1:"'.$supplier1.
                            '",supplier2:"'.$supplier2.
                            '",supplier3:"'.$supplier3.
                            '",supItemId1:"'.$supItemId1.
                            '",supItemId2:"'.$supItemId2.
                            '",supItemId3:"'.$supItemId3.
                            '",price1:"'.$price1.
                            '",price2:"'.$price2.
                            '",price3:"'.$price3.
                            '",uom:"'.$uom.'"},';
                    }
                }
            }
            $parts = rtrim($parts, ',');
            foreach ($d->soi as $s){
                $model = $s->model;
                $version = $s->version;
            }
            foreach($d->cus as $cus){
                $customer = $cus->name;
            }
            $so_no .= '{label:"'.$d->salesorder_no.'",del_date:"'.date('Y-m-d', strtotime($d->delivery_date)).'",cus_name:"'.$customer.'",model:"'.$model.'",version:"'.$version.'",parts:['.$parts.']},';
        }
        $so_no = rtrim($so_no, ',');
        $last_pr = $this->Pr->find('all',['fields'=>'id'])->last();

        $this->set('so_no',$so_no);
        $this->set('pr_id', (isset($last_pr->id) ? ($last_pr->id + 1) : 1));

        if($this->request->is('post')){
            $this->loadModel('PrItems');
            $pr = $this->Pr->newEntity();
            $pr->date = $this->request->getData('date');
            $pr->so_no = $this->request->getData('so_no');
            $pr->created_by = $this->request->getData('created_by');
            $pr->purchase_type = null;
            $pr->status = 'requested';
            $pr->section = 'auto-2';
            $pr_itm = array();
            $prChild = TableRegistry::get('PrItems');
            if($this->Pr->save($pr)){
            $pr_id = $this->Pr->find('all',['fields'=>'id'])->last();
                for ($i = 1 ;$i <= $this->request->getData('counter'); $i++){
                    $pr_itm[$i]['pr_id'] = $pr_id['id'];
                    $pr_itm[$i]['bom_part_id'] = $this->request->getData('bom_part_id'.$i);
                    $pr_itm[$i]['order_qty'] = $this->request->getData('order_qty'.$i);
                    $pr_itm[$i]['supplier_id'] = $this->request->getData('supplier'.$i);
                    $pr_itm[$i]['supplier_item_id'] = $this->request->getData('supp-item-id'.$i);
                    $pr_itm[$i]['sub_total'] = $this->request->getData('sub_total'.$i);
                    $pr_itm[$i]['gst'] = $this->request->getData('gst'.$i);
                    $pr_itm[$i]['total'] = $this->request->getData('total'.$i);
                }
                $prs = $prChild->newEntities($pr_itm);
                    foreach ($prs as $p){
                        $prChild->save($p);
                    }
                    $this->Flash->success(__('The pr has been saved.'));

                return $this->redirect(['action' => 'autoTwoRequests']);
            }
            $this->Flash->error(__('The pr could not be saved. Please, try again.'));
        }

        $this->set('so_no',$so_no);
        $this->set('pr_id', (isset($last_pr->id) ? ($last_pr->id + 1) : 1));
    }

    /**
     * AddManual method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function addManual()
    {
        $this->loadModel('Supplier');
        $this->loadModel('SupplierItems');
        $urlToSales = 'http://salesmodule.acumenits.com/api/all-data';

        $optionsForSales = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET'
            ]
        ];
        $contextForSales  = stream_context_create($optionsForSales);
        $resultFromSales = file_get_contents($urlToSales, false, $contextForSales);
        if ($resultFromSales === FALSE) {
            echo 'ERROR!!';
        }
        $dataFromSales = json_decode($resultFromSales);
        $so_no = null;
        foreach($dataFromSales as $pm){
            $parts = '';
            foreach($pm->soi as $item){
                $urlToEng = 'http://engmodule.acumenits.com/api/bom-parts';
                $sendToEng = [
                    'model' => $item->model,
                    'version' => $item->version
                ];


                $optionsForEng = [
                    'http' => [
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method'  => 'POST',
                        'content' => http_build_query($sendToEng)
                    ]
                ];
                $contextForEng  = stream_context_create($optionsForEng);
                $resultFromEng = file_get_contents($urlToEng, false, $contextForEng);
                if ($resultFromEng !== FALSE) {
                    $dataFromEng = json_decode($resultFromEng);
                    $item->eng_data = $dataFromEng;
                    foreach($dataFromEng as $eng){
                        $supplierId1 = $supplierId2 = $supplierId3 = '';
                        $uom = $supplier1 = $supplier2 = $supplier3 = '';
                        $price1 = $price2 = $price3 = 0;
                        $supItemId1 = $supItemId2 = $supItemId3 = '';
                        $items = $this->SupplierItems->find('all', [
                            'order' => 'SupplierItems.unit_price'
                        ])
                            ->where(['part_no' => $eng->partNo])
                            ->where(['part_name' => $eng->partName]);
                        $count = 0;
                        foreach($items as $ii){
                            $supplier = $this->Supplier->get($ii->supplier_id, [
                                'contain' => []
                            ]);
                            $ii->supplier = $supplier;
                            $count++;
                            if($count < 4){
                                ${'supplierId'.$count} = $supplier->id;
                                ${'supplier'.$count} = $supplier->name;
                                ${'price'.$count} = $ii->unit_price;
                                ${'supItemId'.$count} = $ii->id;
                            }
                            $uom = $ii->uom;
                        }
                        $stockAvailable = 0;
                        $urlToStore = 'http://storemodule.acumenits.com/in-stock-code/stock-available';
                        $sendToStore = [
                            'part_no' => $eng->partNo,
                            'part_name' => $eng->partName
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
                        if($resultFromStore !== FALSE){
                            $dataFromStore = json_decode($resultFromStore);
                            $stockAvailable = abs($dataFromStore->stock_available);
                        }
                        $parts .= '{partNo:"'.$eng->partNo.
                        '",bomId:"'.$eng->id.
                        '",partName:"'.$eng->partName.
                        '",reqQuantity:"'.$eng->quality.
                        '",category:"'.$eng->category.
                        '",stockAvailable:"'.$stockAvailable.
                        '",supplier1id:"'.$supplierId1.
                        '",supplier2id:"'.$supplierId2.
                        '",supplier3id:"'.$supplierId3.
                        '",supplier1:"'.$supplier1.
                        '",supplier2:"'.$supplier2.
                        '",supplier3:"'.$supplier3.
                        '",supItemId1:"'.$supItemId1.
                        '",supItemId2:"'.$supItemId2.
                        '",supItemId3:"'.$supItemId3.
                        '",price1:"'.$price1.
                        '",price2:"'.$price2.
                        '",price3:"'.$price3.
                        '",uom:"'.$uom.'"},';
                    }
                }
            }
            $parts = rtrim($parts, ',');
            $customer = '';
            foreach($pm->cus as $cus){
                $customer = $cus->name;
            }
            $so_no .= '{label:"'.$pm->salesorder_no.'",del_date:"'.date('Y-m-d', strtotime($pm->delivery_date)).'",cus_name:"'.$customer.'",parts:['.$parts.']},';
        }
        $so_no = rtrim($so_no, ',');

        $part_nos = $part_names = '';
        $urlToEngBom = 'http://engmodule.acumenits.com/api/all-bom-parts';


        $optionsForEngBom = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET'
            ]
        ];
        $contextForEngBom  = stream_context_create($optionsForEngBom);
        $resultFromEngBom = file_get_contents($urlToEngBom, false, $contextForEngBom);
        if ($resultFromEngBom !== FALSE) {
            $dataFromEngBom = json_decode($resultFromEngBom);
            foreach($dataFromEngBom as $engBom){
                $bomSupplierId1 = $bomSupplierId2 = $bomSupplierId3 = '';
                $bomUom = $bomSupplier1 = $bomSupplier2 = $bomSupplier3 = '';
                $bomPrice1 = $bomPrice2 = $bomPrice3 = 0;
                $bomSupItemId1 = $bomSupItemId2 = $bomSupItemId3 = '';
                $bomItems = $this->SupplierItems->find('all', [
                    'order' => 'SupplierItems.unit_price'
                ])
                    ->where(['part_no' => $engBom->partNo])
                    ->where(['part_name' => $engBom->partName]);
                $countBom = 0;
                foreach($bomItems as $bi){
                    $bomSupplier = $this->Supplier->get($bi->supplier_id, [
                        'contain' => []
                    ]);
                    $countBom++;
                    if($countBom < 4){
                        ${'bomSupplierId'.$countBom} = $bomSupplier->id;
                        ${'bomSupplier'.$countBom} = $bomSupplier->name;
                        ${'bomPrice'.$countBom} = $bi->unit_price;
                        ${'bomSupItemId'.$countBom} = $bi->id;
                    }
                    $bomUom = $bi->uom;
                }
                $bomStockAvailable = 0;
                $urlToStoreBom = 'http://storemodule.acumenits.com/in-stock-code/stock-available';
                $sendToStoreBom = [
                    'part_no' => $engBom->partNo,
                    'part_name' => $engBom->partName
                ];


                $optionsForStoreBom = [
                    'http' => [
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method'  => 'POST',
                        'content' => http_build_query($sendToStoreBom)
                    ]
                ];
                $contextForStoreBom = stream_context_create($optionsForStoreBom);
                $resultFromStoreBom = file_get_contents($urlToStoreBom, false, $contextForStoreBom);
                if($resultFromStoreBom !== FALSE){
                    $dataFromStoreBom = json_decode($resultFromStoreBom);
                    $bomStockAvailable = abs($dataFromStoreBom->stock_available);
                }
                $part_nos .= '{label:"'.$engBom->partNo.
                    '",bomId:"'.$engBom->id.
                    '",partName:"'.$engBom->partName.
                    '",reqQuantity:"'.$engBom->quality.
                    '",category:"'.$engBom->category.
                    '",stockAvailable:"'.$bomStockAvailable.
                    '",supplier1id:"'.$bomSupplierId1.
                    '",supplier2id:"'.$bomSupplierId2.
                    '",supplier3id:"'.$bomSupplierId3.
                    '",supplier1:"'.$bomSupplier1.
                    '",supplier2:"'.$bomSupplier2.
                    '",supplier3:"'.$bomSupplier3.
                    '",supItemId1:"'.$bomSupItemId1.
                    '",supItemId2:"'.$bomSupItemId2.
                    '",supItemId3:"'.$bomSupItemId3.
                    '",price1:"'.$bomPrice1.
                    '",price2:"'.$bomPrice2.
                    '",price3:"'.$bomPrice3.
                    '",uom:"'.$bomUom.'"},';
                $part_names .= '{label:"'.$engBom->partName.
                    '",bomId:"'.$engBom->id.
                    '",partNo:"'.$engBom->partNo.
                    '",reqQuantity:"'.$engBom->quality.
                    '",category:"'.$engBom->category.
                    '",stockAvailable:"'.$bomStockAvailable.
                    '",supplier1id:"'.$bomSupplierId1.
                    '",supplier2id:"'.$bomSupplierId2.
                    '",supplier3id:"'.$bomSupplierId3.
                    '",supplier1:"'.$bomSupplier1.
                    '",supplier2:"'.$bomSupplier2.
                    '",supplier3:"'.$bomSupplier3.
                    '",supItemId1:"'.$bomSupItemId1.
                    '",supItemId2:"'.$bomSupItemId2.
                    '",supItemId3:"'.$bomSupItemId3.
                    '",price1:"'.$bomPrice1.
                    '",price2:"'.$bomPrice2.
                    '",price3:"'.$bomPrice3.
                    '",uom:"'.$bomUom.'"},';
            }
        }
        $last_pr = $this->Pr->find('all')->last();
        $part_nos = rtrim($part_nos, ',');
        $part_names = rtrim($part_names, ',');
        $this->set(compact('pr'));
        $this->set('last_pr', (isset($last_pr->id) ? ($last_pr->id + 1) : 1));
        $this->set('so_no', $so_no);
        $this->set('part_nos', $part_nos);
        $this->set('part_names', $part_names);
    }

    /**
     * GenerateManual method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function generateManual(){
        $this->loadModel('Supplier');
        $last_pr = $this->Pr->find('all')->last();
        $allData = [];
        $showData = null;
        if($this->request->is('post')){
            $allData['date'] = $this->request->getData('date');
            $allData['so_no'] = $this->request->getData('so_no');
            $allData['del_date'] = $this->request->getData('del-date');
            $allData['cus_name'] = $this->request->getData('cus-name');
            $allData['purchase_type'] = $this->request->getData('purchase_type');
            $total_items = $this->request->getData('total-items');
            for($i = 1; $i <= $total_items; $i++){
                $allData['parts'][$i]['bom_id'] = $this->request->getData('bom-id-'.$i);
                $allData['parts'][$i]['part_no'] = $this->request->getData('part-no-'.$i);
                $allData['parts'][$i]['part_name'] = $this->request->getData('part-name-'.$i);
                if($this->request->getData('supplier'.$i) == 2){
                    if($this->request->getData('supplier-2-'.$i) != null){
                        $allData['parts'][$i]['supplier_det'] = $this->Supplier->get($this->request->getData('supplier-2-'.$i), [
                            'contain' => []
                        ]);
                    }
                    $allData['parts'][$i]['supplier_id'] = $this->request->getData('supplier-2-'.$i);
                    $allData['parts'][$i]['price'] = $this->request->getData('price-2-'.$i);
                    $allData['parts'][$i]['sup_item_id'] = $this->request->getData('sup-item-2-'.$i);
                }elseif($this->request->getData('supplier'.$i) == 3){
                    if($this->request->getData('supplier-3-'.$i) != ''){
                        $allData['parts'][$i]['supplier_det'] = $this->Supplier->get($this->request->getData('supplier-3-'.$i), [
                            'contain' => []
                        ]);
                    }
                    $allData['parts'][$i]['supplier_id'] = $this->request->getData('supplier-3-'.$i);
                    $allData['parts'][$i]['price'] = $this->request->getData('price-3-'.$i);
                    $allData['parts'][$i]['sup_item_id'] = $this->request->getData('sup-item-3-'.$i);
                }else{
                    if($this->request->getData('supplier-1-'.$i) != null){
                        $allData['parts'][$i]['supplier_det'] = $this->Supplier->get($this->request->getData('supplier-1-'.$i), [
                            'contain' => []
                        ]);
                    }
                    $allData['parts'][$i]['supplier_id'] = $this->request->getData('supplier-1-'.$i);
                    $allData['parts'][$i]['price'] = $this->request->getData('price-1-'.$i);
                    $allData['parts'][$i]['sup_item_id'] = $this->request->getData('sup-item-1-'.$i);
                }
                $allData['parts'][$i]['uom'] = $this->request->getData('uom-'.$i);
                $allData['parts'][$i]['category'] = $this->request->getData('category-'.$i);
                $allData['parts'][$i]['req_quantity'] = $this->request->getData('req-quantity-'.$i);
                $allData['parts'][$i]['stock'] = $this->request->getData('stock-'.$i);
                $allData['parts'][$i]['qty_order'] = $this->request->getData('qty_order'.$i);
                $allData['parts'][$i]['subtotal'] = $this->request->getData('subtotal'.$i);
                $allData['parts'][$i]['gst'] = $this->request->getData('gst'.$i);
                $allData['parts'][$i]['total'] = $this->request->getData('total'.$i);
            }
            $showData = (object) $allData;
        }
        $this->set('allData', $showData);
        $this->set('last_pr', (isset($last_pr->id) ? ($last_pr->id + 1) : 1));
    }

    /**
     * SubmitManual method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function submitManual(){
        if($this->request->is('post')){
            echo '<pre>';
            print_r($this->request->getData());
            echo '</pre>';
            die();
            $pr = $this->Pr->newEntity();
            $pr->date = $this->request->getData('date');
            $pr->so_no = $this->request->getData('so_no');
            $pr->purchase_type = $this->request->getData('purchase_type');
            $pr->created_by = $this->request->getData('created_by');
            $pr->status = 'requested';
            $pr->section = 'manual';
            $pr_itm = array();
            $prChild = TableRegistry::get('PrItems');
            if($this->Pr->save($pr)){
                $pr_id = $this->Pr->find('all',['fields'=>'id'])->last();
                if($this->request->getData('count') != null){
                    for ($i=1;$i <= $this->request->getData('count');$i++){
                        $pr_itm[$i]['pr_id'] = $pr_id['id'];
                        $pr_itm[$i]['bom_part_id'] = $this->request->getData('bom-id'.$i);
                        $pr_itm[$i]['req_qty'] = $this->request->getData('req-qty'.$i);
                        $pr_itm[$i]['order_qty'] = $this->request->getData('order-qty'.$i);
                        $pr_itm[$i]['supplier_id'] = $this->request->getData('supplier' . $i);
                        $pr_itm[$i]['sub_total'] = $this->request->getData('subtotal' . $i);
                        $pr_itm[$i]['gst'] = $this->request->getData('gst' . $i);
                        $pr_itm[$i]['total'] = $this->request->getData('total' . $i);
                        $pr_itm[$i]['supplier_item_id'] = $this->request->getData('sup-item-id' . $i);
                    }
                    $prs = $prChild->newEntities($pr_itm);
                    foreach ($prs as $p){
                        $prChild->save($p);
                    }
                }
                $this->Flash->success(__('The pr has been saved.'));

                return $this->redirect(['action' => 'manualRequests']);
            }
            $this->Flash->error(__('The pr could not be saved. Please, try again.'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Pr id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pr = $this->Pr->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pr = $this->Pr->patchEntity($pr, $this->request->getData());
            if ($this->Pr->save($pr)) {
                $this->Flash->success(__('The pr has been saved.'));

                return $this->redirect(['action' => 'report']);
            }
            $this->Flash->error(__('The pr could not be saved. Please, try again.'));
        }
        $this->set(compact('pr'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pr id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pr = $this->Pr->get($id);
        if ($this->Pr->delete($pr)) {
            $this->Flash->success(__('The pr has been deleted.'));
        } else {
            $this->Flash->error(__('The pr could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function report(){
        $this->loadModel('PrItems');
        $this->loadModel('Supplier');
        $this->loadModel('Users');
        $this->loadModel('Po');
        $pr = $this->Pr->find('all')
            ->Where(['status'=>'approved']);
        foreach ($pr as $p){
            $po = $this->Po->find('all')
                ->Where(['pr_id'=>$p->id]);
            if(!$po->isEmpty()){
                $p->po_exists = 'Yes';
            }
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
            $urlToSales = 'http://salesmodule.acumenits.com/api/so-data?so='.rawurlencode($p->so_no);

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
                ->Where(['pr_id' => $p->id]);
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
        $this->set('pr',$pr);
    }

    public function approvalStatus(){
        $this->loadModel('PrItems');
        $this->loadModel('Supplier');
        $this->loadModel('Users');
        $this->loadModel('Po');
        $pr = $this->Pr->find('all');
        foreach ($pr as $p){
            $created_by = $this->Users->get($p->created_by);
            if(isset($p->verified_by)){
                $verified_by = $this->Users->get($p->verified_by);
                $p->verified_by = $verified_by;
            }
            if(isset($p->approved_by)){
                $approved_by = $this->Users->get($p->approved_by);
                $p->approved_by = $approved_by;
            }
            $p->created_by = $created_by;
            $urlToSales = 'http://salesmodule.acumenits.com/api/so-data?so='.rawurlencode($p->so_no);

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
                ->Where(['pr_id' => $p->id]);
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
        $this->set('pr',$pr);
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

        $total = $this->Pr->find('all');
        $approve = $this->Pr->find('all')
            ->Where(['status'=>'approved']);
        $request = $this->Pr->find('all')
            ->Where(['status'=>'requested'])
            ->orWhere(['status'=>'verified']);
        $reject = $this->Pr->find('all')
            ->Where(['status'=>'rejected']);
        $am = $this->Pr->find('all');
        $total_count = $approve_count = $request_count = $reject_count = $am_count = 0;
        foreach ($total as $t) {
            if (date('Y-m', strtotime($t->date)) == $year . '-' . $month){
                $total_count++;
                $items = $this->PrItems->find('all')
                    ->Where(['pr_id',$t->id]);
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
        if ($this->request->getParam('action') === 'autoRequests' || $this->request->getParam('action') === 'autoTwoRequests' || $this->request->getParam('action') === 'manualRequests' || $this->request->getParam('action') === 'addAuto' || $this->request->getParam('action') === 'addTwoAuto' || $this->request->getParam('action') === 'addManual' || $this->request->getParam('action') === 'generateAuto' || $this->request->getParam('action') === 'generateTwoAuto' || $this->request->getParam('action') === 'generateManual' || $this->request->getParam('action') === 'submitAuto' || $this->request->getParam('action') === 'submitTwoAuto' || $this->request->getParam('action') === 'submitManual' || $this->request->getParam('action') === 'edit' || $this->request->getParam('action') === 'delete' || $this->request->getParam('action') === 'viewAuto' || $this->request->getParam('action') === 'viewTwoAuto' || $this->request->getParam('action') === 'viewManual' || $this->request->getParam('action') === 'report' || $this->request->getParam('action') === 'approvalStatus' || $this->request->getParam('action') === 'statReport' || $this->request->getParam('action') === 'autoOneRequests') {
            return true;
        }
        if(isset($user['role']) && $user['role'] === 'requester'){
            if(in_array($this->request->action, ['autoRequests','autoOneRequests','autoTwoRequests','manualRequests','autoView','autoTwoView','manualView','addAuto','addTwoAuto','addManual','generateAuto','generateTwoAuto','generateManual','submitAuto','submitTwoAuto','submitManual','report','approvalStatus','statReport'])){
                return true;
            }
        }
        if(isset($user['role']) && $user['role'] === 'verifier'){
            if(in_array($this->request->action, ['autoRequests','autoTwoRequests','manualRequests','autoView','autoTwoView','manualView','report','approvalStatus','statReport'])){
                return true;
            }
        }
        if(isset($user['role']) && $user['role'] === 'approver-1'){
            if(in_array($this->request->action, ['autoRequests','autoTwoRequests','manualRequests','autoView','autoTwoView','manualView','report','approvalStatus','statReport'])){
                return true;
            }
        }
        return parent::isAuthorized($user);
    }
}
