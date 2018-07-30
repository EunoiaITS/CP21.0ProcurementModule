<div class="planner-from">
    <div class="container-fluid">
        <form action="<?php echo $this->Url->build(['controller'=>'pr','action'=>'submitAuto'])?>" method="post" class="planner-relative">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Purchase Requisition Form</b></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Date <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p><?= $allData->date ?></p>
                                <input type="hidden" name="date" value="<?= $allData->date ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">SO NO <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $allData->so_no ?></p>
                                <input type="hidden" name="so_no" value="<?= $allData->so_no ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Delivery  Date <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $allData->del_date ?></p>
                                <input type="hidden" name="delivery_date" value="<?= $allData->del_date ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Description<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text text-uppercase"><?= $allData->desc ?></p>
                                <input type="hidden" name="description" value="<?= $allData->desc ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Customer Name<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $allData->cus ?></p>
                                <input type="hidden" name="customer" value="<?= $allData->cus ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">PR NO <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $allData->pr_id ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Create by <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $user_pic ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Department <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text">Procurement</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Section<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"></p>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <!--============== Add drawing table area ===================-->
        <div class="planner-table table-responsive clearfix">
            <div class="col-sm-12">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Part No</th>
                        <th>Description</th>
                        <th>Supplier</th>
                        <th>Price (RM)</th>
                        <th>UOM</th>
                        <th>Category</th>
                        <th>QTY Request</th>
                        <th>Stock Available</th>
                        <th>QTY Order</th>
                        <th>Sub Total</th>
                        <th>GST%</th>
                        <th>Total</th>
                        <th>Remark</th>
                    </tr>
                    </thead>
                    <tbody class="csn-text-up">
                    <?php $count = 0; for($i = 1; $i <= $allData->counter; $i++):?>
                    <?php if(in_array($i,$allData->checked)): $count++; ?>
                    <tr>
                        <td><?= $count ?></td>
                        <td><?= $allData->parts[$i]['part_no'] ?></td>
                        <td><?= $allData->parts[$i]['part_name'] ?></td>
                        <td><?php if(isset($allData->parts[$i]['supplier_det']->name)) echo $allData->parts[$i]['supplier_det']->name; ?><input type="hidden" name="supplier<?= $i ?>" value="<?= $allData->parts[$i]['supplier_id'] ?>"></td>
                        <td><?= $allData->parts[$i]['price'] ?></td>
                        <td><?= $allData->parts[$i]['uom'] ?></td>
                        <td><?= $allData->parts[$i]['category'] ?></td>
                        <td><?= $allData->parts[$i]['req_quantity'] ?></td>
                        <td><?= $allData->parts[$i]['stock'] ?></td>
                        <td><input type="hidden" name="order_qty<?= $i ?>" value="<?= $allData->parts[$i]['order_qty'] ?>"><?= $allData->parts[$i]['order_qty'] ?></td>
                        <td><input type="hidden" name="sub_total<?= $i ?>" value="<?= $allData->parts[$i]['sub_total'] ?>"><?= $allData->parts[$i]['sub_total'] ?></td>
                        <td><input type="hidden" name="gst<?= $i ?>" value="<?= $allData->parts[$i]['gst'] ?>"><?= $allData->parts[$i]['gst'] ?></td>
                        <td><input type="hidden" name="total<?= $i ?>" value="<?= $allData->parts[$i]['total'] ?>"><?= $allData->parts[$i]['total'] ?></td>
                        <td><input type="hidden" name="bom_part_id<?= $i ?>" value="<?= $allData->parts[$i]['bom_part_id'] ?>">
                            <input type="hidden" name="sup-item-id<?= $i ?>" value="<?= $allData->parts[$i]['sup_item_id'] ?>">
                            <input type="hidden" name="selected<?= $i ?>" value="<?= $i ?>">
                        </td>
                    </tr>
                        <?php endif;endfor;?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="col-sm-offset-8 col-sm-4 col-xs-12">
            <div class="prepareted-by-csn">
                <input type="hidden" name="created_by" value="<?= $user_id ?>">
                <input type="hidden" name="total" value="<?= $allData->counter ?>">
                <button type="submit" class="button btn btn-info">Submit</button>
            </div>
        </div>
        </form>
    </div>
</div>