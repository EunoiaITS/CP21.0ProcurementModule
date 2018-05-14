<div class="planner-from">
    <div class="container-fluid">
        <form action="<?php echo $this->Url->build(['controller' => 'PoList', 'action' => 'partDetails']); ?>" method="post" class="planner-relative">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Procurement Order List Search List</b></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Part No <span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <input class="form-control part-no" type="text" name="part-no">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Part Name<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <input class="form-control part-name" type="text" name="part-name">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-6">
                                <p class="planner-year">Supplier Name<span class="planner-fright">:</span></p>
                            </div>
                            <div class="col-sm-5 col-xs-6">
                                <select class="form-control" name="supplier">
                                    <option value="1">Supplier 1</option>
                                    <option value="2">Supplier 2</option>
                                    <option value="3">Supplier 3</option>
                                </select>
                            </div>
                        </div>
                    </div>
            </div>
        </div>



        <div class="clearfix"></div>
        <div class="col-sm-offset-8 col-sm-4 col-xs-12">
            <div class="prepareted-by-csn">
                <input type="hidden" name="bom-part-id" id="part-id">
                <input type="hidden" name="supplier-id1" id="supp-id1">
                <input type="hidden" name="supplier-id2" id="supp-id2">
                <input type="hidden" name="supplier-id3" id="supp-id3">
                <button type="submit" class="button btn btn-info">Search</button>
            </div>
        </div>
            </form>
    </div>
</div>

<script>
    $(document).ready(function(){
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
        $(document).on('keydown.autocomplete', '.part-no', function(){
            $(this).autocomplete(part_no_options);
        });
        $(document).on('autocompleteselect', '.part-no', function(e, ui){
            $('.part-name').val(ui.item.partName);
            $('#part-id').val(ui.item.bomId);
            $('#supp-id1').val(ui.item.supItemId1);
            $('#supp-id2').val(ui.item.supItemId2);
            $('#supp-id3').val(ui.item.supItemId3);
        });
        $(document).on('keydown.autocomplete', '.part-name', function(){
            $(this).autocomplete(part_name_options);
        });
        $(document).on('autocompleteselect', '.part-name', function(e, ui){
            $('.part-no').val(ui.item.partNo);
            $('#part-id').val(ui.item.bomId);
            $('#supp-id1').val(ui.item.supItemId1);
            $('#supp-id2').val(ui.item.supItemId2);
            $('#supp-id3').val(ui.item.supItemId3);
        });
    });
</script>