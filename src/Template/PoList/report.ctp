<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Procurement Order list Report</b></div>
            </div>

            <div class="clearfix"></div>
            <!--============== Add drawing table area ===================-->
            <div class="planner-table table-responsive clearfix">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>SO No</th>
                            <th>Delivery Date</th>
                            <th>PR Date</th>
                            <th>PR No</th>
                            <th>PO Date</th>
                            <th>PO No</th>
                            <th>Part No</th>
                            <th>Description</th>
                            <th>Supplier</th>
                            <th>QTY Request</th>
                            <th>Extra 10%</th>
                            <th>Total</th>
                            <th>Create By</th>
                            <th>Department</th>
                            <th>Delivery Type</th>
                            <th>DO Date</th>
                            <th>DO No</th>
                            <th>GRN No</th>
                            <th>QTY Recive</th>
                            <th>Document</th>
                            <th>Remark</th>
                        </tr>
                        </thead>
                        <tbody class="csn-text-up">
                        <?php $count = 0; foreach($pol as $p): $count++; ?>
                        <tr>
                            <td><?= $count ?></td>
                            <td>SO<?= $p->pr->so_no ?></td>
                            <td><?= date('Y-m-d', strtotime($p->del_date)) ?></td>
                            <td><?= date('Y-m-d', strtotime($p->pr->date)) ?></td>
                            <td>PR<?= $p->pr->id ?></td>
                            <td><?= date('Y-m-d', strtotime($p->po->date)) ?></td>
                            <td>PO<?= $p->po->id ?></td>
                            <td><?= $p->pr_item->eng->partNo ?></td>
                            <td><?= $p->pr_item->eng->partName ?></td>
                            <td><?= $p->pr_item->supplier_name->name ?></td>
                            <td><?= $p->pr_item->eng->quality ?></td>
                            <td></td>
                            <td><?= $p->pr_item->total ?></td>
                            <td>Azlin</td>
                            <td>*Procurement</td>
                            <td><?php if($p->del_type == 'Plan'): ?><a href="#" data-toggle="modal" data-target="#myModal<?= $count ?>"><?= $p->del_type ?><?php else: echo 'Complete'; endif; ?></a></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $count = 0; foreach($pol as $p): if(isset($p->mds_dels)): $count++; ?>
<div class="modal fade" id="myModal<?= $count ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">Material Delivery Scheduler</h4>
            </div>
            <div class="modal-body supplier-modal-body table-responsive">
                <table class="table table-bordered ">
                    <thead>
                    <tr>
                        <th>Delivery Date</th>
                        <th>Delivery Quantity</th>
                    </tr>
                    </thead>
                    <tbody class="csn-text-up">
                    <?php foreach($p->mds_dels as $del): ?>
                    <tr>
                        <td><?= date('Y-m-d', strtotime($del->del_date)) ?></td>
                        <td><?= $del->del_qty ?></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<?php endif; endforeach; ?>