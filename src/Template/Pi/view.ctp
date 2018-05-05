<!--=========
Create serial number form page
==============-->
<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Procurement Department Part Information</b></div>
                <?php foreach($all_data as $ad):?>
                <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Part No <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p><?= $ad->part_no ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Part Name<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $ad->part_name ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">UOM <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $ad->uom?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Material<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text text-uppercase">Material</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Price<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $ad->unit_price ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Stock  Balance<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?= $stock ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Min Stock<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text"><?php if(isset($min_stk)){echo $min_stk;}  ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>

        <div class="clearfix"></div>
        <!--============== Add drawing table area ===================-->
        <div class="planner-table table-responsive clearfix">
            <div class="col-sm-12">
                <h4 class="pro-search-4">Supplier Info</h4>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Supplier</th>
                        <th>Contact Name</th>
                        <th>Contact No</th>
                        <th>Price</th>
                        <th>Remark</th>
                    </tr>
                    </thead>
                    <tbody class="csn-text-up">
                    <?php $count = 0;foreach ($all_data as $adt): ?>
                        <?php foreach ($adt->sup_data as $s): $count++ ?>
                    <tr>
                        <td><?= $count ?></td>
                        <td><?= $s->name ?></td>
                        <td><?= $s->contact_name ?></td>
                        <td><?= $s->contact_phone ?></td>
                        <td><?= $adt->unit_price?></td>
                        <td></td>
                    </tr>
                    <?php endforeach;endforeach;?>
                    </tbody>
                </table>

                <h4 class="pro-search-4">Item Used</h4>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Model</th>
                        <th>Type</th>
                        <th>Version</th>
                        <th>QTY</th>
                        <th>Remark</th>
                    </tr>
                    </thead>
                    <tbody class="csn-text-up">
                    <?php $count=0;foreach ($model as $m): $count++;?>
                    <tr>
                        <td><?= $count ?></td>
                        <td><?= $m->model ?></td>
                        <td>1000kva</td>
                        <td></td>
                        <td><?= $m->zzt + $m->zzz + $m->zztt +$m->zzzt +$m->zzztt ?></td>
                        <td></td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
