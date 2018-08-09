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
                            <th>Quantity Request</th>
                            <th>Extra 10%</th>
                            <th>Total</th>
                            <th>Create By</th>
                            <th>Department</th>
                            <th>Delivery Type</th>
                            <th>No of Delivery</th>
                            <th>Delivery Date</th>
                            <th>Delivery Quantity</th>
                            <th>DO Date</th>
                            <th>DO No</th>
                            <th>GRN No</th>
                            <th>Quantity Receive</th>
                            <th>Document</th>
                            <th>Remark</th>
                        </tr>
                        </thead>
                        <tbody class="csn-text-up">
                        <?php $count = 0; foreach($pol as $p) {
                            $count++;
                            if($p->del_type == 'Complete'){  ?>
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
                                <td><?php if(isset($p->pr_item->supplier_name->name)){echo $p->pr_item->supplier_name->name;} ?></td>
                                <td><?= $p->pr_item->eng->quality ?></td>
                                <td></td>
                                <td><?= $p->pr_item->total ?></td>
                                <td><?= $p->requester->name ?></td>
                                <td>*Procurement</td>
                                <td>Complete</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php }?>
                            <?php if(isset($p->mds_dels)){ ?>
                                <?php if($p->del_type == 'Plan'){ ?>
                                    <?php $item_count = 0; foreach($p->mds_dels as $del){ $item_count++;?>
                            <tr>
                                <td><?php if($item_count <= 1){ echo $count;}  ?></td>
                                <td><?php if($item_count <= 1){ echo 'SO' . $p->pr->so_no;}?></td>
                                <td><?php if($item_count <= 1){ echo date('Y-m-d', strtotime($p->del_date));} ?></td>
                                <td><?php if($item_count <= 1){ echo date('Y-m-d', strtotime($p->pr->date)) ;}?></td>
                                <td><?php if($item_count <= 1){ echo 'PR' .$p->pr->id ;}?></td>
                                <td><?php if($item_count <= 1){ echo date('Y-m-d', strtotime($p->po->date)) ;}?></td>
                                <td><?php if($item_count <= 1){ echo 'PO' . $p->po->id ;}?></td>
                                <td><?php if($item_count <= 1){ echo $p->pr_item->eng->partNo ;}?></td>
                                <td><?php if($item_count <= 1){ echo $p->pr_item->eng->partName ;}?></td>
                                <td><?php if(isset($p->pr_item->supplier_name->name)){if($item_count <= 1){echo $p->pr_item->supplier_name->name;}} ?></td>
                                <td><?php if($item_count <= 1){ echo $p->pr_item->eng->quality ;}?></td>
                                <td></td>
                                <td><?php if($item_count <= 1){ echo $p->pr_item->total ;}?></td>
                                <td><?php if($item_count <= 1){ echo $p->requester->name ;}?></td>
                                <td><?php if($item_count <= 1){ echo "Procurement";}?></td>
                                <td><?php if($item_count <= 1){ echo "Plan";}?></td>
                                <td><?php if($item_count <= 1){ echo $p->no_del;} ?></td>
                                <td><?= date('Y-m-d', strtotime($del->del_date)) ?></td>
                                <td><?= $del->del_qty ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php }}}}?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>