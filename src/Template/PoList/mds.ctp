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
                                <input class="form-control" name="del-no" type="number" id="del-no" min="1" max="20" <?php if(isset($item->mds)){echo 'value="'.$item->dels->count().'" disabled';} ?>>
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
                    <tr>
                    </thead>
                    <tbody id="dyn">
                    <?php $count = 0; if(isset($item->dels)): foreach($item->dels as $dels): $count++; ?>
                        <tr>
                            <input type="hidden" name="del-<?= $count ?>" value="<?= $dels->id ?>">
                            <td><input name="del-date-<?= $dels->id ?>" class="form-control datepicker" type="datetime" value="<?= date('Y-m-d', strtotime($dels->del_date)) ?>"></td>
                            <td><input name="del-qty-<?= $dels->id ?>" class="form-control" type="number" value="<?= $dels->del_qty ?>"></td>
                        </tr>
                    <?php endforeach; echo '<input type="hidden" name="action" value="edit"><input type="hidden" name="total-edit" value="'.$count.'">'; endif; ?>
                    </tbody>
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

<script>
    $(document).ready(function(){
        $('#del-no').on('change', function(e){
            e.preventDefault();
            var delNo = $(this).val();
            var html_table = '';
            for(var i = 1; i <= delNo; i++){
                html_table += '<tr>'+
                '<td><input type="datetime" name="del-date-'+i+'" class="form-control datepicker" value="<?= date('Y-m-d') ?>" required></td>'+
                '<td><input type="number" name="del-qty-'+i+'" class="form-control" min="1" required></td>'+
                '</tr>';
                $('#total').val(i);
            }
            $('#dyn').html(html_table);
        });
    });
</script>