<!--=========
      Create serial number form page
      ==============-->

<div class="planner-from" xmlns="http://www.w3.org/1999/html">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>PR Generate (manual)</b></div>
                <form action="#" class="planner-relative">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <label for="pr-date" class="planner-year">Date <span class="planner-fright">:</span></label>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <input type="text" class="form-control datepicker" id="pr-date" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">SO NO <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <input type="text" class="form-control" name="so_no" id="so-no">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Delivery  Date <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text" id="del-date"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Customer Name<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text" id="cus-name"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Purchase Type <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <select class="form-control">
                                    <option value="">Please select...</option>
                                    <option value="1">TYPE 1</option>
                                    <option value="2">TYPE 2</option>
                                    <option value="3">TYPE 3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">PR NO <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text">PR <?= $last_pr ?></p>
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
                        <th>Supplier 1</th>
                        <th>Price (RM)</th>
                        <th>Supplier 2</th>
                        <th>Price (RM)</th>
                        <th>Supplier 3</th>
                        <th>OUM</th>
                        <th>Price (RM)</th>
                        <th>Category</th>
                        <th>QTY Request</th>
                        <th>Stock Available</th>
                        <th>QTY Order</th>
                        <th>Select Supplier</th>
                        <th>Sub Total</th>
                        <th>GST%</th>
                        <th>Total</th>
                        <th>Document</th>
                        <th>Remark</th>
                    </tr>
                    </thead>
                    <tbody class="csn-text-up" id="parts-data">
                    </tbody>
                </table>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="col-sm-offset-8 col-sm-4 col-xs-12">
            <div class="prepareted-by-csn">
                <button class="btn btn-info">Add Item</button>
                <div class="button btn btn-info">Generate PR</div>
            </div>
        </div>
    </div>
</div>

<div class="clearfix">
<!--    --><?php //echo '<pre>'; print_r($sales); echo '</pre>'; ?>
</div>

<script>
    $(document).ready(function(){
        var so_no = 'input#so-no';
        var data = [<?php echo $so_no; ?>];
        var options = {
            source: data,
            minLength: 0
        };
        $(document).on('keydown.autocomplete', so_no, function() {
            $(this).autocomplete(options);
        });
        $(document).on('autocompleteselect', so_no, function(e, ui) {
            $('#del-date').text(ui.item.del_date);
            $('#cus-name').text(ui.item.cus_name);
            var parts = ui.item.parts;
            var html_table = '';
            if(parts.length !== 0){
                $.each(parts, function(i, e){
                    html_table += '<tr>'+
                    '<td>'+(i+1)+'</td>'+
                    '<td>'+ e.partNo+'</td>'+
                    '<td>'+ e.partName+'</td>'+
                    '<td>INDAH KABAR</td>'+
                    '<td>$ <p class="text-right">0.50</p></td>'+
                    '<td>PAN GLOBAL</td>'+
                    '<td>$ <p class="text-right">0.70</p></td>'+
                    '<td>CSC Malaysia</td>'+
                    '<td>PCS</td>'+
                    '<td>$ <p class="text-right">0.72</p></td>'+
                    '<td>'+ e.category+'</td>'+
                    '<td>'+ e.reqUantity+'</td>'+
                    '<td>'+ e.stockAvailable+'</td>'+
                    '<td><input type="number" class="form-control" name="qty_order'+(i+1)+'" value="'+Math.abs(e.reqUantity - e.stockAvailable)+'"></td>'+
                    '<td><select class="form-control" name="supplier"><option value="1">Supplier 1</option><option value="2">Supplier 2</option><option value="3">Supplier 3</option></select></td>'+
                    '<td>250.00</td>'+
                    '<td><input type="number" class="form-control" name="gst'+(i+1)+'" value="6"></td>'+
                    '<td>265.00</td>'+
                    '<td><a href="#">View</a></td>'+
                    '<td></td>'+
                    '</tr>';
                });
                html_table += '<tr>'+
                '<td colspan="17"></td>'+
                '<td>265</td>'+
                '<td colspan="2"></td>'+
                '</tr>';
            }
            $('#parts-data').html(html_table);
        });
    });
</script>