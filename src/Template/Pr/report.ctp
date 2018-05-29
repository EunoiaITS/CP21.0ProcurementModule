<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Purchase Requisition Report</b></div>
            </div>

            <div class="clearfix"></div>
            <!--============== Add drawing table area ===================-->
            <div class="planner-table table-responsive clearfix">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Serial</th>
                            <th>SO NO</th>
                            <th>Delivery Date</th>
                            <th>PR Date</th>
                            <th>PR No</th>
                            <th>Items View</th>
                            <th>Create By</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Document</th>
                            <th>PO Status</th>
                            <th>Remark</th>
                        </tr>
                        </thead>
                        <tbody class="csn-text-up">
                        <?php $count = 0; foreach ($pr as $p): $count++;?>
                        <tr>
                            <td><?= $count?></td>
                            <td><?= $p->so_no ?></td>
                            <td><?= date('Y-m-d',strtotime($p->del_date)) ?></td>
                            <td><?= date('Y-m-d',strtotime($p->date))?></td>
                            <td>PR <?= $p->id ?></td>
                            <td id="popup"><span class="click-button" data-toggle="modal" data-target="#myModal<?= $count?>">PR <?= $p->id?></span></td>
                            <td><?php if(isset($p->created_by->name)){echo $p->created_by->name;} ?></td>
                            <td>Procurement</td>
                            <td class="<?php if(isset($p->status)){if($p->status == 'approved'){echo "colored-csn";}else{echo "colored-red";}}?>"><?php if(isset($p->status)){if($p->status == 'approved'){echo "Approve";}else{echo "Pending";}}?></td>
                            <td><a href="#">View</a></td>
                            <td class="<?php if(isset($p->po_exists)){echo "colored-csn";}else{echo "colored-red";}?>"><?php if(isset($p->po_exists)){echo "Created";}else{echo "Pending";}?></td>
                            <td></td>
                        </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php $count = 0;foreach ($pr as $p): $count++;?>
        <div class="modal fade" id="myModal<?= $count ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Purchase Order Popup</h4>
                    </div>
                    <div class="modal-body supplier-modal-body table-responsive">
                        <table class="table table-bordered ">
                            <thead>
                            <tr>
                                <th><?=$count?></th>
                                <th>Part No</th>
                                <th>Description</th>
                                <th>Supplier</th>
                                <th>QTY Request</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody class="csn-text-up">
                            <?php $item_count = 0;foreach ($p->items as $i): $item_count++;?>
                                <tr>
                                    <td><?= $item_count ?></td>
                                    <td><?= $i->eng->partNo ?></td>
                                    <td><?= $i->eng->partName ?></td>
                                    <td><?php if(isset($i->supplier_name->name)) echo $i->supplier_name->name; ?></td>
                                    <td><?php if($p->section == 'manual'){echo $i->req_qty;}else{echo $i->eng->quality;} ?></td>
                                    <td>$<?= $i->total ?></td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    <?php endforeach;?>
