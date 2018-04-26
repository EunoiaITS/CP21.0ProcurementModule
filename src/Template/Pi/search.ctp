<!--=========
Create serial number form page
==============-->

<div class="planner-from">
    <div class="container-fluid">
        <form action="<?php echo $this->Url->build(['controller'=>'pi','action'=>'view'])?>" method="post" class="planner-relative">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Procurement Department Part Information</b></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Part No <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <input name="part_no" type="text" rel="parts-name" id="parts-no" placeholder="Part No" class="form-control part-no"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Part Name<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <input name="part_name" type="text" rel="parts-no" id="parts-name" placeholder="Parts Name" class="form-control part-name"/>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-offset-8 col-sm-4 col-xs-12">
            <div class="prepareted-by-csn">
                <button type="submit" class="button btn btn-info">Search</button>
            </div>
        </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
    var part_no = 'input.part-no';
    var part_name = 'input.part-name';
    var data_no = [<?php echo $part_no; ?>];
    var options_no = {
        source: data_no,
        minLength: 0
    };
    var targetName = null;
    $(document).on('keydown.autocomplete', part_no, function() {
        $(this).autocomplete(options_no);
    });
    $(document).on('autocompleteselect', part_no, function(e, ui) {
        targetName = $(this).attr('rel');
        $('#'+targetName).val(ui.item.idx);
    });
    var data_name = [<?php echo $part_name; ?>];
    var options_name = {
        source: data_name,
        minLength: 0
    };
    var targetNo = null;
    $(document).on('keydown.autocomplete', part_name, function() {
        $(this).autocomplete(options_name);
    });
    $(document).on('autocompleteselect', part_name, function(e, ui) {
        targetNo = $(this).attr('rel');
        $('#'+targetNo).val(ui.item.idx);
    });
});
</script>
