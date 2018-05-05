<!--=========
      Production Planner page
      ==============-->

<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="part-title-planner text-uppercase text-center"><b>Production Planner Scheduler</b></div>
            <div class="clearfix"></div>
            <!--============== Add drawing table area ===================-->
            <div class="planner-table table-responsive clearfix">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>SL No</th>
                            <th>PO No</th>
                            <th>SO No</th>
                            <th>Customer Code</th>
                            <th>Customer Name</th>
                            <th>Date Completion</th>
                            <th>Delivery Date</th>
                            <th>Model</th>
                            <th>Version</th>
                            <th>Type</th>
                            <th>QTY</th>
                            <th>No of Delivery Complete</th>
                            <th>Remaining Balance</th>
                            <th>Progress Plan</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = 0; ?>
                        <?php foreach($sales as $s): ?>
                            <?php foreach($s->soi as $item): ?>
                                <?php $count++; ?>
                                <tr>
                                    <td id="row-<?php echo $count; ?>"><?php echo $count; ?></td>
                                    <td><?= $s->poNo ?></td>
                                    <td><?= $s->salesorder_no ?></td>
                                    <td><?php foreach($s->cus as $cus){echo $cus->customerID;} ?></td>
                                    <td><?php foreach($s->cus as $cus){echo $cus->name;} ?></td>
                                    <td><?= date('m/d/Y', strtotime($s->delivery_date)) ?></td>
                                    <td><?= (isset($s->fgtt->date) ? $s->fgtt->date : '') ?></td>
                                    <td><?= $item->model ?></td>
                                    <td><?= $item->version ?></td>
                                    <td>N/A</td>
                                    <td id="qty-<?php echo $count; ?>"><?= $item->quantity ?></td>
                                    <td><?= (isset($s->production_sn->quantity) ? $s->production_sn->quantity : 0) ?></td>
                                    <td><?= (($item->quantity) - (isset($s->production_sn->quantity) ? $s->production_sn->quantity : 0)) ?></td>
                                    <td><button rel="<?php echo $count; ?>" class="btn btn-info btn-submit btn-popup"  data-toggle="modal" data-target="#myModal">View</button></td>d
                                </tr>
                                <span id="item-id-<?php echo $count; ?>" class="hidden"><?= $item->id ?></span>
                                <span id="action-<?php echo $count; ?>" class="hidden"><?= $item->action ?></span>
                                <span id="total-month-<?php echo $count; ?>" class="hidden"><?php echo count($s->months); ?></span>
                                <?php foreach($s->months as $key => $month): ?>
                                    <span id="calc-<?php echo $count.$key; ?>" class="hidden calc-<?php echo $month; ?>"><?php if(isset($item->{'actual'.$key})){echo $item->{'actual'.$key};}else{echo 0;} ?></span>
                                    <span id="month-no-<?php echo $count.$key; ?>" class="hidden month-names"><?php echo $month; ?></span>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
</div>



<!--======
      View items abc
      ===============================-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">Progress Plan</h4>
            </div>
            <div class="modal-body supplier-modal-body">
                <div class="clearfix table-responsive">
                    <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Month</th>
                            <th>Plan</th>
                        </tr>
                        </thead>
                        <tbody id="table-data">
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"  data-dismiss="modal" aria-label="Close">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.btn-popup').on('click', function(e){
            e.preventDefault();
            var id = $(this).attr('rel');
            var itemId = $('#item-id-'+id).text();
            var act = $('#action-'+id).text();
            var months = parseInt($('#total-month-'+id).text());
            var qty = parseInt($('#qty-'+id).text());
            var html_table = '';
            for(i = 0; i < months; i++){
                var exVal = 0;
                var exId = 'calc-'+id+i;
                if($('#'+exId).length != 0){
                    exVal = $('#'+exId).text();
                }
                html_table += '<tr>'+
                              '<td>'+$('#month-no-'+id+i).text()+'</td>'+
                              '<td>'+(qty/months)+'</td>'+
                              '<input type="hidden" name="plan" value="'+(qty/months)+'"><input type="hidden" name="month-year-'+i+'" value="'+$('#month-no-'+id+i).text()+'"><input type="hidden" name="item-id" value="'+itemId+'"><input type="hidden" name="action" value="'+act+'"></th>'+
                              '</tr>';
                }
            $('#table-data').html(html_table);
        });
        $('#btn-total').on('click', function(e){
            e.preventDefault();
            var all_month_names = [];
            $('span.month-names').each(function(){
                all_month_names.push($(this).text());
            });
            var month_names = [];
            $.each(all_month_names, function(i, e){
                if($.inArray(e, month_names) == -1) month_names.push(e);
            });
            var total_table = '';
            for(j = 0; j < month_names.length; j++){
                var total_qty = 0;
                $('.calc-'+month_names[j]).each(function(){
                    total_qty += parseInt($(this).text());
                });
                total_table += '<tr>'+
                    '<td>'+month_names[j]+'</td>'+
                    '<th>'+total_qty+'</th>'+
                    '</tr>';
            }
            $('#table-data-total').html(total_table);
        });
    });
</script>