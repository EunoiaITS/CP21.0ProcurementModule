<div class="planner-from">
    <div class="container-fluid">
        <form action="<?php echo $this->Url->build(['controller' => 'PoList', 'action' => 'mds']).'?id='.$md.'&type=plan'; ?>" method="post" class="planner-relative">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Material Delivery Scheduler</b></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Part No <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p><?= $item->eng->partNo ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Description<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <p><?= $item->eng->partName ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">No Of  Delivery<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <input class="form-control" name="del-no" type="number" id="del-no" min="<?php if(isset($item->mds)){echo $item->dels->count();}else{echo 0;} ?>" max="20" <?php if(isset($item->mds)){echo 'value="'.$item->dels->count().'"';} ?>>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <!--============== Add drawing table area ===================-->
        <div class="planner-table table-responsive clearfix">
            <div class="col-sm-12">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Date Of Delivery</th>
                        <th>QTY Of Delivery</th>
                        <th>Delete</th>
                    <tr>
                    </thead>
                    <tbody id="dyn">
                    <?php $count = 0; if(isset($item->dels)): foreach($item->dels as $dels): $count++; ?>
                        <tr>
                            <input type="hidden" name="del-<?= $count ?>" value="<?= $dels->id ?>">
                            <td><input name="del-date-<?= $dels->id ?>" class="form-control datepicker" type="datetime" value="<?= date('Y-m-d', strtotime($dels->del_date)) ?>"></td>
                            <td><input name="del-qty-<?= $dels->id ?>" class="form-control" type="number" value="<?= $dels->del_qty ?>" min="0"></td>
                            <td><a href="#" data-toggle="modal" data-target="#myModalDel<?= $count ?>"><i class="fa fa-trash fa-2x"></i></a></td>
                        </tr>
                    <?php endforeach; echo '</div><input type="hidden" name="action" value="edit"><input type="hidden" name="total-edit" value="'.$count.'">'; endif; ?>
                    </tbody>
                    <tbody id="added-items">
                    </tbody>
                    <input type="hidden" name="addeds" id="addeds" value="0">
                </table>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="col-sm-offset-8 col-sm-4 col-xs-12">
            <div class="prepareted-by-csn">
                <input type="hidden" name="total" id="total">
                <button type="submit" class="button btn btn-info">Submit</button>
            </div>
        </div>
        </form>
    </div>
</div>
<?php $count = 0; if(isset($item->dels)): foreach($item->dels as $dels): $count++; ?>
<div class="modal fade" id="myModalDel<?= $count ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body supplier-modal-body">
                <p class="text-center">Are you sure you want to delete this item?</p>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <form action="<?php echo $this->Url->build(['controller' => 'PoList', 'action' => 'delete', $dels->id]).'?mds='.$md; ?>" method="post">
                    <button type="submit" class="btn btn-primary">Yes</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">No</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; endif; ?>
<script>
    $(document).ready(function(){
        $('#del-no').on('change', function(e){
            e.preventDefault();
            var prevVal = $(this).attr('min');
            var delNo = parseInt($(this).val()) - parseInt(prevVal);
            var html_table = '';
            for(var i = 1; i <= delNo; i++){
                html_table += '<tr id="added-'+i+'">'+
                '<td><input type="datetime" name="add-del-date-'+i+'" class="form-control datepicker" value="<?= date('Y-m-d') ?>" required></td>'+
                '<td><input type="number" name="add-del-qty-'+i+'" class="form-control" min="1" required></td>'+
                '<td><a href="#" class="del-item" rel="'+i+'"><i class="fa fa-trash fa-2x"></i></a></td>'+
                '</tr>';
                $('#total').val(i);
            }
            $('#added-items').html(html_table);
            $('#addeds').val(delNo);
            $('.del-item').on('click', function(e){
                e.preventDefault();
                var addRef = $(this).attr('rel');
                $('#added-'+addRef).remove();
                $('#del-no').val((parseInt($('#del-no').val()) - 1));
            });
        });
    });
</script>