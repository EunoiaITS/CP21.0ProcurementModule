<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Purchase Requisition Request List</b></div>
            </div>

            <div class="clearfix"></div>
            <!--============== Add drawing table area ===================-->
            <div class="planner-table table-responsive clearfix">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>SO NO</th>
                            <th>SO Date</th>
                            <th>Delivery Date</th>
                            <th>Description</th>
                            <th>Customer Name</th>
                            <th>QTY</th>
                            <th>Category</th>
                            <th>Remark</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="csn-text-up">
                        <?php $count = 0; foreach($pr as $p): foreach ($p->soi as $items): $count++;?>
                            <tr>
                                <td><?= $count ?></td>
                                <td><?= $p->salesorder_no ?></td>
                                <td><?= date('Y-m-d',strtotime($p->date)) ?></td>
                                <td><?= date('Y-m-d',strtotime($p->delivery_date)) ?></td>
                                <td><?= $items->model . $items->version ?></td>
                                <td><?php foreach ($p->cus as $c){echo $c->name;} ?></td>
                                <td><?= $items->quantity ?></td>
                                <td>Auto</td>
                                <td></td>
                                <td><a href="<?php echo $this->Url->build(['controller'=>'Pr', 'action'=>'addAuto', $p->id])?>">Select</a></td>
                            </tr>
                        <?php endforeach;endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>