<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Purchase Order Approval Status</b></div>
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
                            <th>Verify By</th>
                            <th>Status</th>
                            <th>Approve By</th>
                            <th>Status</th>
                            <th>Approve By</th>
                            <th>Status</th>
                            <th>Document</th>
                            <th>Remark</th>
                        </tr>
                        </thead>
                        <tbody class="csn-text-up">
                        <?php $count = 0;foreach ($po as $p): $itemCount = 0; foreach ($p->items as $i): $count++; $itemCount++; ?>
                        <tr>
                            <td><?= $count ?></td>
                            <td><?php if($itemCount == 1){ echo $p->pr->so_no; } ?></td>
                            <td><?php if($itemCount == 1){ echo date('Y-m-d',strtotime($p->del_date)); } ?></td>
                            <td><?php if($itemCount == 1){ echo 'PR'.$p->pr_id; } ?></td>
                            <td><?php if($itemCount == 1){ echo date('Y-m-d',strtotime($p->date)); } ?></td>
                            <td><?php if($itemCount == 1){ echo 'PO'.$p->id; } ?></td>
                            <td><?= $i->eng->partNo ?></td>
                            <td><?= $i->eng->partName ?></td>
                            <td><?php if(isset($i->supplier_name->name)) echo $i->supplier_name->name; ?></td>
                            <td><?= $i->eng->quality ?></td>
                            <td><?=$i->total ?></td>
                            <td><?php if($itemCount == 1){ echo $p->created_by->name; } ?></td>
                            <td><?php if($itemCount == 1) echo 'Procurement'; ?></td>
                            <td class="<?php if($itemCount == 1) if($p->status == 'requested' || $p->status == 'rejected'){echo "colored-red";}elseif($p->status == 'verified' || $p->status == 'approved1' || $p->status == 'approved2'){echo "colored-csn";}?>"><?php if($itemCount == 1) if($p->status == 'requested'){echo "Pending";}elseif($p->status == 'rejected'){echo "Reject";}elseif($p->status == 'verified' || $p->status == 'approved1' || $p->status == 'approved2'){echo "Verify";}?></td>
                            <td><?php if($itemCount == 1) if(isset($p->verified_by->name)){echo $p->verified_by->name;}?></td>
                            <td class="<?php if($itemCount == 1) if($p->status == 'verified'){echo "colored-red";}elseif($p->status == 'approved1' || $p->status == 'approved2'){echo "colored-csn";}?>"><?php if($itemCount == 1) if($p->status == 'verified'){echo "Pending";}elseif($p->status == 'approved1' || $p->status == 'approved2'){echo "Approve";}?></td>
                            <td><?php if($itemCount == 1) if(isset($p->approve1_by->name)){echo $p->approve1_by->name;}?></td>
                            <td class="<?php if($itemCount == 1) if($p->status == 'approved1'){echo "colored-red";}elseif($p->status == 'approved1' || $p->status == 'approved2'){echo "colored-csn";}?>"><?php if($itemCount == 1) if($p->status == 'approved1'){echo "Pending";}elseif($p->status == 'approved1' || $p->status == 'approved2'){echo "Approve";}?></td>
                            <td><?php if($itemCount == 1) if(isset($p->approve2_by->name)){echo $p->approve2_by->name;}?></td>
                            <td class="<?php if($itemCount == 1) if($p->status == 'approved2'){echo "colored-csn";}?>"><?php if($itemCount == 1) if($p->status == 'approved2'){echo "Approve";}?></td>
                            <td><a href="#">View</a></td>
                            <td></td>
                        </tr>
                        <?php endforeach;endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
