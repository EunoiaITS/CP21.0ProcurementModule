<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>PR  Request List (Auto)</b></div>
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
                        <?php $count = 0;foreach ($pr as $p): $count++?>
                            <tr>
                                <td><?= $count ?></td>
                                <td><u><?= $p->so_no ?></u></td>
                                <td><?= date('Y-m-d',strtotime($p->date)) ?></td>
                                <td><?= date('Y-m-d',strtotime($p->del_date)) ?></td>
                                <td><?= $p->model . $p->version ?></td>
                                <td><?= $p->customer ?></td>
                                <td><?= $p->quantity ?></td>
                                <td>Auto</td>
                                <td><?php if(isset($p->remark)){echo $p->remark;} ?></td>
                                <td><a href="<?php echo $this->Url->build(['controller'=>'Pr', 'action'=>'viewAuto', $p->id])?>"><?php if($role == 'requester'){echo 'pending';}elseif ($role == 'verifier'){echo 'verify';}elseif ($role == 'approver-1'){echo 'approve';}?></a></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>