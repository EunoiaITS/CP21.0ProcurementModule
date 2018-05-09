<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Purchase Order Form</b></div>
                <form action="#" class="planner-relative">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Date <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p><?= date('Y-m-d', strtotime($pr->date)) ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">SO NO <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $pr->so_no ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Delivery  Date <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= date('Y-m-d', strtotime($pr->del_date)) ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Customer Name<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $pr->customer ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">PR NO <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $pr->id ?></p>
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
                                <p class="normal-text">Norbaizura</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            </form>
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
                        <th>Process Type</th>
                        <th>UOM</th>
                        <th>Price (RM)</th>
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
                    <?php $count = $total = 0; foreach($pr->items as $item): $count++; ?>
                    <tr>
                        <td><?= $count ?></td>
                        <td><?= $item->eng->partNo ?></td>
                        <td><?= $item->eng->partName ?></td>
                        <td><?php if(isset($item->supplier_name->name)) echo $item->supplier_name->name; ?></td>
                        <td><?= $item->eng->category ?></td>
                        <td><?php if(isset($item->supplier_item->uom)) echo $item->supplier_item->uom; ?></td>
                        <td><?php if($item->order_qty !== 0 && $item->sub_total !== 0){ echo $item->sub_total/$item->order_qty; }else{ echo 0; } ?></td>
                        <td><?= $item->eng->quality ?></td>
                        <td><?= $item->stock ?></td>
                        <td><?= $item->order_qty ?></td>
                        <td><?= $item->sub_total ?></td>
                        <td><?= $item->gst ?></td>
                        <td><?= $item->total ?></td>
                        <td><a href="#">View</a></td>
                        <td></td>
                    </tr>
                        <?php $total += $item->total; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="12"></td>
                        <td><?= $total ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="col-sm-offset-8 col-sm-4 col-xs-12">
            <div class="prepareted-by-csn">
                <button class="btn btn-info" data-toggle="modal" data-target="#myModal">Reject</button>
                <div class="button btn btn-info">Verify</div>
            </div>
        </div>
    </div>
</div>

<!--======
  Reject popup
  ===============================-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">Please Key In Remarks Here </h4>
            </div>
            <div class="modal-body">
                <form action="#">
                    <textarea name="" id="" class="popup-textarea" cols="20" rows="8"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Okay</button>
            </div>
        </div>
    </div>
</div>