<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>View Supplier Details</b></div>
                <div class="supplier-section-information clearfix">
                    <h2 class="information-title">Genaral Information</h2>
                    <div class="clearfix"></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Supplier ID <span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->id ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Supplier Name <span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->name ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Supplier Reg No <span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->reg_no ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Card Status<span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->card_status ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Email <span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->email ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Website<span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->website ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Contact 1<span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->contact_no_1 ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Contact 2 <span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->contact_no_2 ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Fax <span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->fax ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- address -->
                <div class="supplier-section-information clearfix">
                    <h2 class="information-title">Contact Person</h2>
                    <div class="clearfix"></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Name <span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->contact_name ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Address <span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->contact_address ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Email<span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->contact_email ?></p>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Fax<span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->contact_fax ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Mobile No<span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->contact_phone ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <!-- Aditional Information -->
                <div class="supplier-section-information clearfix">
                    <h2 class="information-title">Additional Information</h2>
                    <div class="clearfix"></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Name of Bank<span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->bank_name ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Name of A/C<span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->ac_name ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Account No<span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->ac_no ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Tel No<span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->bank_tel_no ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Fax<span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->bank_fax_no ?></p>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Payments Terms<span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->payment_term ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Currency<span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->currency ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Tax Code<span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->tax_code ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6 padding-left-0">
                                <span class="planner-year">Tax ID No<span class="planner-fright">:</span></span>
                            </div>
                            <div class="col-sm-8 col-xs-6">
                                <p><?= $supplier->tax_id ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!--Add Supplier item -->

                <div class="supplier-section-information clearfix">
                    <h2 class="information-title">Items</h2>
                    <div class="col-sm-11 col-xs-12 clearfix table-responsive">
                        <table class="table view-text-popup">
                            <thead>
                            <tr>
                                <th>Part No</th>
                                <th>Part Name</th>
                                <th>UOM</th>
                                <th>Unit Price</th>
                                <th>Capability Monthly</th>
                                <th>Picture</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($supplier->items as $item): ?>
                            <tr>
                                <td><?= $item->part_no ?></td>
                                <td><?= $item->part_name ?></td>
                                <td><?= $item->uom ?></td>
                                <td><?= $item->unit_price ?></td>
                                <td><?= $item->capability_m ?></td>
                                <td><img src="<?php echo $this->request->webroot.$item->doc_file; ?>" alt=""></td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                </form>
            </div>
        </div>

        <div class="clearfix"></div>
    </div>
</div>