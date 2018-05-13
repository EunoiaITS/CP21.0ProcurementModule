<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

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
        $this->loadModel('Po');
        $this->loadModel('Pr');
        $this->loadModel('Mds');
        $this->loadModel('PrItems');
        $this->loadModel('Supplier');
        $pol = $this->paginate($this->Po);
        foreach($pol as $po){
            $pr = $this->Pr->get($po->pr_id, [
                'contain' => []
            ]);
            $po->pr = $pr;
            $pr_items = $this->PrItems->find('all')
                ->where(['pr_id' => $pr->id]);
            foreach($pr_items as $i){
                $mds = $this->Mds->find('all')
                    ->where(['pr_item_id' => $i->id]);
                if(!$mds->isEmpty()){
                    foreach($mds as $md){
                        $i->mds = $md;
                    }
                }
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
            $po->pr_items = $pr_items;
        }
        $this->set('pol', $pol);
    }

    public function mds(){
        $this->loadModel('Mds');
        $this->loadModel('MdsDetails');
        if($this->request->getQuery('type') === 'complete'){
            $check = $this->Mds->find('all')
                ->where(['pr_item_id' => $this->request->getQuery('id')]);
            if(!$check->isEmpty()){
                foreach($check as $ch){
                    if($ch->del_type == 'Complete'){
                        $this->Flash->error(__('The PO List is already complete.'));

                        return $this->redirect(['action' => 'index']);
                    }else{
                        $mds = $this->Mds->get($this->request->getQuery('id'), [
                            'contain' => []
                        ]);
                        $mds->no_del = 1;
                        $mds->del_type = 'Complete';
                        if($this->Mds->save($mds)){
                            $del_itms = $this->MdsDetails->find('all')
                                ->where(['mds_id' => $mds->id]);
                            foreach($del_itms as $dd){
                                $this->MdsDetails->delete($dd);
                            }
                            $this->Flash->success(__('The mds has been saved.'));

                            return $this->redirect(['action' => 'index']);
                        }
                        $this->Flash->error(__('The mds could not be saved. Please, try again.'));
                    }
                }
            }
            $mds = $this->Mds->newEntity();
            $mds->pr_item_id = $this->request->getQuery('id');
            $mds->no_del = 1;
            $mds->del_type = 'Complete';
            if($this->Mds->save($mds)){
                $this->Flash->success(__('The mds has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The mds could not be saved. Please, try again.'));
        }elseif($this->request->getQuery('type') === 'plan'){
            $this->loadModel('PrItems');
            $pr_item = $this->PrItems->get($this->request->getQuery('id'), [
                'contain' => []
            ]);
            $check = $this->Mds->find('all')
                ->where(['pr_item_id' => $pr_item->id])
                ->where(['del_type' => 'Plan']);
            if(!$check->isEmpty()){
                foreach($check as $ch){
                    $dels = $this->MdsDetails->find('all')
                        ->where(['mds_id' => $ch->id]);
                    $pr_item->mds = $ch;
                    $pr_item->dels = $dels;
                }
            }
            $urlToEng = 'http://engmodule.acumenits.com/api/bom-part/'.$pr_item->bom_part_id;

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
                $pr_item->eng = $dataFromEng;
            }

            if($this->request->is('post')){
                if($this->request->getData('action') != null){
                    for($j = 1; $j <= $this->request->getData('total-edit'); $j++){
                        $del_id = $this->request->getData('del-'.$j);
                        $mds_del = $this->MdsDetails->get($del_id, [
                            'contain' => []
                        ]);
                        $mds_del->del_date = date('Y-m-d', strtotime($this->request->getData('del-date-'.$del_id)));
                        $mds_del->del_qty = $this->request->getData('del-qty-'.$del_id);
                        $this->MdsDetails->save($mds_del);
                    }
                    $this->Flash->success(__('The PO List has been updated.'));

                    return $this->redirect(['action' => 'mds?id='.$this->request->getQuery('id').'&type=plan']);
                }
                $check = $this->Mds->find('all')
                    ->where(['pr_item_id' => $this->request->getQuery('id')]);
                if(!$check->isEmpty()){
                    foreach($check as $ch){
                        if($ch->del_type == 'Complete'){
                            $ch->del_type = 'Plan';
                            $mdsDetails = TableRegistry::get('MdsDetails');
                            $mds_itm = array();
                            if($this->Mds->save($ch)){
                                $mds_id = $ch->id;
                                if($this->request->getData('total') != null){
                                    for ($i = 1; $i <= $this->request->getData('total'); $i++){
                                        $mds_itm[$i]['mds_id'] = $mds_id;
                                        $mds_itm[$i]['del_date'] = date('Y-m-d H:i:s', strtotime($this->request->getData('del-date-'.$i)));
                                        $mds_itm[$i]['del_qty'] = $this->request->getData('del-qty-'.$i);
                                    }
                                    $mdss = $mdsDetails->newEntities($mds_itm);
                                    foreach ($mdss as $p){
                                        $mdsDetails->save($p);
                                    }
                                }
                                $this->Flash->success(__('The mds has been saved.'));

                                return $this->redirect(['action' => 'index']);
                            }
                            $this->Flash->error(__('The mds could not be saved. Please, try again.'));
                        }
                    }
                }
                $mds = $this->Mds->newEntity();
                $mds->pr_item_id = $this->request->getQuery('id');
                $mds->no_del = $this->request->getData('total');
                $mds->del_type = 'Plan';
                $mdsDetails = TableRegistry::get('MdsDetails');
                $mds_itm = array();
                if($this->Mds->save($mds)){
                    $mds_id = $this->Mds->find('all', ['fields'=>'id'])->last();
                    if($this->request->getData('total') != null){
                        for ($i = 1; $i <= $this->request->getData('total'); $i++){
                            $mds_itm[$i]['mds_id'] = $mds_id['id'];
                            $mds_itm[$i]['del_date'] = date('Y-m-d H:i:s', strtotime($this->request->getData('del-date-'.$i)));
                            $mds_itm[$i]['del_qty'] = $this->request->getData('del-qty-'.$i);
                        }
                        $mdss = $mdsDetails->newEntities($mds_itm);
                        foreach ($mdss as $p){
                            $mdsDetails->save($p);
                        }
                    }
                    $this->Flash->success(__('The mds has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The mds could not be saved. Please, try again.'));
            }

            $this->set('item', $pr_item);
            $this->set('md', $this->request->getQuery('id'));
        }else{
            $this->Flash->error(__('Wrong credentials. Please provide the right data.'));

            return $this->redirect(['action' => 'index']);
        }
    }

    public function report(){
        $this->loadModel('Mds');
        $this->loadModel('MdsDetails');
        $this->loadModel('Po');
        $this->loadModel('Pr');
        $this->loadModel('PrItems');
        $this->loadModel('Supplier');
        $pol = $this->paginate($this->Mds);
        foreach($pol as $p){
            $mds_dels = $this->MdsDetails->find('all')
                ->where(['mds_id' => $p->id]);
            $p->mds_dels = $mds_dels;
            $pr_item = $this->PrItems->get($p->pr_item_id);
            $p->pr_item = $pr_item;
            $pr = $this->Pr->get($pr_item->pr_id);
            $p->pr = $pr;
            $po = $this->Po->find('all')
                ->where(['pr_id' => $pr->id]);
            foreach($po as $xx){
                $p->po = $xx;
            }
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
                }
            }
            $urlToEng = 'http://engmodule.acumenits.com/api/bom-part/'.$pr_item->bom_part_id;

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
                $pr_item->eng = $dataFromEng;
            }
            $supplier = '';
            if($pr_item->supplier_id !== null){
                $supplier = $this->Supplier->get($pr_item->supplier_id);
            }
            $pr_item->supplier_name = $supplier;
        }
        $this->set('pol', $pol);
    }

    public function search(){
        $this->loadModel('Supplier');
        $this->loadModel('SupplierItems');
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
        $this->set('part_nos', $part_nos);
        $this->set('part_names', $part_names);
    }

    public function partDetails(){
        if($this->request->is('post')){
            //$this->autoRender = false;
            $this->loadModel('Mds');
            $this->loadModel('MdsDetails');
            $this->loadModel('Po');
            $this->loadModel('Pr');
            $this->loadModel('PrItems');
            $this->loadModel('Supplier');
            $result = new \stdClass();
            $count = 0;
            $result->part_no = $this->request->getData('part-no');
            $result->part_name = $this->request->getData('part-name');
            $items = $this->PrItems->find('all')
                ->where(['bom_part_id' => $this->request->getData('bom-part-id')]);
            $prs = [];
            foreach($items as $item){
                $match = $this->Mds->find('all')
                    ->where(['pr_item_id' => $item->id]);
                if(!$match->isEmpty()){
                    $result->total = $item->total;
                    $result->qty_req = $item->sub_total/$item->order_qty;
                    $prs[] = $item->pr_id;
//                    $supplier = '';
//                    if($item->supplier_id !== null){
//                        $supplier = $this->Supplier->get($item->supplier_id, [
//                            'contain' => []
//                        ]);
//                    }
//                    $result->$count->supplier = $supplier;
                }
            }
            $prs = array_unique($prs);
            foreach($prs as $dd){
                $count++;
                $pr = $this->Pr->get($dd);
                $result->so->$count->pr = $pr;
                $po = $this->Po->find('all')
                    ->where(['pr_id' => $dd]);
                foreach($po as $p){
                    $result->so->$count->po = $p;
                }
            }
//            echo '<pre>';
//            print_r($prs);
//            echo '</pre>';
            $this->set('result', $result);
        }else{
            $this->Flash->error(__('Wrong method. Please provide the right data.'));

            return $this->redirect(['action' => 'search']);
        }
    }

    public function isAuthorized($user){
        if(in_array($this->request->action, ['index', 'mds', 'report', 'search', 'partDetails'])){
            return true;
        }
        return parent::isAuthorized($user);
    }

}
