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
        $supplier = $this->Supplier->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $supplier = $this->Supplier->patchEntity($supplier, $this->request->getData());
            if ($this->Supplier->save($supplier)) {
                $this->Flash->success(__('The supplier has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The supplier could not be saved. Please, try again.'));
        }
        $this->set(compact('supplier'));
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
        $this->request->allowMethod(['post', 'delete']);
        $supplier = $this->Supplier->get($id);
        if ($this->Supplier->delete($supplier)) {
            $this->Flash->success(__('The supplier has been deleted.'));
        } else {
            $this->Flash->error(__('The supplier could not be deleted. Please, try again.'));
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

}