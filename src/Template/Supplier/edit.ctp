<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Supplier Details</b></div>
                <form action="<?php echo $this->Url->build(['controller' => 'Supplier', 'action' => 'edit', $supplier->id]); ?>" class="planner-relative" id="sup-form" method="post" enctype="multipart/form-data">
                    <div class="supplier-section-information clearfix">
                        <h2 class="information-title">Genaral Information</h2>
                        <div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6 padding-left-0">
                                    <label  for="supplier-name" class="planner-year">Name <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-8 col-xs-6">
                                    <input type="text" name="name" class="form-control" id="supplier-name" value="<?= $supplier->name ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6 padding-left-0">
                                    <label  for="supplier-registration" class="planner-year">Registration No <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-8 col-xs-6">
                                    <input type="text" name="reg_no" class="form-control" id="supplier-registration" value="<?= $supplier->reg_no ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="card-status">Card Status</label>
                                <div class="radio">
                                    <label><input type="radio" name="card_status" value="Active" <?php if($supplier->card_status == 'Active'){echo 'checked';} ?>>Active</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="card_status" value="Inactive" <?php if($supplier->card_status == 'Inactive'){echo 'checked';} ?>>Inactive</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6">
                                    <label  for="supplier-email" class="planner-year">Email <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-9 col-xs-6">
                                    <input type="email" name="email" class="form-control" id="supplier-email" value="<?= $supplier->email ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6">
                                    <label  for="supplier-website" class="planner-year">Website <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-9 col-xs-6">
                                    <input type="text" name="website" class="form-control" id="supplier-website" value="<?= $supplier->website ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6">
                                    <label  for="supplier-contact" class="planner-year">Contact 1 <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-9 col-xs-6">
                                    <input type="text" name="contact_no_1" class="form-control" id="supplier-contact" value="<?= $supplier->contact_no_1 ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6">
                                    <label  for="supplier-contact-2" class="planner-year">Contact 2 <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-9 col-xs-6">
                                    <input type="text" name="contact_no_2" class="form-control" id="supplier-contact-2" value="<?= $supplier->contact_no_2 ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6">
                                    <label  for="supplier-fax" class="planner-year">Fax<span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-9 col-xs-6">
                                    <input type="text" name="fax" class="form-control" id="supplier-fax" value="<?= $supplier->fax ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- address -->
                    <div class="supplier-section-information clearfix">
                        <h2 class="information-title">Address</h2>
                        <div class="clearfix"></div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6 padding-left-0">
                                    <label  for="supplier-addressz" class="planner-year">Address <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-9 col-xs-6">
                                    <input type="text" name="address" class="form-control" id="supplier-addressz" value="<?= $supplier->address ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6 padding-left-0">
                                    <label  for="supplier-post-code" class="planner-year">Post Code <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-8 col-xs-6">
                                    <input type="text" name="postcode" class="form-control" id="supplier-post-code" value="<?= $supplier->postcode ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6 padding-left-0">
                                    <label  for="supplier-post-city" class="planner-year">City <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-8 col-xs-6">
                                    <input type="text" name="city" class="form-control" id="supplier-post-city" value="<?= $supplier->city ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6 padding-left-0">
                                    <label  for="supplier-state" class="planner-year">State <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-9 col-xs-6">
                                    <input type="text" name="state" class="form-control" id="supplier-state" value="<?= $supplier->state ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6 padding-left-0">
                                    <label  for="supplier-country" class="planner-year">Country <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-9 col-xs-6">
                                    <input type="text" name="country" class="form-control" id="supplier-country" value="<?= $supplier->country ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- contact person -->
                    <div class="supplier-section-information clearfix">
                        <h2 class="information-title">Contact Person</h2>
                        <div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6 padding-left-0">
                                    <label  for="contact-name" class="planner-year">Name <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-8 col-xs-6">
                                    <input type="text" name="contact_name" class="form-control" id="contact-name" value="<?= $supplier->contact_name ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6 padding-left-0">
                                    <label  for="contact-address" class="planner-year">Address <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-8 col-xs-6">
                                    <select name="caddress" required="required" id="contact-address" class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="same">Same as above</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6 padding-left-0">
                                    <label  for="contact-phone" class="planner-year">Phone <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-8 col-xs-6">
                                    <input type="number" name="contact_phone" class="form-control" id="contact-phone" value="<?= $supplier->contact_phone ?>">
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6 padding-left-0">
                                    <label  for="contact-email" class="planner-year">Email <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-9 col-xs-6">
                                    <input type="email" name="contact_email" class="form-control" id="contact-email" value="<?= $supplier->contact_email ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6 padding-left-0">
                                    <label  for="contact-fax" class="planner-year">Fax <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-9 col-xs-6">
                                    <input type="text" name="contact_fax" class="form-control" id="contact-fax" value="<?= $supplier->contact_fax ?>">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix" id="con-add"></div>
                    </div>
                    <div class="clearfix"></div>

                    <!-- Aditional Information -->
                    <div class="supplier-section-information clearfix">
                        <h2 class="information-title">Additional Information</h2>
                        <div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6 padding-left-0">
                                    <label  for="bank-name" class="planner-year">Name of Bank <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-8 col-xs-6">
                                    <input type="text" name="bank_name" class="form-control" id="bank-name" value="<?= $supplier->bank_name ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6 padding-left-0">
                                    <label  for="account-name" class="planner-year">Name of Account <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-8 col-xs-6">
                                    <input type="text" name="ac_name" class="form-control" id="account-name" value="<?= $supplier->ac_name ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6 padding-left-0">
                                    <label  for="account-no" class="planner-year">Account No <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-8 col-xs-6">
                                    <input type="number" name="ac_no" class="form-control" id="account-no" value="<?= $supplier->ac_no ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6 padding-left-0">
                                    <label  for="account-tel-no" class="planner-year">Bank Tel No <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-8 col-xs-6">
                                    <input type="number" name="bank_tel_no" class="form-control" id="account-tel-no" value="<?= $supplier->bank_tel_no ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6 padding-left-0">
                                    <label  for="account-fax-no" class="planner-year">Bank Fax No <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-8 col-xs-6">
                                    <input type="number" name="bank_fax_no" class="form-control" id="account-fax-no" value="<?= $supplier->bank_fax_no ?>">
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6 padding-left-0">
                                    <label  for="contact-terms" class="planner-year">Payment Terms <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-9 col-xs-6">
                                    <select name="payment_term" required="required" id="contact-terms" class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="30days" <?php if($supplier->payment_term == '30days'){echo 'selected';} ?>>30 days</option>
                                        <option value="fob" <?php if($supplier->payment_term == 'fob'){echo 'selected';} ?>>F.O.B</option>
                                        <option value="cnr" <?php if($supplier->payment_term == 'cnr'){echo 'selected';} ?>>CNR</option>
                                        <option value="cod" <?php if($supplier->payment_term == 'cod'){echo 'selected';} ?>>C.O.D</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6 padding-left-0">
                                    <label  for="contact-currency" class="planner-year">Currency <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-9 col-xs-6">
                                    <input type="text" name="currency" class="form-control" id="contact-currency" value="<?= $supplier->currency ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6 padding-left-0">
                                    <label  for="contact-currency" class="planner-year">Tax Code <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-9 col-xs-6">
                                    <select name="tax_code" required="required" id="contact-terms" class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="notext" <?php if($supplier->tax_code == 'notext'){echo 'selected';} ?>>No tax</option>
                                        <option value="jst" <?php if($supplier->tax_code == 'jst'){echo 'selected';} ?>>GST</option>
                                        <option value="foreign" <?php if($supplier->tax_code == 'foreign'){echo 'selected';} ?>>Foreign</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-6 padding-left-0">
                                    <label  for="contact-tax-id-no" class="planner-year">Tax ID No <span class="planner-fright">:</span></label>
                                </div>
                                <div class="col-sm-9 col-xs-6">
                                    <input type="text" name="tax_id" class="form-control" id="contact-tax-id-no" value="<?= $supplier->tax_id ?>">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!--Add Supplier item -->

                    <div class="supplier-section-information clearfix">
                        <h2 class="information-title">Add Supplier Item</h2>
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
                                    <th>Order/Ranking</th>
                                </tr>
                                </thead>
                                <tbody id="add-item-supplier">
                                <?php foreach($items as $item): ?>
                                    <tr>
                                        <td><?= $item->part_no ?></td>
                                        <td><?= $item->part_name ?></td>
                                        <td><?= $item->uom ?></td>
                                        <td><?= $item->unit_price ?></td>
                                        <td><?= $item->capability_m ?></td>
                                        <td><img src="<?php echo $this->request->webroot.$item->doc_file; ?>" alt=""></td>
                                        <td><?= $item->ranking ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="button btn btn-info" id="item-add" >Add</div>
                    </div>
                </form>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="clearfix"></div>
        <div class="col-sm-4 col-xs-12">
            <button type="submit" class="button btn btn-info supplier-item-submit" form="sup-form">Submit</button>
        </div>
    </div>
