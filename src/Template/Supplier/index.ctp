<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Supplier List</b></div>
            </div>

            <div class="clearfix"></div>
            <!--============== Add drawing table area ===================-->
            <div class="planner-table table-responsive clearfix">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Supplier ID</th>
                            <th>Name</th>
                            <th>Card Status</th>
                            <th>Contact Person</th>
                            <th>Bank</th>
                            <th>Supply Items</th>
                            <th>Currency</th>
                            <th>Bank</th>
                            <th>Payment Terms</th>
                            <th>Tax Code</th>
                            <th>Tax ID</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody class="csn-text-up">
                        <?php $count = 0; foreach($supplier as $s): $count++;?>
                        <tr>
                            <td><?= $count ?></td>
                            <td><a href="<?php echo $this->Url->build(['controller' => 'Supplier', 'action' => 'view', $s->id]); ?>"><?= $s->id ?></a></td>
                            <td><?= $s->name ?></td>
                            <td><?= $s->card_status ?></td>
                            <td><span class="name-popup" data-toggle="modal" data-target="#myModal<?= $s->id ?>"><?= $s->contact_name ?></span></td>
                            <td><span class="name-popup" data-toggle="modal" data-target="#myModal1<?= $s->id ?>"><?= $s->bank_name ?></span></td>
                            <td>
                                <button class="btn btn-info supplier-button-sec" data-toggle="modal" data-target="#myModal2<?= $s->id ?>">Add</button>
                                <button class="btn-info btn supplier-button-sec"  data-toggle="modal" data-target="#myModal3<?= $s->id ?>">View</button>
                            </td>
                            <td><?= $s->currency ?></td>
                            <td><?= $s->bank_name ?></td>
                            <td><?= $s->payment_term ?></td>
                            <td><?= $s->tax_code ?></td>
                            <td><?= $s->tax_id ?></td>
                            <td>
                                <a href="#"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                <a href="#" data-toggle="modal" data-target="#myModal4"><i class="fa fa-trash fa-2x"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="supplier-pagination">
                        <ul class="pagination">
                            <li><a href="#">&laquo;</a></li>
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">&raquo;</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

