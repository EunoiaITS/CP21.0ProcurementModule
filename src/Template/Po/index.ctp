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
                            <th>Part No</th>
                            <th>Description</th>
                            <th>Supplier</th>
                            <th>QTY Request</th>
                            <th>Total</th>
                            <th>Create By</th>
                            <th>Department</th>
                            <th>Select</th>
                        </tr>
                        </thead>
                        <tbody class="csn-text-up">
                        <?php $count=0;foreach ($pr as $p): ?>
                            <?php if(!isset($p->po_exists)): $count++;?>
                                <?php $item_count = 0;foreach ($p->items as $i): $item_count++;?>
                                    <tr>
                                        <td><?php if($item_count == 1){echo $count;} ?></td>
                                        <td><input type="hidden" name="so_no<?= $count?>" value="<?= $p->so_no ?>"><?php if($item_count == 1){echo $p->so_no;} ?></td>
                                        <td><input type="hidden" name="delivery_date<?= $count?>" value="<?= date('Y-m-d',strtotime($p->del_date))?>"><?php if($item_count == 1) {echo date('Y-m-d',strtotime($p->del_date));}?></td>
                                        <td><input type="hidden" name="date<?= $count?>" value="<?= date('Y-m-d',strtotime($p->date))?>"><?php if($item_count == 1) {echo date('Y-m-d',strtotime($p->date));}?></td>
                                        <td><input type="hidden" name="pr_no<?= $count?>" value="<?= $p->id ?>"><?php if($item_count == 1) {echo 'PR'. $p->id;}?></td>
                                        <td><input type="hidden" name="part_no-<?= $count?>-<?= $item_count ?>" value="<?= $i->eng->partNo ?>"><?= $i->eng->partNo ?></td>
                                        <td><input type="hidden" name="part_name-<?= $count?>-<?= $item_count ?>" value="<?= $i->eng->partName ?>"><?= $i->eng->partName ?></td>
                                        <td><input type="hidden" name="supplier-<?= $count?>-<?= $item_count ?>" value="<?php if(isset($i->supplier_name->name)) echo $i->supplier_name->name; ?>"><?php if(isset($i->supplier_name->name)) echo $i->supplier_name->name; ?></td>
                                        <td><input type="hidden" name="order_qty-<?= $count?>-<?= $item_count ?>" value="<?= $i->order_qty ?>"><?= $i->order_qty ?></td>
                                        <td><input type="hidden" name="total-<?= $count?>-<?= $item_count ?>" value="<?= $i->total ?>">$ <?= $i->total ?></td>
                                        <td><?= $p->req->name ?></td>
                                        <td>Procurement</td>
                                        <td><?php if($item_count == 1): ?><input type="radio" name="radio_btn" value="<?= $count?>"  class="form-check-input" id="exampleCheck1"><?php endif;?></td>
                                    </tr>
                                    <input type="hidden" name="description<?= $count?>" value="<?= $p->model .' (' . $p->version .') '?>">
                                    <input type="hidden" name="customer<?= $count?>" value="<?= $p->customer ?>">
                                    <input type="hidden" name="sub_total-<?= $count?>-<?= $item_count ?>" value="<?= $i->sub_total ?>">
                                    <input type="hidden" name="gst-<?= $count?>-<?= $item_count ?>" value="<?= $i->gst ?>">
                                    <input type="hidden" name="stock_available-<?= $count?>-<?= $item_count ?>" value="<?= $i->stock ?>">
                                    <input type="hidden" name="req_quantity-<?= $count?>-<?= $item_count ?>" value="<?= $i->eng->quality ?>">
                                    <input type="hidden" name="category-<?= $count?>-<?= $item_count ?>" value="<?= $i->eng->category ?>">
                                    <input type="hidden" name="item_count-<?= $count?>" value="<?=$item_count ?>">
                                <?php endforeach;endif;endforeach;?>
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
</form>
