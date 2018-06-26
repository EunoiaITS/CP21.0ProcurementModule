<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Supplier Controller
 *
 * @property \App\Model\Table\SupplierTable $Supplier
 *
 * @method \App\Model\Entity\Supplier[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SupplierController extends AppController
{

    public function initialize(){
        parent::initialize();
        $this->viewBuilder()->setLayout('mainframe');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->loadModel('SupplierItems');
        $supplier = $this->paginate($this->Supplier);
        foreach($supplier as $s){
            $items = $this->SupplierItems->find('all')
                ->where(['supplier_id' => $s->id]);
            $s->items = $items;
        }
        $partNo = $partName = '';
        $urlToEng = 'http://engmodule.acumenits.com/api/all-bom-parts';

        $optionsForEng = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET'
            ]
        ];
        $contextForEng  = stream_context_create($optionsForEng);
        $resultFromEng = file_get_contents($urlToEng, false, $contextForEng);
        if($resultFromEng !== FALSE){
            $dataFromEng = json_decode($resultFromEng);
            foreach($dataFromEng as $eng){
                $partNo .= '{label:"'.$eng->partNo.
                    '",bomId:"'.$eng->id.
                    '",partName:"'.$eng->partName.'"},';
                $partName .= '{label:"'.$eng->partName.
                    '",bomId:"'.$eng->id.
                    '",partNo:"'.$eng->partNo.'"},';
            }
        }
        $partNo = rtrim($partNo, ',');
        $partName = rtrim($partName, ',');
        if($this->request->is('post')){
            $supItems = TableRegistry::get('SupplierItems');
            $items = array();
            for($i = 1; $i <= $this->request->getData('total'); $i++){
                $items[$i]['supplier_id'] = $this->request->getData('supplier_id');
                $items[$i]['part_no'] = $this->request->getData('partno'.$i);
                $items[$i]['part_name'] = $this->request->getData('partname'.$i);
                $items[$i]['uom'] = $this->request->getData('uom'.$i);
                $items[$i]['unit_price'] = $this->request->getData('unitprice'.$i);
                $items[$i]['capability_m'] = $this->request->getData('capamonth'.$i);
                $items[$i]['ranking'] = $this->request->getData('ranking'.$i);
                if ($this->request->getData('file'.$i) != '') {
                    $fileName = $this->request->getData('file'.$i);
                    $ext = substr(strtolower(strrchr($fileName['name'], '.')), 1);
                    $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
                    $setNewFileName = $this->generateRandomString();
                    $imageFileName = $setNewFileName . '.' . $ext;
                    $uploadPath = WWW_ROOT . 'uploads/suppliers/' . $this->request->getData('supplier_id') . '/';
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath);
                    }
                    $uploadFile = $uploadPath.$imageFileName;
                    if (move_uploaded_file($fileName['tmp_name'], $uploadFile)) {
                        $items[$i]['doc_file'] = 'uploads/suppliers/'.$this->request->getData('supplier_id').'/'.$imageFileName;
                    }
                }
            }
            $allItems = $supItems->newEntities($items);
            $checker = 0;
            foreach($allItems as $item){
                if($supItems->save($item))
                    $checker++;
            }
            if($checker == $this->request->getData('total')){
                $this->Flash->success(__('The supplier items has been saved.'));

                return $this->redirect(['action' => 'index']);
            }elseif($checker > 0 && $checker < $this->request->getData('total')){
                $this->Flash->success(__('Some of the supplier items has been saved.'));

                return $this->redirect(['action' => 'index']);
            }else{
                $str = $this->generateRandomString();
                $this->Flash->error(__('No supplier items has been saved. '.$str));

                return $this->redirect(['action' => 'index']);
            }
        }

        $this->set(compact('supplier'));
        $this->set('part_nos', $partNo);
        $this->set('part_names', $partName);
    }

    /**
     * View method
     *
     * @param string|null $id Supplier id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->loadModel('SupplierItems');
        $supplier = $this->Supplier->get($id, [
            'contain' => []
        ]);

        $supplier->items = $this->SupplierItems->find('all')
            ->where(['supplier_id' => $supplier->id]);

        $this->set('supplier', $supplier);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $partNo = $partName = '';
        $urlToEng = 'http://engmodule.acumenits.com/api/all-bom-parts';

        $optionsForEng = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET'
            ]
        ];
        $contextForEng  = stream_context_create($optionsForEng);
        $resultFromEng = file_get_contents($urlToEng, false, $contextForEng);
        if($resultFromEng !== FALSE){
            $dataFromEng = json_decode($resultFromEng);
            foreach($dataFromEng as $eng){
                $partNo .= '{label:"'.$eng->partNo.
                    '",bomId:"'.$eng->id.
                    '",partName:"'.$eng->partName.'"},';
                $partName .= '{label:"'.$eng->partName.
                    '",bomId:"'.$eng->id.
                    '",partNo:"'.$eng->partNo.'"},';
            }
        }
        $partNo = rtrim($partNo, ',');
        $partName = rtrim($partName, ',');
        $supplier = $this->Supplier->newEntity();
        if ($this->request->is('post')) {

            $supplier = $this->Supplier->patchEntity($supplier, $this->request->getData());
            if ($this->Supplier->save($supplier)) {
                $sup_no = $this->Supplier->find('all', ['fields' => 'id'])->last();
                if($this->request->getData('total') != null){
                    $supItems = TableRegistry::get('SupplierItems');
                    $items = array();
                    for($i = 1; $i <= $this->request->getData('total'); $i++){
                        $items[$i]['supplier_id'] = $sup_no['id'];
                        $items[$i]['part_no'] = $this->request->getData('partno'.$i);
                        $items[$i]['part_name'] = $this->request->getData('partname'.$i);
                        $items[$i]['uom'] = $this->request->getData('uom'.$i);
                        $items[$i]['unit_price'] = $this->request->getData('unitprice'.$i);
                        $items[$i]['capability_m'] = $this->request->getData('capamonth'.$i);
                        $items[$i]['ranking'] = $this->request->getData('ranking'.$i);
                        if ($this->request->getData('file'.$i) != '') {
                            $fileName = $this->request->getData('file'.$i);
                            $ext = substr(strtolower(strrchr($fileName['name'], '.')), 1);
                            $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
                            $setNewFileName = $this->generateRandomString();
                            $imageFileName = $setNewFileName . '.' . $ext;
                            $uploadPath = WWW_ROOT . 'uploads/suppliers/' . $this->request->getData('supplier_id') . '/';
                            if (!file_exists($uploadPath)) {
                                mkdir($uploadPath);
                            }
                            $uploadFile = $uploadPath.$imageFileName;
                            if (move_uploaded_file($fileName['tmp_name'], $uploadFile)) {
                                $items[$i]['doc_file'] = 'uploads/suppliers/'.$this->request->getData('supplier_id').'/'.$imageFileName;
                            }
                        }
                    }
                    $allItems = $supItems->newEntities($items);
                    foreach($allItems as $item){
                        $supItems->save($item);
                    }
                }
                $this->Flash->success(__('The supplier has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The supplier could not be saved. Please, try again.'));
        }
        $this->set(compact('supplier'));
        $this->set('part_nos', $partNo);
        $this->set('part_names', $partName);
    }

    /**
     * Edit method
     *
     * @param string|null $id Supplier id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel('SupplierItems');
        $partNo = $partName = '';
        $urlToEng = 'http://engmodule.acumenits.com/api/all-bom-parts';

        $optionsForEng = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET'
            ]
        ];
        $contextForEng  = stream_context_create($optionsForEng);
        $resultFromEng = file_get_contents($urlToEng, false, $contextForEng);
        if($resultFromEng !== FALSE){
            $dataFromEng = json_decode($resultFromEng);
            foreach($dataFromEng as $eng){
                $partNo .= '{label:"'.$eng->partNo.
                    '",bomId:"'.$eng->id.
                    '",partName:"'.$eng->partName.'"},';
                $partName .= '{label:"'.$eng->partName.
                    '",bomId:"'.$eng->id.
                    '",partNo:"'.$eng->partNo.'"},';
            }
        }
        $partNo = rtrim($partNo, ',');
        $partName = rtrim($partName, ',');
        $supplier = $this->Supplier->get($id, [
            'contain' => []
        ]);
        $items = $this->SupplierItems->find('all')
            ->where(['supplier_id' => $supplier->id]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $supplier = $this->Supplier->patchEntity($supplier, $this->request->getData());
            foreach($items as $item){
                $item->part_no = $this->request->getData('part-no-'.$item->id);
                $item->part_name = $this->request->getData('part-name-'.$item->id);
                $item->uom = $this->request->getData('uom-'.$item->id);
                $item->unit_price = $this->request->getData('unit-price-'.$item->id);
                $item->capability_m = $this->request->getData('capa-'.$item->id);
                $item->ranking = $this->request->getData('ranking-'.$item->id);
                $this->SupplierItems->save($item);
            }
            if($this->request->getData('total') != null){
                $supItems = TableRegistry::get('SupplierItems');
                $items = array();
                for($i = 1; $i <= $this->request->getData('total'); $i++){
                    $items[$i]['supplier_id'] = $id;
                    $items[$i]['part_no'] = $this->request->getData('partno'.$i);
                    $items[$i]['part_name'] = $this->request->getData('partname'.$i);
                    $items[$i]['uom'] = $this->request->getData('uom'.$i);
                    $items[$i]['unit_price'] = $this->request->getData('unitprice'.$i);
                    $items[$i]['capability_m'] = $this->request->getData('capamonth'.$i);
                    $items[$i]['ranking'] = $this->request->getData('ranking'.$i);
                    if ($this->request->getData('file'.$i) != '') {
                        $fileName = $this->request->getData('file'.$i);
                        $ext = substr(strtolower(strrchr($fileName['name'], '.')), 1);
                        $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
                        $setNewFileName = $this->generateRandomString();
                        $imageFileName = $setNewFileName . '.' . $ext;
                        $uploadPath = WWW_ROOT . 'uploads/suppliers/' . $this->request->getData('supplier_id') . '/';
                        if (!file_exists($uploadPath)) {
                            mkdir($uploadPath);
                        }
                        $uploadFile = $uploadPath.$imageFileName;
                        if (move_uploaded_file($fileName['tmp_name'], $uploadFile)) {
                            $items[$i]['doc_file'] = 'uploads/suppliers/'.$this->request->getData('supplier_id').'/'.$imageFileName;
                        }
                    }
                }
                $allItems = $supItems->newEntities($items);
                foreach($allItems as $item){
                    $supItems->save($item);
                }
            }
            if ($this->Supplier->save($supplier)) {
                $this->Flash->success(__('The supplier has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The supplier could not be saved. Please, try again.'));
        }
        $this->set(compact('supplier'));
        $this->set('items', $items);
        $this->set('part_nos', $partNo);
        $this->set('part_names', $partName);
    }

    /**
     * Delete method
     *
     * @param string|null $id Supplier id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->loadModel('SupplierItems');
        $this->request->allowMethod(['post', 'delete']);
        $supplier = $this->Supplier->get($id);
        $items = $this->SupplierItems->find('all')
            ->where(['supplier_id' => $id]);
        if ($this->Supplier->delete($supplier)) {
            foreach($items as $i){
                $this->SupplierItems->delete($i);
            }
            $this->Flash->success(__('The supplier has been deleted.'));
        } else {
            $this->Flash->error(__('The supplier could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteItem($id = null)
    {
        $this->loadModel('SupplierItems');
        $this->request->allowMethod(['post', 'delete']);
        $supplier = $this->SupplierItems->get($id);
        if ($this->SupplierItems->delete($supplier)) {
            $this->Flash->success(__('The supplier item has been deleted.'));
        } else {
            $this->Flash->error(__('The supplier item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function testReq(){
        $this->autoRender = false;
        $supplier = $this->Supplier->newEntity();
        if ($this->request->is('post')) {
            $supplier = $this->Supplier->patchEntity($supplier, $this->request->getData());
            if ($this->Supplier->save($supplier)) {
                $sup_no = $this->Supplier->find('all', ['fields' => 'id'])->last();
                if($this->request->getData('total') != null){
                    $supItems = TableRegistry::get('SupplierItems');
                    $items = array();
                    for($i = 1; $i <= $this->request->getData('total'); $i++){
                        $items[$i]['supplier_id'] = $sup_no['id'];
                        $items[$i]['part_no'] = $this->request->getData('partno'.$i);
                        $items[$i]['part_name'] = $this->request->getData('partname'.$i);
                        $items[$i]['uom'] = $this->request->getData('uom'.$i);
                        $items[$i]['unit_price'] = $this->request->getData('unitprice'.$i);
                        $items[$i]['capability_m'] = $this->request->getData('capamonth'.$i);
                        $items[$i]['ranking'] = $this->request->getData('ranking'.$i);
                    }
                    $allItems = $supItems->newEntities($items);
                    foreach($allItems as $item){
                        $supItems->save($item);
                    }
                }
                $this->Flash->success(__('The supplier has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The supplier could not be saved. Please, try again.'));
        }
        $this->set(compact('supplier'));
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function isAuthorized($user){
        if(in_array($this->request->action, ['index', 'add', 'edit', 'delete', 'view', 'deleteItem'])){
            return true;
        }
        return parent::isAuthorized($user);
    }
}
