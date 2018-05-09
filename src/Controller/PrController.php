<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Pr Controller
 *
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
    public function autoRequests()
    {
        $this->loadModel('PrAuto');
        $pr = $this->PrAuto->find('all')
        ->Where(['status'=>'requested']);

        $this->set(compact('pr'));
    }

    /**
     * AutoTwoRequests method
     *
     * @return \Cake\Http\Response|void
     */
    public function autoTwoRequests()
    {
        $this->loadModel('PrAuto');
        $pr = $this->PrAuto->find('all')
            ->Where(['status'=>'requested']);

        $this->set(compact('pr'));
    }

    /**
     * ManualRequests method
     *
     * @return \Cake\Http\Response|void
     */
    public function manualRequests()
    {
        $pr = $this->Pr->find('all')
            ->Where(['status'=>'requested'])
            ->Where(['section' => 'manual']);

        $this->set(compact('pr'));
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
        $pr = $this->Pr->get($id, [
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
        $this->loadModel('PrAuto');
        $this->loadModel('PrAutoItems');
        $this->loadModel('Supplier');
        $this->loadModel('SupplierItems');
        $pr = $this->PrAuto->get($id, [
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

        $items = $this->PrAutoItems->find('all')
            ->where(['pr_auto_id' => $id]);
        foreach($items as $i){
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
        $pr->items = $items;

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
        $this->loadModel('PrAuto');
        $this->loadModel('PrAutoItems');
        $this->loadModel('Supplier');
        $this->loadModel('SupplierItems');
        $pr = $this->PrAuto->get($id, [
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

        $items = $this->PrAutoItems->find('all')
            ->where(['pr_auto_id' => $id]);
        foreach($items as $i){
            $supplier = $this->Supplier->get($i->supplier, [
                'contain' => []
            ]);
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
        $pr->items = $items;

        $this->set('pr', $pr);
    }

    /**
     * AddAuto method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function addAuto()
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
                        $uom = $supplier1 = $supplier2 = $supplier3 = '';
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
                            ${'supplier'.$count} = $supplier->name;
                            ${'price'.$count} = $ii->unit_price;
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
                        $parts .= '{
                            id:"'.$eng->id.'",
                            partNo:"'.$eng->partNo.'",
                            partName:"'.$eng->partName.'",
                            reqQuantity:"'.$eng->quality.'",
                            category:"'.$eng->category.'",
                            stockAvailable:"'.$stockAvailable.'",
                            supplier1:"'.$supplier1.'",
                            supplier2:"'.$supplier2.'",
                            supplier3:"'.$supplier3.'",
                            price1:"'.$price1.'",
                            price2:"'.$price2.'",
                            price3:"'.$price3.'",
                            uom:"'.$uom.'"
                            },';
                    }
                }
            }
            $parts = rtrim($parts, ',');
            $this->loadModel('PrAuto');
            $this->loadModel('PrAutoItems');
            $last_pr = $this->PrAuto->find('all')->last();
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
        $this->loadModel('PrAuto');
        $this->loadModel('PrAutoItems');
        $last_pr = $this->PrAuto->find('all',['order'=>'id']);

        $this->set('so_no',$so_no);
        $this->set('pr_id', (isset($last_pr->id) ? ($last_pr->id + 1) : 1));
    }

    /**
     * GenerateAuto method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function generateAuto(){
        $so_no = $this->request->getData('so_no');
        $date = $this->request->getData('date');
        $delivery_date = $this->request->getData('delivery_date');
        $description = $this->request->getData('description');
        $customer = $this->request->getData('customer');
        $pr_id = $this->request->getData('pr_id');
        $pr_items = array();
        if($this->request->getData('counter') != null) {
            for ($i = 1; $i <= $this->request->getData('counter'); $i++) {
                if($this->request->getData('checkbox'.$i)){
                    $pr_items[$i]['bom_part_id'] = $this->request->getData('bom_part_id'.$i);
                    $pr_items[$i]['part_no'] = $this->request->getData('part_no' . $i);
                    $pr_items[$i]['part_name'] = $this->request->getData('part_name' . $i);
                    if($this->request->getData('supplier'.$i) == 2){
                        $pr_items[$i]['supplier'] = $this->request->getData('supplier2' . $i);
                        $pr_items[$i]['price'] = $this->request->getData('price2' . $i);
                    }elseif($this->request->getData('supplier'.$i) == 3){
                        $pr_items[$i]['supplier'] = $this->request->getData('supplier3' . $i);
                        $pr_items[$i]['price'] = $this->request->getData('price3' . $i);
                    }else{
                        $pr_items[$i]['supplier'] = $this->request->getData('supplier1' . $i);
                        $pr_items[$i]['price'] = $this->request->getData('price1' . $i);
                    }
                    $pr_items[$i]['uom'] = $this->request->getData('uom' . $i);
                    $pr_items[$i]['category'] = $this->request->getData('category' . $i);
                    $pr_items[$i]['req_quantity'] = $this->request->getData('reqQuantity' . $i);
                    $pr_items[$i]['stock_available'] = $this->request->getData('stockAvailable' . $i);
                    $pr_items[$i]['order_qty'] = $this->request->getData('order_qty' . $i);
                    $pr_items[$i]['supplier'] = $this->request->getData('supplier' . $i);
                    $pr_items[$i]['sub_total'] = $this->request->getData('sub_total' . $i);
                    $pr_items[$i]['gst'] = $this->request->getData('gst' . $i);
                    $pr_items[$i]['total'] = $this->request->getData('total' . $i);
                }
            }
        }
        $this->set('pr_items',$pr_items);
        $this->set('so_no',$so_no);
        $this->set('date',$date);
        $this->set('del_date',$delivery_date);
        $this->set('desc',$description);
        $this->set('pr_id',$pr_id);
        $this->set('cus',$customer);
    }

    /**
     * SubmitAuto method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function submitAuto(){
        if($this->request->is('post')){
            $this->loadModel('PrAuto');
            $this->loadModel('PrAutoItems');
            $pr = $this->PrAuto->newEntity();
            $pr->date = $this->request->getData('date');
            $pr->so_no = $this->request->getData('so_no');
            $pr->delivery_date = $this->request->getData('delivery_date');
            $pr->description = $this->request->getData('description');
            $pr->customer = $this->request->getData('customer');
            $pr->status = 'requested';
            $pr->section = 'Auto-1';
            $pr_itm = array();
            $prChild = TableRegistry::get('prAutoItems');
            if($this->PrAuto->save($pr)){
                $pr_id = $this->PrAuto->find('all',['fields'=>'id'])->last();
                if($this->request->getData('total') != null){
                    for ($i=1;$i <= $this->request->getData('total');$i++){
                        $pr_itm[$i]['pr_auto_id'] = $pr_id['id'];
                        $pr_itm[$i]['bom_part_id'] = $this->request->getData('bom_part_id'.$i);
                        $pr_itm[$i]['order_qty'] = $this->request->getData('order_qty'.$i);
                        $pr_itm[$i]['supplier'] = $this->request->getData('supplier'.$i);
                        $pr_itm[$i]['stock_available'] = $this->request->getData('stock_available'.$i);
                        $pr_itm[$i]['sub_total'] = $this->request->getData('sub_total'.$i);
                        $pr_itm[$i]['gst'] = $this->request->getData('gst'.$i);
                        $pr_itm[$i]['total'] = $this->request->getData('total'.$i);
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
                        $uom = $supplier1 = $supplier2 = $supplier3 = '';
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
                            ${'supplier'.$count} = $supplier->name;
                            ${'price'.$count} = $ii->unit_price;
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
                        $parts .= '{
                            id:"'.$eng->id.'",
                            partNo:"'.$eng->partNo.'",
                            partName:"'.$eng->partName.'",
                            reqQuantity:"'.$eng->quality.'",
                            category:"'.$eng->category.'",
                            stockAvailable:"'.$stockAvailable.'",
                            supplier1:"'.$supplier1.'",
                            supplier2:"'.$supplier2.'",
                            supplier3:"'.$supplier3.'",
                            price1:"'.$price1.'",
                            price2:"'.$price2.'",
                            price3:"'.$price3.'",
                            uom:"'.$uom.'"
                            },';
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
        $this->loadModel('PrAuto');
        $this->loadModel('PrAutoItems');
        $last_pr = $this->PrAuto->find('all',['order'=>'id']);

        if($this->request->is('post')){
            $pr = $this->PrAuto->newEntity();
            $pr->date = $this->request->getData('date');
            $pr->so_no = $this->request->getData('so_no');
            $pr->delivery_date = $this->request->getData('delivery_date');
            $pr->description = $this->request->getData('description');
            $pr->customer = $this->request->getData('customer');
            $pr->status = 'requested';
            $pr->section = 'Auto-2';
            $pr_itm = array();
            $prChild = TableRegistry::get('prAutoItems');
            if($this->PrAuto->save($pr)){
                $pr_id = $this->PrAuto->find('all',['fields'=>'id'])->last();
                if($this->request->getData('counter') != null){
                    for ($i=1;$i <= $this->request->getData('counter');$i++){
                        $pr_itm[$i]['pr_auto_id'] = $pr_id['id'];
                        $pr_itm[$i]['bom_part_id'] = $this->request->getData('bom_part_id'.$i);
                        $pr_itm[$i]['order_qty'] = $this->request->getData('order_qty'.$i);
                        $pr_itm[$i]['supplier'] = $this->request->getData('supplier'.$i);
                        $pr_itm[$i]['stock_available'] = $this->request->getData('stock_available'.$i);
                        $pr_itm[$i]['sub_total'] = $this->request->getData('sub_total'.$i);
                        $pr_itm[$i]['gst'] = $this->request->getData('gst'.$i);
                        $pr_itm[$i]['total'] = $this->request->getData('total'.$i);
                    }
                    $prs = $prChild->newEntities($pr_itm);
                    foreach ($prs as $p){
                        $prChild->save($p);
                    }
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

                return $this->redirect(['action' => 'index']);
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
}
