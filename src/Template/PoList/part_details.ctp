<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Procurement Order List Part Details</b></div>
                <form action="#" class="planner-relative">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Part No <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $result->part_no ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Part Name <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $result->part_name ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">UOM <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $result->supplier_item->uom ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Price<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $result->supplier_item->unit_price ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Supplier <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $result->supplier->name ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Supplier Address <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $result->supplier->address ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Contact Name <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $result->supplier->contact_name ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Contact No<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $result->supplier->contact_phone ?></p>
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
                        <th>SO No</th>
                        <th>Delivery Date</th>
                        <th>PR Date</th>
                        <th>PR No</th>
                        <th>PO Date</th>
                        <th>PO No</th>
                        <th>QTY Request</th>
                        <th>Extra 10%</th>
                        <th>Total</th>
                        <th>Create By</th>
                        <th>Department</th>
                    </tr>
                    </thead>
                    <tbody class="csn-text-up">
                    <?php $count = 0; foreach($items as $s): if(isset($s->pr)): $count++; ?>
                    <tr>
                        <td><?= $count ?></td>
                        <td><?= $s->pr->so_no ?></td>
                        <td><?= date('Y-m-d', strtotime($s->pr->del_date)) ?></td>
                        <td><?= date('Y-m-d', strtotime($s->pr->date)) ?></td>
                        <td>PR<?= $s->pr->id ?></td>
                        <td><?= date('Y-m-d', strtotime($s->po->date)) ?></td>
                        <td>PO<?= $s->po->id ?></td>
                        <td><?php if($s->order_qty !== 0 && $s->sub_total !== 0){ echo $s->sub_total/$s->order_qty; }else{ echo 0; } ?></td>
                        <td></td>
                        <td><?= $s->total ?></td>
                        <td>Azlin</td>
                        <td>Procurement</td>
                    </tr>
                    <?php endif; endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>