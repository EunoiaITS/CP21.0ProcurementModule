<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PiController Controller
 *
 *
 * @method \App\Model\Entity\PiController[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PiController extends AppController
{

    public function initialize(){
        parent::initialize();
        $this->viewBuilder()->setLayout('mainframe');
    }

    public function index()
    {
        $this->loadModel('Supplier');
        $this->loadModel('SupplierItems');
        $sup_data = $this->Supplier->find('all');
        foreach ($sup_data as  $sup){
            $sup_items = $this->SupplierItems->find()
                ->Where(['supplier_id'=>$sup->id]);
            foreach ($sup_items as $sd){
                $urlToStore = 'http://storemodule.acumenits.com/in-stock-code/stock-available/';

                $sendToStore['part_no']=$sd->part_no;
                $sendToStore['part_name']=$sd->part_name;
                $optionsForStore = [
                    'http' => [
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method'  => 'POST',
                        'content' => http_build_query($sendToStore)
                    ]
                ];
                $contextForStore  = stream_context_create($optionsForStore);
                $resultFromStore = file_get_contents($urlToStore, false, $contextForStore);
                if ($resultFromStore === FALSE) {
                    echo 'ERROR!!';
                }
                $dataFromStore = json_decode($resultFromStore);
                $sup->stock = $dataFromStore->stock_available;

                $urlToPm = 'http://storemodule.acumenits.com/api/pm/';

                $sendToPm['part_no']=$sd->part_no;
                $sendToPm['part_name']=$sd->part_name;
                $optionsForPm = [
                    'http' => [
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method'  => 'POST',
                        'content' => http_build_query($sendToPm)
                    ]
                ];
                $contextForPm  = stream_context_create($optionsForPm);
                $resultFromPm = file_get_contents($urlToPm, false, $contextForPm);
                if ($resultFromPm === FALSE) {
                    echo 'ERROR!!';
                }
                $dataFromPm = json_decode($resultFromPm);
                $sup->min_stock = $dataFromPm->min_stock;
            }
            $sup->items = $sup_items;
        }
        $this->set('sup',$sup_data);
    }

    public function view()
    {
        $part_no = $this->request->getData('part_no');
        $part_name = $this->request->getData('part_name');
        $this->loadModel('SupplierItems');
        $this->loadModel('Supplier');
        $sup_itm_data = $this->SupplierItems->find('all')
            ->Where(['part_no'=>$part_no,'part_name'=>$part_name]);
        foreach ($sup_itm_data as $items){
            $sup_data = $this->Supplier->find('all')
                ->Where(['id'=> $items->supplier_id]);
            $items->sup_data = $sup_data;
        }

        $urlToStore = 'http://storemodule.acumenits.com/in-stock-code/stock-available/';

        $sendToStore['part_no']=$part_no;
        $sendToStore['part_name']=$part_name;
        $optionsForStore = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($sendToStore)
            ]
        ];
        $contextForStore  = stream_context_create($optionsForStore);
        $resultFromStore = file_get_contents($urlToStore, false, $contextForStore);
        if ($resultFromStore === FALSE) {
            echo 'ERROR!!';
        }
        $dataFromStore = json_decode($resultFromStore);

        $urlToPm = 'http://storemodule.acumenits.com/api/pm/';

        $sendToPm['part_no']=$part_no;
        $sendToPm['part_name']=$part_name;
        $optionsForPm = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($sendToPm)
            ]
        ];
        $contextForPm  = stream_context_create($optionsForPm);
        $resultFromPm = file_get_contents($urlToPm, false, $contextForPm);
        if ($resultFromPm === FALSE) {
            echo 'ERROR!!';
        }
        $dataFromPm = json_decode($resultFromPm);

        $urlToModel = 'http://engmodule.acumenits.com/api/model-data/';

        $sendToModel['part_no']=$part_no;
        $sendToModel['part_name']=$part_name;
        $optionsForModel = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($sendToModel)
            ]
        ];
        $contextForModel  = stream_context_create($optionsForModel);
        $resultFromModel = file_get_contents($urlToModel, false, $contextForModel);
        if ($resultFromModel === FALSE) {
            echo 'ERROR!!';
        }
        $dataFromModel = json_decode($resultFromModel);


        $this->set('all_data',$sup_itm_data);
        $this->set('stock',$dataFromStore->stock_available);
        $this->set('min_stk',isset($dataFromPm->min_stock));
        $this->set('model',$dataFromModel);
    }

    public function search()
    {
        $urlToEng = 'http://engmodule.acumenits.com/api/all-parts';
        $optionsForEng = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET',
            ]
        ];
        $contextForEng  = stream_context_create($optionsForEng);
        $resultFromEng = file_get_contents($urlToEng, false, $contextForEng);
        if ($resultFromEng === FALSE) {
            echo 'ERROR!!';
        }
        $dataFromEng = json_decode($resultFromEng);

        $part_no = $part_name = null;
        foreach($dataFromEng as $pm){
            $part_no .= '{label:"'.$pm->partNo.'",idx:"'.$pm->partName.'"},';
            $part_name .= '{label:"'.$pm->partName.'",idx:"'.$pm->partNo.'"},';
        }
        $part_no = rtrim($part_no, ',');
        $part_name = rtrim($part_name, ',');

        $this->set('eng_data',$dataFromEng);
        $this->set('part_no', $part_no);
        $this->set('part_name', $part_name);
    }
    public function isAuthorized($user){
        if ($this->request->getParam('action') === 'index' || $this->request->getParam('action') === 'view' || $this->request->getParam('action') === 'search') {
            return true;
        }
        return parent::isAuthorized($user);
    }
}
