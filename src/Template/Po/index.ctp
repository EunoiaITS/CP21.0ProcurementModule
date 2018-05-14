<!--=========
     Create serial number form page
     ==============-->
<form action="<?php echo $this->Url->build(['controller'=>'Po','action'=>'generate'])?>" method="post">
    <div class="planner-from">
        <div class="container-fluid">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Purchase Order Request List</b></div>
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
                            <th>Delivery Date</th>
                            <th>PR Date</th>
                            <th>PR NO</th>
                            <th>Create By</th>
                            <th>Department</th>
                            <th>Select</th>
                        </tr>
                        </thead>
                        <tbody class="csn-text-up">
                        <?php $count=0;foreach ($pr as $p): ?>
                        <?php if(!isset($p->po_exists)): $count++;?>
                            <tr>
                                <td><?= $count ?></td>
                                <td><input type="hidden" name="so_no<?= $count?>" value="<?= $p->so_no ?>"><?= $p->so_no ?></td>
                                <td><input type="hidden" name="delivery_date<?= $count?>" value="<?= date('Y-m-d',strtotime($p->del_date))?>"><?= date('Y-m-d',strtotime($p->del_date))?></td>
                                <td><input type="hidden" name="date<?= $count?>" value="<?= date('Y-m-d',strtotime($p->date))?>"><?= date('Y-m-d',strtotime($p->date))?></td>
                                <td id="popup"><input type="hidden" name="pr_no<?= $count?>" value="<?= $p->id ?>"><span class="click-button" data-toggle="modal" data-target="#myModal<?= $count?>">PR <?= $p->id?></span></td>
                                <td></td>
                                <td></td>
                                <td><input type="radio" name="radio_btn" value="<?= $count?>"  class="form-check-input" id="exampleCheck1"></td>
                            </tr>
                            <input type="hidden" name="description<?= $count?>" value="<?= $p->model .' (' . $p->version .') '?>">
                            <input type="hidden" name="customer<?= $count?>" value="<?= $p->customer ?>">
                        <?php endif;endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-offset-8 col-sm-4 col-xs-12">
                <div class="prepareted-by-csn">
                    <button type="submit" class="button btn btn-info">Generate PO</button>
                </div>
            </div>
        </div>
    </div>

    <?php $count = 0;foreach ($pr as $p): ?>
    <?php if(!isset($p->po_exists)): $count++;?>
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
                                <td><input type="hidden" name="part_no-<?= $count?>-<?= $item_count ?>" value="<?= $i->eng->partNo ?>"><?= $i->eng->partNo ?></td>
                                <td><input type="hidden" name="part_name-<?= $count?>-<?= $item_count ?>" value="<?= $i->eng->partName ?>"><?= $i->eng->partName ?></td>
                                <td><input type="hidden" name="supplier-<?= $count?>-<?= $item_count ?>" value="<?php if(isset($i->supplier_name->name)) echo $i->supplier_name->name; ?>"><?php if(isset($i->supplier_name->name)) echo $i->supplier_name->name; ?></td>
                                <td><input type="hidden" name="order_qty-<?= $count?>-<?= $item_count ?>" value="<?= $i->order_qty ?>"><?= $i->order_qty ?></td>
                                <td><input type="hidden" name="total-<?= $count?>-<?= $item_count ?>" value="<?= $i->total ?>">$ <?= $i->total ?></td>
                            </tr>
                            <input type="hidden" name="sub_total-<?= $count?>-<?= $item_count ?>" value="<?= $i->sub_total ?>">
                            <input type="hidden" name="gst-<?= $count?>-<?= $item_count ?>" value="<?= $i->gst ?>">
                            <input type="hidden" name="stock_available-<?= $count?>-<?= $item_count ?>" value="<?= $i->stock ?>">
                            <input type="hidden" name="req_quantity-<?= $count?>-<?= $item_count ?>" value="<?= $i->eng->quality ?>">
                            <input type="hidden" name="category-<?= $count?>-<?= $item_count ?>" value="<?= $i->eng->category ?>">
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <input type="hidden" name="item_count-<?= $count?>" value="<?=$item_count ?>">
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</form>
<?php endif;endforeach;?>
