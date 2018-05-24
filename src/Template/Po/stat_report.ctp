<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>PO Statistic Report <?php if($month == '01'){echo 'January-' . $year ;}elseif(($month == '02')){echo 'February-' . $year ;}elseif(($month == '03')){echo 'March-' . $year ;}elseif(($month == '04')){echo 'April-' . $year ;}elseif(($month == '05')){echo 'May-' . $year ;}elseif(($month == '06')){echo 'June-' . $year ;}elseif(($month == '07')){echo 'July-' . $year ;}elseif(($month == '08')){echo 'August-' . $year ;}elseif(($month == '09')){echo 'September-' . $year ;}elseif(($month == '10')){echo 'October-' . $year ;}elseif(($month == '11')){echo 'November-' . $year ;}elseif(($month == '12')){echo 'December-' . $year ;} ?></b></div>
            </div>

            <div class="clearfix"></div>
            <div class="form-group">
                <div class="col-sm-3 col-xs-6">
                    <label for="model-planer" class="ps-month">Month <span class="planner-fright">:</span></label>
                </div>
                <div class="col-sm-5 col-xs-6">
                    <select class="form-control" name="month" id="po-month">
                        <option value="01" <?php if($month == '01'){echo 'selected';} ?>>January</option>
                        <option value="02" <?php if($month == '02'){echo 'selected';} ?>>February</option>
                        <option value="03" <?php if($month == '03'){echo 'selected';} ?>>March</option>
                        <option value="04" <?php if($month == '04'){echo 'selected';} ?>>April</option>
                        <option value="05" <?php if($month == '05'){echo 'selected';} ?>>May</option>
                        <option value="06" <?php if($month == '06'){echo 'selected';} ?>>June</option>
                        <option value="07" <?php if($month == '07'){echo 'selected';} ?>>July</option>
                        <option value="08" <?php if($month == '08'){echo 'selected';} ?>>August</option>
                        <option value="09" <?php if($month == '09'){echo 'selected';} ?>>September</option>
                        <option value="10" <?php if($month == '10'){echo 'selected';} ?>>October</option>
                        <option value="11" <?php if($month == '11'){echo 'selected';} ?>>November</option>
                        <option value="12" <?php if($month == '12'){echo 'selected';} ?>>December</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3 col-xs-6">
                    <label for="model-planer" class="ps-month">Year <span class="planner-fright">:</span></label>
                </div>
                <div class="col-sm-5 col-xs-6">
                    <select class="form-control" name="year" id="po-year">
                        <?php for($i = 1990; $i <= date('Y'); $i++){ ?>
                            <option value="<?php echo $i ?>" <?php if($year == $i){echo 'selected';} ?>><?php echo $i ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="pre col-sm-8">
                <a href="<?php echo $this->url->build(['controller' => 'Po', 'action' => 'statReport']).'?month='.$month.'&year='.$year; ?>" class="button btn btn-info" id="btn-generate">Generate</a>
            </div>
            <div class="clearfix"></div>
            <!--============== Add drawing table area ===================-->
            <div class="planner-table table-responsive clearfix">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Department</th>
                            <th>No Of PO</th>
                            <th>Approve</th>
                            <th>Reject</th>
                            <th>Pending</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody class="csn-text-up">
                        <tr>
                            <td>Procurement</td>
                            <td><?= $total ?></td>
                            <td><?= $approve ?></td>
                            <td><?= $reject ?></td>
                            <td><?= $request ?></td>
                            <td>$ <?= $amount ?></td>
                        </tr>
                        <tr>
                            <td colspan="5">Grand Total</td>
                            <td>$ <?= $amount ?></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $( document ).ready(function() {
            $('#btn-generate').on('click', function(){
                var month = $('#po-month').val();
                var year = $('#po-year').val();
                var url = "<?php echo $this->Url->build(['controller'=>'Po','action'=>'statReport'])?>";
                $(this).attr("href",url+"?month="+month+"&year="+year);
            });
        });
    </script>