<?php foreach($supplier as $s): ?>
    <!--======
    contact person popup model
    ===============================-->
    <div class="modal fade" id="myModal<?= $s->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Contact Person for <span><?= $s->name ?></span> </h4>
                </div>
                <div class="modal-body supplier-modal-body">
                    <form action="#">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <div class="clearfix">
                                    <div class="col-sm-4 col-xs-6 padding-left-0">
                                        <span class="planner-year">Name <span class="planner-fright">:</span></span>
                                    </div>
                                    <div class="col-sm-8 col-xs-6">
                                        <p><?= $s->contact_name ?></p>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <div class="col-sm-4 col-xs-6 padding-left-0">
                                        <span class="planner-year">Phone <span class="planner-fright">:</span></span>
                                    </div>
                                    <div class="col-sm-8 col-xs-6">
                                        <p><?= $s->contact_phone ?></p>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <div class="col-sm-4 col-xs-6 padding-left-0">
                                        <span class="planner-year">Fax <span class="planner-fright">:</span></span>
                                    </div>
                                    <div class="col-sm-8 col-xs-6">
                                        <p><?= $s->contact_fax ?></p>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <div class="col-sm-4 col-xs-6 padding-left-0">
                                        <span class="planner-year">Email <span class="planner-fright">:</span></span>
                                    </div>
                                    <div class="col-sm-8 col-xs-6">
                                        <p><?= $s->contact_email ?></p>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <div class="col-sm-4 col-xs-6 padding-left-0">
                                        <span class="planner-year">Address <span class="planner-fright">:</span></span>
                                    </div>
                                    <div class="col-sm-8 col-xs-6">
                                        <p><?= $s->contact_address ?></p>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <div class="col-sm-4 col-xs-6 padding-left-0">
                                        <span class="planner-year">Post Code <span class="planner-fright">:</span></span>
                                    </div>
                                    <div class="col-sm-8 col-xs-6">
                                        <p><?= $s->contact_postcode ?></p>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <div class="col-sm-4 col-xs-6 padding-left-0">
                                        <span class="planner-year">City <span class="planner-fright">:</span></span>
                                    </div>
                                    <div class="col-sm-8 col-xs-6">
                                        <p><?= $s->contact_city ?></p>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <div class="col-sm-4 col-xs-6 padding-left-0">
                                        <span class="planner-year">State <span class="planner-fright">:</span></span>
                                    </div>
                                    <div class="col-sm-8 col-xs-6">
                                        <p><?= $s->contact_state ?></p>
                                    </div>
                                </div>

                                <div class="crearfix">
                                    <div class="col-sm-4 col-xs-6 padding-left-0">
                                        <span class="planner-year">Country <span class="planner-fright">:</span></span>
                                    </div>
                                    <div class="col-sm-8 col-xs-6">
                                        <p><?= $s->contact_country ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--======
   bank detais popup model
   ===============================-->
    <div class="modal fade" id="myModal1<?= $s->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Bank Details for <span><?= $s->name ?></span> </h4>
                </div>
                <div class="modal-body supplier-modal-body">
                    <form action="#">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <div class="clearfix">
                                    <div class="col-sm-6 col-xs-6 padding-left-0">
                                        <span class="planner-year">Bank Name <span class="planner-fright">:</span></span>
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <p><?= $s->bank_name ?></p>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <div class="col-sm-6 col-xs-6 padding-left-0">
                                        <span class="planner-year">Account Name <span class="planner-fright">:</span></span>
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <p><?= $s->ac_name ?></p>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <div class="col-sm-6 col-xs-6 padding-left-0">
                                        <span class="planner-year">Account No <span class="planner-fright">:</span></span>
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <p><?= $s->ac_no ?></p>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <div class="col-sm-6 col-xs-6 padding-left-0">
                                        <span class="planner-year">Bank Phone <span class="planner-fright">:</span></span>
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <p><?= $s->bank_tel_no ?></p>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <div class="col-sm-6 col-xs-6 padding-left-0">
                                        <span class="planner-year">Bank Fax <span class="planner-fright">:</span></span>
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <p><?= $s->bank_fax_no ?></p>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <div class="col-sm-6 col-xs-6 padding-left-0">
                                        <span class="planner-year">Payment terms<span class="planner-fright">:</span></span>
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <p><?= $s->payment_term ?></p>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <div class="col-sm-6 col-xs-6 padding-left-0">
                                        <span class="planner-year">Currency <span class="planner-fright">:</span></span>
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <p><?= $s->currency ?></p>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <div class="col-sm-6 col-xs-6 padding-left-0">
                                        <span class="planner-year">Tax Code <span class="planner-fright">:</span></span>
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <p><?= $s->tax_code ?></p>
                                    </div>
                                </div>

                                <div class="crearfix">
                                    <div class="col-sm-6 col-xs-6 padding-left-0">
                                        <span class="planner-year">Tax ID No <span class="planner-fright">:</span></span>
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <p><?= $s->tax_id ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!--======
  Add supplier items
   ===============================-->
    <div class="modal fade" id="myModal2<?= $s->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
        <div class="modal-dialog add-supplier-popup" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Add Supplier items for <span><?= $s->name ?></span> </h4>
                </div>
                <form action="<?php echo $this->Url->build(['controller' => 'Supplier', 'action' => 'index']); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body supplier-modal-body">
                    <div class="col-sm-11 col-xs-12 clearfix table-responsive">
                        <table class="table simple-table-supplier">
                            <thead>
                            <tr>
                                <th>Part No</th>
                                <th>Part Name</th>
                                <th>UOM</th>
                                <th>Unit Price</th>
                                <th>Capability Monthly</th>
                                <th>Picture</th>
                                <th>Ranking</th>
                            </tr>
                            </thead>
                            <tbody id="add-item-supplier<?= $s->id ?>">
                            <tr>
                                <td><input type="text" class="form-control from-qr" id="pr-item-name" name="partno1"></td>
                                <td><input type="text" class="form-control from-qr" id="pr-item-name" name="partname1"></td>
                                <td><input type="text" class="form-control from-qr" id="pr-item-code" name="uom1"></td>
                                <td><input type="number" class="form-control from-qr" id="pr-quantity" name="unitprice1"></td>
                                <td><input type="text" class="form-control from-qr" id="pr-quantity" name="capamonth1"></td>
                                <td><div class="file btn btn-sm btn-primary">
                                        <div class="upload-icon">
                                            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                        </div>
                                        <span>Upload Picture</span>
                                        <input type="file" class="input-upload" name="file1">
                                    </div>
                                </td>
                                <td>
                                    <select class="form-control form-qr" name="ranking1">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </td>
                            </tr>
                            <input type="hidden" name="total" value="1">
                            <input type="hidden" name="supplier_id" value="<?= $s->id ?>">
                            </tbody>
                        </table>
                    </div>
                    <div class="button btn btn-info add-items" id="item-add" rel="<?= $s->id ?>">Add</div>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!--======
    View items abc
    ===============================-->
    <div class="modal fade" id="myModal3<?= $s->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
        <div class="modal-dialog add-supplier-popup" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Items for <span><?= $s->name ?></span> </h4>
                </div>
                <div class="modal-body supplier-modal-body">
                    <div class="col-sm-11 col-xs-12 clearfix table-responsive">
                        <table class="table simple-table-supplier view-text-popup">
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
                            <?php if(isset($s->items)): foreach($s->items as $item): ?>
                            <tr>
                                <td><?= $item->part_no ?></td>
                                <td><?= $item->part_name ?></td>
                                <td><?= $item->uom ?></td>
                                <td><?= $item->unit_price ?></td>
                                <td><?= $item->capability_m ?></td>
                                <td><img class="action-button" src="<?php echo $this->request->webroot.$item->doc_file; ?>" alt=""></td>
                            </tr>
                            <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body supplier-modal-body">
                <p class="text-center">Are you sure you want to delete <span>ABC</span> ?</p>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Yes</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">No</button>
            </div>
        </div>
    </div>
