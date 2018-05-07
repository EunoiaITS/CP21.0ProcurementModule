<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>PR Request List</b></div>
            </div>

            <div class="clearfix"></div>
            <!--============== Add drawing table area ===================-->
            <div class="planner-table table-responsive clearfix">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>PR NO</th>
                            <th>Date</th>
                            <th>Department</th>
                            <th>Create By</th>
                            <th>Status</th>
                            <th>View</th>
                        </tr>
                        </thead>
                        <tbody class="csn-text-up">
                        <?php $count = 0;foreach ($pr as $p): $count++?>
                            <tr>
                                <td><?= $count ?></td>
                                <td>PR <?= $p->id ?></td>
                                <td><?= date('Y-m-d',strtotime($p->date)) ?></td>
                                <td></td>
                                <td></td>
                                <td><?= $p->status ?></td>
                                <td><a href="<?php echo $this->Url->build(['controller'=>'Pr', 'action'=>'viewManual', $p->id])?>">Select</a></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>