</div>

<!--================
        add item
        ========================-->
<script>
    $(document).ready(function(){
        $('#contact-address').on('change', function(e){
            e.preventDefault();
            var html_address = '';
            if($(this).val() === 'same'){
                var sup_address = $('#supplier-addressz').val();
                var sup_postcode = $('#supplier-post-code').val();
                var sup_city = $('#supplier-post-city').val();
                var sup_state = $('#supplier-state').val();
                var sup_country = $('#supplier-country').val();
                html_address = '<div class="col-sm-12">'+
                '<div class="form-group">'+
                '<div class="col-sm-3 col-xs-6 padding-left-0">'+
                '<label  for="contact_supplier-addressz" class="planner-year">Address <span class="planner-fright">:</span></label>'+
                '</div>'+
                '<div class="col-sm-9 col-xs-6">'+
                sup_address+'<input type="hidden" name="contact_address" value="'+sup_address+'" class="form-control" id="contact_supplier-addressz" required="required">'+
                '</div>'+
                '</div>'+
                '</div>'+
                '<div class="col-sm-6">'+
                '<div class="form-group">'+
                '<div class="col-sm-3 col-xs-6 padding-left-0">'+
                '<label  for="contact_supplier-post-code" class="planner-year">Post Code <span class="planner-fright">:</span></label>'+
                '</div>'+
                '<div class="col-sm-8 col-xs-6">'+
                sup_postcode+'<input type="hidden" name="contact_postcode" value="'+sup_postcode+'" class="form-control" id="contact_supplier-post-code" required="required">'+
                '</div>'+
                '</div>'+
                '<div class="form-group">'+
                '<div class="col-sm-3 col-xs-6 padding-left-0">'+
                '<label  for="contact_supplier-post-city" class="planner-year">City <span class="planner-fright">:</span></label>'+
                '</div>'+
                '<div class="col-sm-8 col-xs-6">'+
                sup_city+'<input type="hidden" name="contact_city" value="'+sup_city+'" class="form-control" id="contact_supplier-post-city" required="required">'+
                '</div>'+
                '</div>'+
                '</div>'+
                '<div class="col-sm-6">'+
                '<div class="form-group">'+
                '<div class="col-sm-3 col-xs-6 padding-left-0">'+
                '<label  for="contact_supplier-state" class="planner-year">State <span class="planner-fright">:</span></label>'+
                '</div>'+
                '<div class="col-sm-9 col-xs-6">'+
                sup_state+'<input type="hidden" name="contact_state" value="'+sup_state+'" class="form-control" id="contact_supplier-state" required="required">'+
                '</div>'+
                '</div>'+
                '<div class="form-group">'+
                '<div class="col-sm-3 col-xs-6 padding-left-0">'+
                '<label  for="contact_supplier-country" class="planner-year">Country <span class="planner-fright">:</span></label>'+
                '</div>'+
                '<div class="col-sm-9 col-xs-6">'+
                sup_country+'<input type="hidden" name="contact_country" value="'+sup_country+'" class="form-control" id="contact_supplier-country" required="required">'+
                '</div>'+
                '</div>'+
                '</div>';
            }else if($(this).val() === 'other'){
                html_address = '<div class="col-sm-12">'+
                '<div class="form-group">'+
                '<div class="col-sm-3 col-xs-6 padding-left-0">'+
                '<label  for="contact_supplier-addressz" class="planner-year">Address <span class="planner-fright">:</span></label>'+
                '</div>'+
                '<div class="col-sm-9 col-xs-6">'+
                '<input type="text" name="contact_address" class="form-control" id="contact_supplier-addressz" required="required">'+
                '</div>'+
                '</div>'+
                '</div>'+
                '<div class="col-sm-6">'+
                '<div class="form-group">'+
                '<div class="col-sm-3 col-xs-6 padding-left-0">'+
                '<label  for="contact_supplier-post-code" class="planner-year">Post Code <span class="planner-fright">:</span></label>'+
                '</div>'+
                '<div class="col-sm-8 col-xs-6">'+
                '<input type="text" name="contact_postcode" class="form-control" id="contact_supplier-post-code" required="required">'+
                '</div>'+
                '</div>'+
                '<div class="form-group">'+
                '<div class="col-sm-3 col-xs-6 padding-left-0">'+
                '<label  for="contact_supplier-post-city" class="planner-year">City <span class="planner-fright">:</span></label>'+
                '</div>'+
                '<div class="col-sm-8 col-xs-6">'+
                '<input type="text" name="contact_city" class="form-control" id="contact_supplier-post-city" required="required">'+
                '</div>'+
                '</div>'+
                '</div>'+
                '<div class="col-sm-6">'+
                '<div class="form-group">'+
                '<div class="col-sm-3 col-xs-6 padding-left-0">'+
                '<label  for="contact_supplier-state" class="planner-year">State <span class="planner-fright">:</span></label>'+
                '</div>'+
                '<div class="col-sm-9 col-xs-6">'+
                '<input type="text" name="contact_state" class="form-control" id="contact_supplier-state" required="required">'+
                '</div>'+
                '</div>'+
                '<div class="form-group">'+
                '<div class="col-sm-3 col-xs-6 padding-left-0">'+
                '<label  for="contact_supplier-country" class="planner-year">Country <span class="planner-fright">:</span></label>'+
                '</div>'+
                '<div class="col-sm-9 col-xs-6">'+
                '<input type="text" name="contact_country" class="form-control" id="contact_supplier-country" required="required">'+
                '</div>'+
                '</div>'+
                '</div>';
            }else{
                html_address = '';
            }
            $('#con-add').html(html_address);
        });
        var count = 0;
        $('#item-add').on('click', function(e){
            e.preventDefault();
            count++;
            var html_create ='<tr>'+
                '<td><input type="text" name="partno'+count+'" rel="'+count+'" class="form-control from-qr part-no" id="part-no-'+count+'"></td>'+
                '<td><input type="text" name="partname'+count+'" rel="'+count+'" class="form-control from-qr part-name" id="part-name-'+count+'"></td>'+
                '<td><input type="text" name="uom'+count+'" class="form-control from-qr" id="pr-item-code"></td>'+
                '<td><input type="number" name="unitprice'+count+'" class="form-control from-qr" id="pr-quantity"></td>'+
                '<td><input type="text" name="capamonth'+count+'" class="form-control from-qr" id="pr-quantity"></td>'+
                '<td><div class="file btn btn-sm btn-primary">'+
                '<div class="upload-icon"><i class="fa fa-cloud-upload" aria-hidden="true"></i></div><span>Upload Picture</span>'+
                '<input type="file" class="input-upload" name="file'+count+'">'+
                '</div>'+
                '</td>'+
                '<td>'+
                '<select name="ranking'+count+'" class="form-control from-qr" id="rankingid">'+
                '<option value="1">1</option>'+
                '<option value="2">2</option>'+
                '<option value="3">3</option>'+
                '<option value="4">4</option>'+
                '<option value="5">5</option>'+
                '<option value="6">6</option>'+
                '<option value="7">7</option>'+
                '<option value="8">8</option>'+
                '<option value="9">9</option>'+
                '<option value="10">10</option>'+
                '</select>'+
                '</td>'+
                '<tr>'+
                '<input type="hidden" name="total" value="'+count+'">';
            $('#add-item-supplier').append(html_create);
        });
        var part_nos = [<?php echo $part_nos; ?>];
        var part_names = [<?php echo $part_names; ?>];
        var part_no_options = {
            source: part_nos,
            minLength: 0
        };
        var part_name_options = {
            source: part_names,
            minLength: 0
        };
        var partRel = '';
        $(document).on('keydown.autocomplete', '.part-no', function(){
            $(this).autocomplete(part_no_options);
        });
        $(document).on('autocompleteselect', '.part-no', function(e, ui){
            partRel = $(this).attr('rel');
            $('#part-name-'+partRel).val(ui.item.partName);
        });
        $(document).on('keydown.autocomplete', '.part-name', function(){
            $(this).autocomplete(part_name_options);
        });
        $(document).on('autocompleteselect', '.part-name', function(e, ui){
            partRel = $(this).attr('rel');
            $('#part-no-'+partRel).val(ui.item.partNo);
        });
    });
</script>