</div>

    <!--================
        add item popup
        ========================-->
    <script>
        $(document).ready(function(){
            var count = 1;
            $('.add-items').on('click', function(e){
                e.preventDefault();
                var id = $(this).attr('rel');
                count++;
                var html_create ='<tr>'+
                    '<td><input type="text" name="partno'+count+'" class="form-control from-qr" id="pr-item-name"></td>'+
                    '<td><input type="text" name="partname'+count+'" class="form-control from-qr" id="pr-item-name"></td>'+
                    '<td><input type="text" name="uom'+count+'" class="form-control from-qr" id="pr-item-code"></td>'+
                    '<td><input type="number" name="unitprice'+count+'" class="form-control from-qr" id="pr-quantity"></td>'+
                    '<td><input type="text" name="capamonth'+count+'" class="form-control from-qr" id="pr-quantity"></td>'+
                    '<td><div class="file btn btn-sm btn-primary">'+
                    '<div class="upload-icon"><i class="fa fa-cloud-upload" aria-hidden="true"></i></div><span>Upload Picture</span>'+
                    '<input type="file" class="input-upload" name="file'+count+'">'+
                    '</div>'+
                    '</td>'+
                    '<td><select class="form-control form-qr" name="ranking'+count+'">' +
                    '<option value="1">1</option>' +
                    '<option value="2">2</option>' +
                    '<option value="3">3</option>' +
                    '<option value="4">4</option>' +
                    '<option value="5">5</option>' +
                    '<option value="6">6</option>' +
                    '<option value="7">7</option>' +
                    '<option value="8">8</option>' +
                    '<option value="9">9</option>' +
                    '<option value="10">10</option>' +
                    '</select></td>'+
                    '<tr>'+
                    '<input type="hidden" name="total" value="'+count+'">';
                $('#add-item-supplier'+id).append(html_create);
            });
        });
    </script>