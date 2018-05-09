<div class="planner-from" xmlns="http://www.w3.org/1999/html">
    <div class="container-fluid">
        <form class="planner-relative" action="<?php echo $this->Url->build(['controller' => 'Pr', 'action' => 'submitManual']); ?>" method="post">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>PR Submit (manual)</b></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Date <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <input class="form-control" type="datetime" name="date" value="<?= $allData->date ?>" readonly>
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
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Customer Name<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $allData->cus_name ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Purchase Type <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $allData->purchase_type ?></p>
                                <input type="hidden" name="purchase_type" value="<?= $allData->purchase_type ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">PR NO <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $last_pr ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Create by <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text">Azlin</p>
                                <input type="hidden" name="created_by" value="1">
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
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Verify<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Approve<span class="planner-fright">:</span></p>
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
                        <th>Supplier 3</th>
                        <th>OUM</th>
                        <th>Price (RM)</th>
                        <th>Category</th>
                        <th>QTY Request</th>
                        <th>Stock Available</th>
                        <th>QTY Order</th>
                        <th>Sub Total</th>
                        <th>GST%</th>
                        <th>Total</th>
                        <th>Document</th>
                        <th>Remark</th>
                    </tr>
                    </thead>
                    <tbody class="csn-text-up">
                    <?php $count = 0; for($i = 1; $i <= sizeof($allData->parts); $i++): $count++; ?>
                    <tr>
                        <td><?= $count ?><input type="hidden" name="bom-id<?php echo $count; ?>" value="<?= $allData->parts[$i]['bom_id'] ?>"></td>
                        <td><?= $allData->parts[$i]['part_no'] ?></td>
                        <td><?= $allData->parts[$i]['part_name'] ?></td>
                        <td><?= $allData->parts[$i]['supplier_id'] ?><input type="hidden" name="supplier<?php echo $count; ?>" value="<?= $allData->parts[$i]['supplier_id'] ?>"></td>
                        <td><?= $allData->parts[$i]['uom'] ?></td>
                        <td>$ <p class="text-right"><?= $allData->parts[$i]['price'] ?></p></td>
                        <td><?= $allData->parts[$i]['category'] ?></td>
                        <td><?= $allData->parts[$i]['req_quantity'] ?></td>
                        <td><?= $allData->parts[$i]['stock'] ?></td>
                        <td><?= $allData->parts[$i]['qty_order'] ?><input type="hidden" name="order-qty<?php echo $count; ?>" value="<?= $allData->parts[$i]['qty_order'] ?>"></td>
                        <td><?= $allData->parts[$i]['subtotal'] ?><input type="hidden" name="subtotal<?php echo $count; ?>" value="<?= $allData->parts[$i]['subtotal'] ?>"></td>
                        <td><?= $allData->parts[$i]['gst'] ?><input type="hidden" name="gst<?php echo $count; ?>" value="<?= $allData->parts[$i]['gst'] ?>"></td>
                        <td><?= $allData->parts[$i]['total'] ?><input type="hidden" name="total<?php echo $count; ?>" value="<?= $allData->parts[$i]['total'] ?>"></td>
                        <td><a href="#">View</a></td>
                        <td><input type="hidden" name="sup-item-id<?php echo $count; ?>" value="<?= $allData->parts[$i]['sup_item_id'] ?>"></td>
                    </tr>
                    <?php endfor; ?>
                    <tr>
                        <td colspan="12"></td>
                        <td>265</td>
                        <td colspan="2"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="col-sm-offset-8 col-sm-4 col-xs-12">
            <div class="prepareted-by-csn">
                <input type="hidden" name="count" value="<?= $count ?>">
                <input type="hidden" name="status" value="requested">
                <button type="submit" class="button btn btn-info">Submit</button>
            </div>
        </div>
        </form>
    </div>
</div>