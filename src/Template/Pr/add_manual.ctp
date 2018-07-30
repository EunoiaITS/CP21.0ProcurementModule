<!--=========
<!--=========
      Create serial number form page
      ==============-->

<div class="planner-from" xmlns="http://www.w3.org/1999/html">
    <div class="container-fluid">
        <form action="<?php echo $this->Url->build(['controller' => 'Pr', 'action' => 'generateManual']); ?>" class="planner-relative" method="post">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Purchase Requisition Form Manual</b></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <label for="pr-date" class="planner-year">Date <span class="planner-fright">:</span></label>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <input name="date" type="text" class="form-control datepicker" id="pr-date" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">SO NO <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <input name="so_no" type="text" class="form-control" name="so_no" id="so-no">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Delivery  Date <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text" id="del-date"></p>
                                <input type="hidden" name="del-date" id="del-date-in">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Customer Name<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p class="normal-text" id="cus-name"></p>
                                <input type="hidden" name="cus-name" id="cus-name-in">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Purchase Type <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <select class="form-control" name="purchase_type">
                                    <option value="">Please select...</option>
                                    <option value="1">Production</option>
                                    <option value="2">Engineering</option>
                                    <option value="3">Others</option>
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
                                <p id="created-by" class="normal-text"><?= $user_pic ?></p>
                                <input id="created-name" type="hidden" name="created_by" value="<?= $user_id ?>">
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
            </div>
        </div>

        <div class="clearfix">
        </div>
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
                        <th>UOM</th>
                        <th>Price (RM)</th>
                        <th>Category</th>
                        <th>QTY Request</th>
                        <th>Stock Available</th>
                        <th>QTY Order</th>
                        <th>Select Supplier</th>
                        <th>Sub Total</th>
                        <th>GST%</th>
                        <th>GST amount</th>
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

        <div class="clearfix">
            <input type="hidden" name="total-items" id="total-items" value="">
        </div>
        <div class="col-sm-offset-8 col-sm-4 col-xs-12">
            <div class="prepareted-by-csn">
                <button type="button" class="btn btn-info" id="add-items">Add Item</button>
                <button type="submit" class="button btn btn-info">Generate PR</button>
            </div>
        </div>
        </form>
    </div>
</div>

<div class="clearfix">
<!--    --><?php //echo '<pre>'; print_r($sales); echo '</pre>'; ?>
</div>

