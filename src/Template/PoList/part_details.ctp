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
                                <p class="normal-text">PCS</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Price<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text">0.5</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Supplier <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text">Gulf</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Supplier Address <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text">Seksyen 16 Shah Alam</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Contact Name <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text">En Rafiee</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Contact No<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text">55432388</p>
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
                    <?php $count = 0; foreach($result->so as $r): $count++; ?>
                    <tr>
                        <td><?= $count ?></td>
                        <td><?= $r->pr->so_no ?></td>
                        <td>12-11-17</td>
                        <td><?= date('Y-m-d', strtotime($r->pr->date)) ?></td>
                        <td>PR<?= $r->pr->id ?></td>
                        <td><?= date('Y-m-d', strtotime($r->po->date)) ?></td>
                        <td>PO<?= $r->po->id ?></td>
                        <td><?= $result->qty_req ?></td>
                        <td>100</td>
                        <td><?= $result->total ?></td>
                        <td>Azlin</td>
                        <td>Procurement</td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>