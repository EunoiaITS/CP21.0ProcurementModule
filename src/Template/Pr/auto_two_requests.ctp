<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>PR 2 REQUEST LIST</b></div>
            </div>

            <div class="clearfix"></div>
            <!--============== Add drawing table area ===================-->
            <div class="planner-table table-responsive clearfix">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>SO NO</th>
                            <th>SO Date</th>
                            <th>Delivery Date</th>
                            <th>Description</th>
                            <th>Customer Name</th>
                            <th>Category</th>
                            <th>Remark</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="csn-text-up">
                        <?php $count = 0;foreach ($pr as $p): $count++?>
                        <tr>
                            <td><?= $count ?></td>
                            <td><?= $p->so_no ?></td>
                            <td><?= date('Y-m-d',strtotime($p->date)) ?></td>
                            <td><?= $p->delivery_date ?></td>
                            <td><?= $p->description ?></td>
                            <td><?= $p->customer ?></td>
                            <td>Auto</td>
                            <td></td>
                            <td><a href="<?php echo $this->Url->build(['controller'=>'Pr','action'=>'viewTwoAuto',$p->id])?>">Select</a></td>
                        </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>