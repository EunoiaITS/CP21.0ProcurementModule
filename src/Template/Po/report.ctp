<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Purchase Order Report</b></div>
            </div>

            <div class="clearfix"></div>
            <!--============== Add drawing table area ===================-->
            <div class="planner-table table-responsive clearfix">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Serial</th>
                            <th>SO No</th>
                            <th>Delivery Date</th>
                            <th>PR No</th>
                            <th>PO Date</th>
                            <th>PO No</th>
                            <th>Part No</th>
                            <th>Description</th>
                            <th>Supplier</th>
                            <th>QTY Request</th>
                            <th>Total</th>
                            <th>Create By</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Document</th>
                            <th>Remark</th>
                            <th>Inform Supply</th>
                        </tr>
                        </thead>
                        <tbody class="csn-text-up">
                        <?php $count = 0;foreach ($po as $p): foreach ($p->items as $i): $count++;?>
                        <tr>
                            <td><?= $count ?></td>
                            <td><?= $p->pr->so_no ?></td>
                            <td><?= date('Y-m-d',strtotime($p->del_date)) ?></td>
                            <td>PR <?= $p->pr_id ?></td>
                            <td><?= date('Y-m-d',strtotime($p->date)) ?></td>
                            <td>PO <?= $p->id ?></td>
                            <td><?= $i->eng->partNo ?></td>
                            <td><?= $i->eng->partName ?></td>
                            <td><?php if(isset($i->supplier_name->name)) echo $i->supplier_name->name; ?></td>
                            <td><?= $i->eng->quality?></td>
                            <td>$<?= $i->total ?></td>
                            <td><?= $p->requester->name ?></td>
                            <td>Procurement</td>
                            <td class="<?php if($p->status == 'approved3'){echo 'colored-csn';}elseif($p->status == 'rejected'){echo 'colored-red';}else{echo 'colored-red';}?>"><?php if($p->status == 'approved3'){echo 'Approved';}elseif ($p->status == 'rejected'){echo 'Reject';}else{echo 'Pending';}?></td>
                            <td><a href="#">View</a></td>
                            <td></td>
                            <td><a href="#">Email</a></td>
                        </tr>
                        <?php endforeach;endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>