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
        $this->loadModel('Users');
        $pol = $this->paginate($this->Po);
        foreach($pol as $po){
            $po->req = $this->Users->get($po->created_by);
            $pr = $this->Pr->get($po->pr_id, [
                'contain' => []
            ]);
            $po->pr = $pr;
            $pr_items = $this->PrItems->find('all')
                ->where(['pr_id' => $pr->id]);
            $urlToSales = 'http://salesmodule.acumenits.com/api/so-data?so='.rawurlencode($pr->so_no);

            $optionsForSales = [
                'http' => [
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'GET'
                ]
            ];
            $contextForSales  = stream_context_create($optionsForSales);
            $resultFromSales = file_get_contents($urlToSales, false, $contextForSales);
            if($resultFromSales !== FALSE){
                $dataFromSales = json_decode($resultFromSales);
                foreach($dataFromSales as $ds){
                    $po->del_date = $ds->delivery_date;
                }
            }
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
            $mds->created_by = $this->Auth->user('id');
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
                    if($this->request->getData('addeds') != 0){
                        $mdsDetails = TableRegistry::get('MdsDetails');
                        $mds_itm = array();
                        for ($i = 1; $i <= $this->request->getData('addeds'); $i++){
                            $mds_itm[$i]['mds_id'] = $this->request->getQuery('id');
                            $mds_itm[$i]['del_date'] = date('Y-m-d H:i:s', strtotime($this->request->getData('add-del-date-'.$i)));
                            $mds_itm[$i]['del_qty'] = $this->request->getData('add-del-qty-'.$i);
                        }
                        $mdss = $mdsDetails->newEntities($mds_itm);
                        foreach ($mdss as $p){
                            $mdsDetails->save($p);
                        }
                    }
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
                $mds->created_by = $this->Auth->user('id');
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

    public function delete($id = null){
        $this->loadModel('MdsDetails');
        $this->request->allowMethod(['post', 'delete']);
        $po = $this->MdsDetails->get($id);
        if ($this->MdsDetails->delete($po)) {
            $this->Flash->success(__('The MDS item has been deleted.'));
        } else {
            $this->Flash->error(__('The MDS item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'mds?id='.$this->request->getQuery('mds').'&type=plan']);
    }

    public function report(){
        $this->loadModel('Mds');
        $this->loadModel('MdsDetails');
        $this->loadModel('Po');
        $this->loadModel('Pr');
        $this->loadModel('PrItems');
        $this->loadModel('Supplier');
        $this->loadModel('Users');
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
            $p->requester = $this->Users->get($p->created_by);
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
        $this->loadModel('Mds');
        $this->loadModel('PrItems');
        $part_nos = $part_names = '';
        $mds = $this->Mds->find('all');
        $bomParts = array();
        $suppliers = array();
        foreach($mds as $md){
            $pr_item = $this->PrItems->get($md->pr_item_id);
            $bomParts[] = $pr_item->bom_part_id;
            $suppliers[] = $pr_item->supplier_id;
        }
        $bomParts = array_unique($bomParts);
        $suppliers = array_unique($suppliers);
        $supplier = $this->Supplier->find()
            ->where(['id IN' => $suppliers]);
        foreach($bomParts as $bom){
            $urlToEng = 'http://engmodule.acumenits.com/api/bom-part/'.$bom;

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
                $part_nos .= '{label:"'.$dataFromEng->partNo.'",partName:"'.$dataFromEng->partName.'",bomId:"'.$dataFromEng->id.'"},';
                $part_nos .= '{label:"'.$dataFromEng->partName.'",partNo:"'.$dataFromEng->partNo.'",bomId:"'.$dataFromEng->id.'"},';
            }
        }
        $part_nos = rtrim($part_nos, ',');
        $part_names = rtrim($part_names, ',');
        $this->set('part_nos', $part_nos);
        $this->set('part_names', $part_names);
        $this->set('suppliers', $suppliers);
        $this->set('supplier', $supplier);
    }

    public function partDetails(){
        if($this->request->is('post')){
            $this->loadModel('Mds');
            $this->loadModel('MdsDetails');
            $this->loadModel('Po');
            $this->loadModel('Pr');
            $this->loadModel('PrItems');
            $this->loadModel('Supplier');
            $this->loadModel('SupplierItems');
            $this->loadModel('Users');
            $result = new \stdClass;
            $result->part_no = $this->request->getData('part-no');
            $result->part_name = $this->request->getData('part-name');
            $items = $this->PrItems->find('all')
                ->where(['bom_part_id' => $this->request->getData('bom-part-id')]);
            foreach($items as $item){
                $match = $this->Mds->find('all')
                    ->where(['pr_item_id' => $item->id]);
                if(!$match->isEmpty()){
                    $pr = $this->Pr->get($item->pr_id);
                    $item->pr = $pr;
                    $po = $this->Po->find('all')
                        ->where(['pr_id' => $item->pr_id]);
                    foreach($po as $p){
                        $p->req = $this->Users->get($p->created_by);
                        $item->po = $p;
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
                            $pr->del_date = $s->delivery_date;
                            $pr->customer = $s->cus->name;
                        }
                    }
                }
            }
            if($this->request->getData('supplier') != null){
                $result->supplier = $this->Supplier->get($this->request->getData('supplier'));
                $supplier_item = $this->SupplierItems->find()
                    ->where(['part_no' => $this->request->getData('part-no')])
                    ->where(['part_name' => $this->request->getData('part-name')])
                    ->where(['supplier_id' => $this->request->getData('supplier')]);
                $result->supplier_item = $supplier_item->first();
            }
            $this->set('items', $items);
            $this->set('result', $result);
        }else{
            $this->Flash->error(__('Wrong method. Please provide the right data.'));

            return $this->redirect(['action' => 'search']);
        }
    }

    public function isAuthorized($user){
        if(in_array($this->request->action, ['index', 'mds', 'report', 'search', 'partDetails', 'delete'])){
            return true;
        }
        return parent::isAuthorized($user);
    }

}
