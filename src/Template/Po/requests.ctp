<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>PO Request List</b></div>
            </div>

            <div class="clearfix"></div>
            <!--============== Add drawing table area ===================-->
            <div class="planner-table table-responsive clearfix">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>PO NO</th>
                            <th>Date</th>
                            <th>Department</th>
                            <th>Create By</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody class="csn-text-up">
                        <?php $count = 0; foreach($po as $p): $count++; ?>
                        <tr>
                            <td><?= $count ?></td>
                            <td>PO <?= $p->id ?></td>
                            <td><?= date('Y-m-d', strtotime($p->date)) ?></td>
                            <td>Procurement</td>
                            <td><?= $p->created_by ?></td>
                            <td><a href="<?php echo $this->Url->build(['controller' => 'Po', 'action' => 'requestsView', $p->id]); ?>"><?php if($role == 'requester'){echo 'pending';}elseif ($role == 'verifier'){echo 'verify';}elseif ($role == 'approver-1'){echo 'approve';}elseif ($role == 'approver-2'){echo 'approve';}elseif ($role == 'approver-3'){echo 'approve';}?></a></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>