<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Procurement Order List</b></div>
            </div>

            <div class="clearfix"></div>
            <!--============== Add drawing table area ===================-->
            <div class="planner-table table-responsive clearfix">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>SO No</th>
                            <th>Delivery Date</th>
                            <th>PR No</th>
                            <th>PR Date</th>
                            <th>PO Date</th>
                            <th>PO No</th>
                            <th>Part No</th>
                            <th>Description</th>
                            <th>Supplier</th>
                            <th>QTY Request</th>
                            <th>Extra 10%</th>
                            <th>Total</th>
                            <th>Create By</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Inform Supply</th>
                            <th>Delivery Type</th>
                            <th>Document</th>
                            <th>Remark</th>
                        </tr>
                        </thead>
                        <tbody class="csn-text-up">
                        <?php foreach($pol as $po): ?>
                            <?php $count = 0; foreach($po->pr_items as $item): $count++; ?>
                        <tr>
                            <td><?php if($count == 1){echo $po->pr->so_no;} ?></td>
                            <td><?php if($count == 1){echo date('Y-m-d', strtotime($po->del_date));} ?></td>
                            <td><?php if($count == 1){echo 'PR'.$po->pr->id;} ?></td>
                            <td><?php if($count == 1){echo date('Y-m-d', strtotime($po->pr->date));} ?></td>
                            <td><?php if($count == 1){echo date('Y-m-d', strtotime($po->date));} ?></td>
                            <td><?php if($count == 1){echo 'PO'.$po->id;} ?></td>
                            <td><?= $item->eng->partNo ?></td>
                            <td><?= $item->eng->partName ?></td>
                            <td><?php if(isset($item->supplier_name->name)) echo $item->supplier_name->name; ?></td>
                            <td><?= $item->eng->quality ?></td>
                            <td><?= $item->eng->quality+(($item->eng->quality*10)/100) ?></td>
                            <td><?= $item->total ?></td>
                            <td><?php if($count == 1){echo $po->req->name;} ?></td>
                            <td><?php if($count == 1){echo 'Procurement';} ?></td>
                            <td><?= $po->status ?></td>
                            <td>Yes</td>
                            <td>
                                <select class="form-control del-type" name="del-type" rel="<?= $item->id ?>" id="del-type<?= $item->id ?>">
                                    <option>Please select...</option>
                                    <option value="Plan" <?php if(isset($item->mds)){if($item->mds->del_type == 'Plan'){echo 'selected';}} ?>>Plan</option>
                                    <option value="Complete" <?php if(isset($item->mds)){if($item->mds->del_type == 'Complete'){echo 'selected disabled';}} ?>>Complete</option>
                                </select>
                                <div class="clearfix" id="mds<?= $item->id ?>">
                                    <?php if(isset($item->mds)){if($item->mds->del_type == 'Plan'){echo '<a href="'.$this->Url->build(['controller' => 'PoList', 'action' => 'mds']).'?id='.$item->id.'&type=plan">Plan</a>';}} ?>
                                </div>
                            </td>
                            <td><a href="#">View</a></td>
                            <td></td>
                        </tr>
                        <?php endforeach; endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        var url = "<?php echo $this->Url->build(['controller' => 'PoList', 'action' => 'mds']).'?id='; ?>";
        $('.del-type').on('change', function(e){
            e.preventDefault();
            var id = $(this).attr('rel');
            var sel = $('#del-type'+id+' :selected').val();
            if(sel === 'Plan'){
                $('#mds'+id).html('<a href="'+url+id+'&type=plan">Plan</a>');
            }else if(sel === 'Complete'){
                $('#mds'+id).html('<a href="'+url+id+'&type=complete">Complete</a>');
            }else{
                $('#mds'+id).html('');
            }
        });
    });
</script>
