<!--=========
Create serial number form page
==============-->

<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Procurement Department Part Information Report</b></div>
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
                            <th>Supplier</th>
                            <th>Price</th>
                            <th>Stock Available</th>
                            <th>Min Stock</th>
                            <th>Document</th>
                            <th>Remark</th>
                        </tr>
                        </thead>
                        <tbody class="csn-text-up">
                        <?php $count =0;foreach ($sup as $s): $count++?>
                        <?php foreach ($s->items as $i):?>
                        <tr>
                            <td><?= $count ?></td>
                            <td><?= $i->part_no ?></td>
                            <td><?= $i->part_name ?></td>
                            <td><?= $s->name ?></td>
                            <td><?= $i->unit_price ?></td>
                            <td><?= $s->stock ?></td>
                            <td><?= $s->min_stock ?></td>
                            <td><a href="<?= $i->doc_file ?>"><?php if(isset($i->doc_file)){echo "View";}else{echo '';}?></a></td>
                            <td></td>
                        </tr>
                        <?php endforeach;endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