<script>
    $(document).ready(function(){
        var def_gst = 0;
        var counter = 0;
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
            $('#parts-data').empty();
            $('#del-date').text(ui.item.del_date);
            $('#cus-name').text(ui.item.cus_name);
            $('#del-date-in').val(ui.item.del_date);
            $('#cus-name-in').val(ui.item.cus_name);
            var parts = ui.item.parts;
            var html_table = '';
            counter = 0;
            if(parts.length !== 0){
                $.each(parts, function(i, e){
                    counter++;
                    var order_qty = e.reqQuantity - e.stockAvailable;
                    if(order_qty < 0){
                        order_qty = 0;
                    }
                    html_table += '<tr>'+
                    '<td>'+counter+'<input type="hidden" name="bom-id-'+counter+'" value="'+ e.bomId+'"></td>'+
                    '<td>'+ e.partNo+'<input type="hidden" name="part-no-'+counter+'" value="'+ e.partNo+'"></td>'+
                    '<td>'+ e.partName+'<input type="hidden" name="part-name-'+counter+'" value="'+ e.partName+'"></td>'+
                    '<td>'+ e.supplier1+'<input type="hidden" name="supplier-1-'+counter+'" value="'+ e.supplier1id+'"><input type="hidden" name="sup-item-1-'+counter+'" value="'+ e.supItemId1+'"></td>'+
                    '<td><p class="text-right" id="price-1'+counter+'">'+ e.price1+'</p><input type="hidden" name="price-1-'+counter+'" value="'+ e.price1+'"></td>'+
                    '<td>'+ e.supplier2+'<input type="hidden" name="supplier-2-'+counter+'" value="'+ e.supplier2id+'"><input type="hidden" name="sup-item-2-'+counter+'" value="'+ e.supItemId2+'"></td>'+
                    '<td><p class="text-right" id="price-2'+counter+'">'+ e.price2+'</p><input type="hidden" name="price-2-'+counter+'" value="'+ e.price2+'"></td>'+
                    '<td>'+ e.supplier3+'<input type="hidden" name="supplier-3-'+counter+'" value="'+ e.supplier3id+'"><input type="hidden" name="sup-item-3-'+counter+'" value="'+ e.supItemId3+'"></td>'+
                    '<td>'+ e.uom+'<input type="hidden" name="uom-'+counter+'" value="'+ e.uom+'"></td>'+
                    '<td><p class="text-right" id="price-3'+counter+'">'+ e.price3+'</p><input type="hidden" name="price-3-'+counter+'" value="'+ e.price3+'"></td>'+
                    '<td>'+ e.category+'<input type="hidden" name="category-'+counter+'" value="'+ e.category+'"></td>'+
                    '<td>'+ e.reqQuantity+'<input type="hidden" name="req-quantity-'+counter+'" value="'+ e.reqQuantity+'"></td>'+
                    '<td>'+ e.stockAvailable+'<input type="hidden" name="stock-'+counter+'" value="'+ e.stockAvailable+'"></td>'+
                    '<td><input type="number" class="form-control qty-order" id="qty'+counter+'" rel="'+counter+'" name="qty_order'+counter+'" value="'+order_qty+'"></td>'+
                    '<td><select class="form-control all-supp" id="supp'+counter+'" rel="'+counter+'" name="supplier'+counter+'"><option value="1">Supplier 1</option><option value="2">Supplier 2</option><option value="3">Supplier 3</option></select></td>'+
                    '<td><p id="sub-total-text'+counter+'">'+(order_qty * e.price1)+'</p><input type="hidden" name="subtotal'+counter+'" id="subtotal'+counter+'" value="'+(order_qty * e.price1)+'"></td>'+
                    '<td><input type="number" class="form-control gst" id="gst'+counter+'" rel="'+counter+'" name="gst'+counter+'" value="'+def_gst+'"></td>'+
                    '<td><p id="gst-amount'+counter+'">'+((order_qty * e.price1) * def_gst)/100 +'</p></td>'+
                    '<td><p id="total-text'+counter+'">'+(((order_qty * e.price1) * def_gst)/100 + (order_qty * e.price1))+'</p><input type="hidden" name="total'+counter+'" id="total'+counter+'" value="'+(((order_qty * e.price1) * def_gst)/100 + (order_qty * e.price1))+'"></td>'+
                    '<td><a href="#">View</a></td>'+
                    '<td></td>'+
                    '</tr>';
                });
            }
            if($('#append-here').length == 0){
                html_table += '<tr id="append-here">'+
                '<td colspan="18"></td>'+
                '<td><p id="final-total"></p></td>'+
                '<td colspan="2"></td>'+
                '</tr>';
                $('#parts-data').append(html_table);
                var finalTotal = 0;
                for(k = 1; k <= counter; k++){
                    finalTotal += parseInt($('#total-text'+k).text());
                }
                $('#final-total').text(finalTotal);
            }else{
                $('#append-here').before(html_table);
                var finalTotal = 0;
                for(k = 1; k <= counter; k++){
                    finalTotal += parseInt($('#total-text'+k).text());
                }
                $('#final-total').text(finalTotal);
            }
            $('.all-supp').on('change', function(e){
                e.preventDefault();
                var relate = $(this).attr('rel');
                var price = 0;
                var selectedSup = $('#supp'+relate+' :selected').val();
                if(selectedSup === '2'){
                    price = $('#price-2'+relate).text();
                }else if(selectedSup === '3'){
                    price = $('#price-3'+relate).text();
                }else{
                    price = $('#price-1'+relate).text();
                }
                var qty_order = $('#qty'+relate).val();
                var gst = $('#gst'+relate).val();
                $('#subtotal'+relate).val(price*qty_order);
                $('#total'+relate).val((price*qty_order)+(((price*qty_order)*gst)/100));
                $('#sub-total-text'+relate).text(price*qty_order);
                $('#gst-amount'+relate).text(((price*qty_order)*gst)/100);
                $('#total-text'+relate).text((price*qty_order)+(((price*qty_order)*gst)/100));
                var finalTotal = 0;
                for(k = 1; k <= counter; k++){
                    finalTotal += parseInt($('#total-text'+k).text());
                }
                $('#final-total').text(finalTotal);
            });
            $('.qty-order').on('change', function(e){
                e.preventDefault();
                var relate = $(this).attr('rel');
                var price = 0;
                var selectedSup = $('#supp'+relate+' :selected').val();
                if(selectedSup === '2'){
                    price = $('#price-2'+relate).text();
                }else if(selectedSup === '3'){
                    price = $('#price-3'+relate).text();
                }else{
                    price = $('#price-1'+relate).text();
                }
                var qty_order = $('#qty'+relate).val();
                var gst = $('#gst'+relate).val();
                $('#subtotal'+relate).val(price*qty_order);
                $('#total'+relate).val((price*qty_order)+(((price*qty_order)*gst)/100));
                $('#sub-total-text'+relate).text(price*qty_order);
                $('#gst-amount'+relate).text(((price*qty_order)*gst)/100);
                $('#total-text'+relate).text((price*qty_order)+(((price*qty_order)*gst)/100));
                var finalTotal = 0;
                for(k = 1; k <= counter; k++){
                    finalTotal += parseInt($('#total-text'+k).text());
                }
                $('#final-total').text(finalTotal);
            });
            $('.gst').on('change', function(e){
                e.preventDefault();
                var relate = $(this).attr('rel');
                var price = 0;
                var selectedSup = $('#supp'+relate+' :selected').val();
                if(selectedSup === '2'){
                    price = $('#price-2'+relate).text();
                }else if(selectedSup === '3'){
                    price = $('#price-3'+relate).text();
                }else{
                    price = $('#price-1'+relate).text();
                }
                var qty_order = $('#qty'+relate).val();
                var gst = $('#gst'+relate).val();
                $('#subtotal'+relate).val(price*qty_order);
                $('#total'+relate).val((price*qty_order)+(((price*qty_order)*gst)/100));
                $('#sub-total-text'+relate).text(price*qty_order);
                $('#gst-amount'+relate).text(((price*qty_order)*gst)/100);
                $('#total-text'+relate).text((price*qty_order)+(((price*qty_order)*gst)/100));
                var finalTotal = 0;
                for(k = 1; k <= counter; k++){
                    finalTotal += parseInt($('#total-text'+k).text());
                }
                $('#final-total').text(finalTotal);
            });
            $('#total-items').val(counter);
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
        $('#add-items').on('click', function(e){
            e.preventDefault();
            counter++;
            var add_table = '<tr>'+
                '<td>'+counter+'<input type="hidden" name="bom-id-'+counter+'" id="bom-id-'+counter+'"></td>'+
                '<td><input type="text" rel="'+counter+'" class="form-control part-no" id="part-nos'+counter+'" name="part-no-'+counter+'"></td>'+
                '<td><input type="text" rel="'+counter+'" class="form-control part-name" id="part-names'+counter+'" name="part-name-'+counter+'"></td>'+
                '<td><span id="supp-1-'+counter+'"></span><input type="hidden" name="supplier-1-'+counter+'" id="supplier-1-'+counter+'"><input type="hidden" name="sup-item-1-'+counter+'" id="sup-item-1-'+counter+'"></td>'+
                '<td><p class="text-right" id="price-1'+counter+'"></p><input type="hidden" name="price-1-'+counter+'" id="price-1-'+counter+'"></td>'+
                '<td><span id="supp-2-'+counter+'"></span><input type="hidden" name="supplier-2-'+counter+'" id="supplier-2-'+counter+'"><input type="hidden" name="sup-item-2-'+counter+'" id="sup-item-2-'+counter+'"></td>'+
                '<td><p class="text-right" id="price-2'+counter+'"></p><input type="hidden" name="price-2-'+counter+'" id="price-2-'+counter+'"></td>'+
                '<td><span id="supp-3-'+counter+'"></span><input type="hidden" name="supplier-3-'+counter+'" id="supplier-3-'+counter+'"><input type="hidden" name="sup-item-3-'+counter+'" id="sup-item-3-'+counter+'"></td>'+
                '<td><span id="uom-'+counter+'"></span><input type="hidden" name="uom-'+counter+'" id="uom-in-'+counter+'"></td>'+
                '<td><p class="text-right" id="price-3'+counter+'"></p><input type="hidden" name="price-3-'+counter+'" id="price-3-'+counter+'"></td>'+
                '<td><span id="cat-'+counter+'"></span><input type="hidden" name="category-'+counter+'" id="cat-in-'+counter+'"></td>'+
                '<td><span class="hidden" id="qty-req-'+counter+'"></span><input type="number" class="form-control req-quantity" rel="'+counter+'" name="req-quantity-'+counter+'" id="qty-req-in-'+counter+'" rel="'+counter+'"></td>'+
                '<td><span id="stock-'+counter+'"></span><input type="hidden" name="stock-'+counter+'" id="stock-in-'+counter+'"></td>'+
                '<td><input type="number" class="form-control qty-order" id="qty'+counter+'" name="qty_order'+counter+'" rel="'+counter+'" value=""></td>'+
                '<td><select class="form-control all-supp" id="supp'+counter+'" rel="'+counter+'" name="supplier'+counter+'"><option value="1">Supplier 1</option><option value="2">Supplier 2</option><option value="3">Supplier 3</option></select></td>'+
                '<td><p id="sub-total-text'+counter+'"></p><input type="hidden" name="subtotal'+counter+'" id="subtotal'+counter+'"></td>'+
                '<td><input type="number" class="form-control gst" id="gst'+counter+'" name="gst'+counter+'" rel="'+counter+'" value="'+def_gst+'"></td>'+
                '<td><p id="gst-amount'+counter+'"></p></td>'+
                '<td><p id="total-text'+counter+'"></p><input type="hidden" name="total'+counter+'" id="total'+counter+'"></td>'+
                '<td><a href="#">View</a></td>'+
                '<td></td>'+
                '</tr>';
            if($('#append-here').length == 0){
                add_table += '<tr id="append-here">'+
                '<td colspan="18"></td>'+
                '<td>265</td>'+
                '<td colspan="2"></td>'+
                '</tr>';
                $('#parts-data').append(add_table);
                $('input.part-no').on('click', function(e){
                    e.preventDefault();
                    partRel = $(this).attr('rel');
                });
                $('input.part-name').on('click', function(e){
                    e.preventDefault();
                    partRel = $(this).attr('rel');
                });
            }else{
                $('#append-here').before(add_table);
                $('input.part-no').on('click', function(e){
                    e.preventDefault();
                    partRel = $(this).attr('rel');
                });
                $('input.part-name').on('click', function(e){
                    e.preventDefault();
                    partRel = $(this).attr('rel');
                });
            }
            $('#total-items').val(counter);
            $('.req-quantity').on('change', function(e){
                e.preventDefault();
                var relate = $(this).attr('rel');
                var price = 0;
                var selectedSup = $('#supp'+relate+' :selected').val();
                if(selectedSup === '2'){
                    price = $('#price-2'+relate).text();
                }else if(selectedSup === '3'){
                    price = $('#price-3'+relate).text();
                }else{
                    price = $('#price-1'+relate).text();
                }
                var stockIn = $('#stock-in-'+relate).val();
                var qty_order = 0;
                if(($(this).val() - stockIn) <= 0){
                    qty_order = 0;
                }else{
                    qty_order = $(this).val() - stockIn;
                }
                $('#qty'+relate).val(qty_order);
                var gst = $('#gst'+relate).val();
                $('#subtotal'+relate).val(price*qty_order);
                $('#total'+relate).val((price*qty_order)+(((price*qty_order)*gst)/100));
                $('#sub-total-text'+relate).text(price*qty_order);
                $('#gst-amount'+relate).text(((price*qty_order)*gst)/100);
                $('#total-text'+relate).text((price*qty_order)+(((price*qty_order)*gst)/100));
                var finalTotal = 0;
                for(k = 1; k <= counter; k++){
                    finalTotal += parseInt($('#total-text'+k).text());
                }
                $('#final-total').text(finalTotal);
            });
            $('.all-supp').on('change', function(e){
                e.preventDefault();
                var relate = $(this).attr('rel');
                var price = 0;
                var selectedSup = $('#supp'+relate+' :selected').val();
                if(selectedSup === '2'){
                    price = $('#price-2'+relate).text();
                }else if(selectedSup === '3'){
                    price = $('#price-3'+relate).text();
                }else{
                    price = $('#price-1'+relate).text();
                }
                var qty_order = $('#qty'+relate).val();
                var gst = $('#gst'+relate).val();
                $('#subtotal'+relate).val(price*qty_order);
                $('#total'+relate).val((price*qty_order)+(((price*qty_order)*gst)/100));
                $('#sub-total-text'+relate).text(price*qty_order);
                $('#gst-amount'+relate).text(((price*qty_order)*gst)/100);
                $('#total-text'+relate).text((price*qty_order)+(((price*qty_order)*gst)/100));
                var finalTotal = 0;
                for(k = 1; k <= counter; k++){
                    finalTotal += parseInt($('#total-text'+k).text());
                }
                $('#final-total').text(finalTotal);
            });
            $('.qty-order').on('change', function(e){
                e.preventDefault();
                var relate = $(this).attr('rel');
                var price = 0;
                var selectedSup = $('#supp'+relate+' :selected').val();
                if(selectedSup === '2'){
                    price = $('#price-2'+relate).text();
                }else if(selectedSup === '3'){
                    price = $('#price-3'+relate).text();
                }else{
                    price = $('#price-1'+relate).text();
                }
                var qty_order = $('#qty'+relate).val();
                var gst = $('#gst'+relate).val();
                $('#subtotal'+relate).val(price*qty_order);
                $('#total'+relate).val((price*qty_order)+(((price*qty_order)*gst)/100));
                $('#sub-total-text'+relate).text(price*qty_order);
                $('#gst-amount'+relate).text(((price*qty_order)*gst)/100);
                $('#total-text'+relate).text((price*qty_order)+(((price*qty_order)*gst)/100));
                var finalTotal = 0;
                for(k = 1; k <= counter; k++){
                    finalTotal += parseInt($('#total-text'+k).text());
                }
                $('#final-total').text(finalTotal);
            });
            $('.gst').on('change', function(e){
                e.preventDefault();
                var relate = $(this).attr('rel');
                var price = 0;
                var selectedSup = $('#supp'+relate+' :selected').val();
                if(selectedSup === '2'){
                    price = $('#price-2'+relate).text();
                }else if(selectedSup === '3'){
                    price = $('#price-3'+relate).text();
                }else{
                    price = $('#price-1'+relate).text();
                }
                var qty_order = $('#qty'+relate).val();
                var gst = $('#gst'+relate).val();
                $('#subtotal'+relate).val(price*qty_order);
                $('#total'+relate).val((price*qty_order)+(((price*qty_order)*gst)/100));
                $('#sub-total-text'+relate).text(price*qty_order);
                $('#gst-amount'+relate).text(((price*qty_order)*gst)/100);
                $('#total-text'+relate).text((price*qty_order)+(((price*qty_order)*gst)/100));
                var finalTotal = 0;
                for(k = 1; k <= counter; k++){
                    finalTotal += parseInt($('#total-text'+k).text());
                }
                $('#final-total').text(finalTotal);
            });
        });
        $(document).on('keydown.autocomplete', '.part-no', function(){
            //alert(1);
            $(this).autocomplete(part_no_options);
        });
        $(document).on('autocompleteselect', '.part-no', function(e, ui){
            var order_qty = ui.item.reqQuantity - ui.item.stockAvailable;
            if(order_qty < 0){
                order_qty = 0;
            }
            $('#bom-id-'+partRel).val(ui.item.bomId);
            $('#part-names'+partRel).val(ui.item.partName);
            $('#supplier-1-'+partRel).val(ui.item.supplier1id);
            $('#supplier-2-'+partRel).val(ui.item.supplier2id);
            $('#supplier-3-'+partRel).val(ui.item.supplier3id);
            $('#sup-item-1-'+partRel).val(ui.item.supItemId1);
            $('#sup-item-2-'+partRel).val(ui.item.supItemId2);
            $('#sup-item-3-'+partRel).val(ui.item.supItemId3);
            $('#supp-1-'+partRel).text(ui.item.supplier1);
            $('#supp-2-'+partRel).text(ui.item.supplier2);
            $('#supp-3-'+partRel).text(ui.item.supplier3);
            $('#price-1-'+partRel).val(ui.item.price1);
            $('#price-2-'+partRel).val(ui.item.price2);
            $('#price-3-'+partRel).val(ui.item.price3);
            $('#price-1'+partRel).text(ui.item.price1);
            $('#price-2'+partRel).text(ui.item.price2);
            $('#price-3'+partRel).text(ui.item.price3);
            $('#cat-in-'+partRel).val(ui.item.category);
            $('#uom-in-'+partRel).val(ui.item.uom);
            $('#stock-in-'+partRel).val(ui.item.stockAvailable);
            $('#qty-req-in-'+partRel).val(ui.item.reqQuantity);
            $('#cat-'+partRel).text(ui.item.category);
            $('#uom-'+partRel).text(ui.item.uom);
            $('#stock-'+partRel).text(ui.item.stockAvailable);
            $('#qty-req-'+partRel).text(ui.item.reqQuantity);
            $('#qty'+partRel).val(order_qty);
            $('#subtotal'+partRel).val(ui.item.price1*order_qty);
            $('#total'+partRel).val((ui.item.price1*order_qty)+(((ui.item.price1*order_qty)*def_gst)/100));
            $('#sub-total-text'+partRel).text(ui.item.price1*order_qty);
            $('#gst-amount'+partRel).text((((ui.item.price1*order_qty)*def_gst)/100));
            $('#total-text'+partRel).text((ui.item.price1*order_qty)+(((ui.item.price1*order_qty)*def_gst)/100));
            var finalTotal = 0;
            for(k = 1; k <= counter; k++){
                finalTotal += parseInt($('#total-text'+k).text());
            }
            $('#final-total').text(finalTotal);
        });
        $(document).on('keydown.autocomplete', '.part-name', function(){
            //alert(1);
            $(this).autocomplete(part_name_options);
        });
        $(document).on('autocompleteselect', '.part-name', function(e, ui){
            var order_qty = ui.item.reqQuantity - ui.item.stockAvailable;
            if(order_qty < 0){
                order_qty = 0;
            }
            $('#bom-id-'+partRel).val(ui.item.bomId);
            $('#part-nos'+partRel).val(ui.item.partNo);
            $('#supplier-1-'+partRel).val(ui.item.supplier1id);
            $('#supplier-2-'+partRel).val(ui.item.supplier2id);
            $('#supplier-3-'+partRel).val(ui.item.supplier3id);
            $('#sup-item-1-'+partRel).val(ui.item.supItemId1);
            $('#sup-item-2-'+partRel).val(ui.item.supItemId2);
            $('#sup-item-3-'+partRel).val(ui.item.supItemId3);
            $('#supp-1-'+partRel).text(ui.item.supplier1);
            $('#supp-2-'+partRel).text(ui.item.supplier2);
            $('#supp-3-'+partRel).text(ui.item.supplier3);
            $('#price-1-'+partRel).val(ui.item.price1);
            $('#price-2-'+partRel).val(ui.item.price2);
            $('#price-3-'+partRel).val(ui.item.price3);
            $('#price-1'+partRel).text(ui.item.price1);
            $('#price-2'+partRel).text(ui.item.price2);
            $('#price-3'+partRel).text(ui.item.price3);
            $('#cat-'+partRel).text(ui.item.category);
            $('#uom-'+partRel).text(ui.item.uom);
            $('#stock-'+partRel).text(ui.item.stockAvailable);
            $('#qty-req-'+partRel).text(ui.item.reqQuantity);
            $('#qty'+partRel).val(order_qty);
            $('#subtotal'+partRel).val(ui.item.price1*order_qty);
            $('#total'+partRel).val((ui.item.price1*order_qty)+(((ui.item.price1*order_qty)*def_gst)/100));
            $('#sub-total-text'+partRel).text(ui.item.price1*order_qty);
            $('#gst-amount'+partRel).text((((ui.item.price1*order_qty)*def_gst)/100));
            $('#total-text'+partRel).text((ui.item.price1*order_qty)+(((ui.item.price1*order_qty)*def_gst)/100));
            var finalTotal = 0;
            for(k = 1; k <= counter; k++){
                finalTotal += parseInt($('#total-text'+k).text());
            }
            $('#final-total').text(finalTotal);
        });
    });
</script>