<div class="planner-from">
    <div class="container-fluid">
        <form action="<?php echo $this->Url->build(['controller'=>'pr','action'=>'submitAuto'])?>" method="post" class="planner-relative">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>PR 1 Submit (auto)</b></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Date <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p><?= $date ?></p>
                                <input type="hidden" name="date" value="<?= $date ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">SO NO <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $so_no ?></p>
                                <input type="hidden" name="so_no" value="<?= $so_no ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Delivery  Date <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $del_date ?></p>
                                <input type="hidden" name="delivery_date" value="<?= $del_date ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Description<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text text-uppercase"><?= $desc ?></p>
                                <input type="hidden" name="description" value="<?= $desc ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Customer Name<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $cus ?></p>
                                <input type="hidden" name="customer" value="<?= $cus ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">PR NO <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $pr_id ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Create by <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text">Azlin</p>
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
                    <?php $count=0; foreach ($pr_items as $pr): $count++;?>
                    <tr>
                        <td><?= $count ?></td>
                        <td><?= $pr['part_no'] ?></td>
                        <td><?= $pr['part_name'] ?></td>
                        <td><input type="hidden" name="supplier<?= $count ?>" value="<?= $pr['supplier'] ?>"><?= $pr['supplier'] ?></td>
                        <td><input type="hidden" name="price<?= $count ?>" value="<?= $pr['price'] ?>">$<?= $pr['price'] ?></td>
                        <td><input type="hidden" name="uom<?= $count ?>" value="<?= $pr['uom'] ?>"><?= $pr['uom'] ?></td>
                        <td><input type="hidden" name="category<?= $count ?>" value="<?= $pr['category'] ?>"><?= $pr['category'] ?></td>
                        <td><input type="hidden" name="req_quantity<?= $count ?>" value="<?= $pr['req_quantity'] ?>"><?= $pr['req_quantity'] ?></td>
                        <td><input type="hidden" name="stock_available<?= $count ?>" value="<?= $pr['stock_available'] ?>"><?= $pr['stock_available'] ?></td>
                        <td><input type="hidden" name="order_qty<?= $count?>" value="<?= $pr['order_qty'] ?>"><?= $pr['order_qty'] ?></td>
                        <td><input type="hidden" name="sub_total<?= $count?>" value="<?= $pr['sub_total'] ?>"><?= $pr['sub_total'] ?></td>
                        <td><input type="hidden" name="gst<?= $count?>" value="<?= $pr['gst'] ?>"><?= $pr['gst'] ?></td>
                        <td><input type="hidden" name="total<?= $count?>" value="<?= $pr['total'] ?>"><?= $pr['total'] ?></td>
                        <td></td>
                    </tr>
                        <input type="hidden" name="bom_part_id<?= $count?>" value="<?= $pr['bom_part_id']?>">
                        <input type="hidden" name="total" value="<?= $count ?>">
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="col-sm-offset-8 col-sm-4 col-xs-12">
            <div class="prepareted-by-csn">
                <button type="submit" class="button btn btn-info">Submit</button>
            </div>
        </div>
        </form>
    </div>
</div>