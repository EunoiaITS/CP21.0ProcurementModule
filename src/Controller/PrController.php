<?php
namespace App\Controller;

use App\Controller\AppController;

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
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->loadModel('PrAuto');
        $pr = $this->paginate($this->PrAuto);

        $this->set(compact('pr'));
    }

    /**
     * View method
     *
     * @param string|null $id Pr id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pr = $this->Pr->get($id, [
            'contain' => []
        ]);

        $this->set('pr', $pr);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function addAuto()
    {
        $this->loadModel('PrAuto');
        $last_pr = $this->PrAuto->find('all')->last();
        $pr = $this->PrAuto->newEntity();
        if ($this->request->is('post')) {
            $pr = $this->PrAuto->patchEntity($pr, $this->request->getData());
            if ($this->PrAuto->save($pr)) {
                $this->Flash->success(__('The pr has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pr could not be saved. Please, try again.'));
        }
        $this->set(compact('pr'));
        $this->set('last_pr', (isset($last_pr->id) ? ($last_pr->id + 1) : 1));
    }

    public function addManual()
    {
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
                        $parts .= '{partNo:"'.$eng->partNo.'",partName:"'.$eng->partName.'",reqUantity:"'.$eng->quality.'",category:"'.$eng->category.'",stockAvailable:"'.$stockAvailable.'"},';
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
        $this->loadModel('PrManual');
        $this->loadModel('PrManualItems');
        $last_pr = $this->PrManual->find('all')->last();
        $pr = $this->PrManual->newEntity();
        if ($this->request->is('post')) {
            $pr = $this->PrManual->patchEntity($pr, $this->request->getData());
            if ($this->PrManual->save($pr)) {
                $this->Flash->success(__('The pr has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pr could not be saved. Please, try again.'));
        }
        $this->set(compact('pr'));
        $this->set('last_pr', (isset($last_pr->id) ? ($last_pr->id + 1) : 1));
        $this->set('so_no', $so_no);
        $this->set('sales', $dataFromSales);
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
