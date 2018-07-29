<!--=========
      Drawing Notification page
      ==============-->

<div class="drawing-from">
    <div class="container">
        <div class="row">
            <h4 class="part-title-planner text-uppercase text-center">Dashboard</h4>
            <!--============== Add drawing table area ===================-->
            <div class="drawing-table table-responsive clearfix">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Section</th>
                            <th>Requests</th>
                            <th>PIC</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Purchase Requisition (Manual)</td>
                                <?php if($role == 'requester'): ?>
                                    <td></td>
                                <?php else: ?>
                                    <td><b><?php if($role == 'verifier'){ echo $manual;}else{echo $manual_v;} ?></b></td>
                                <?php endif; ?>
                                <td><?= $user_pic ?></td>
                                <td><?= date('Y-m-d') ?></td>
                                <td><?php if($role == 'verifier'){ echo 'Requested';}elseif($role == 'approver-1'){echo 'Verified';} ?></td>
                                <td><a href="<?php echo $this->Url->build(['controller'=>'Pr', 'action'=>'manualRequests']);?>"><?php if($role == 'verifier' || $role == 'approver-1'): ?><span class="btn btn-primary"><?php if($role == 'verifier'){ echo 'Verify';}elseif($role == 'approver-1'){echo 'Approve';} ?></span><?php endif;?></a></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Purchase Requisition (Auto 1)</td>
                                <?php if($role == 'requester'): ?>
                                    <td></td>
                                <?php else: ?>
                                    <td><b><?php if($role == 'verifier'){echo $auto1;}else{echo $auto1_v;}  ?></b></td>
                                <?php endif; ?>
                                <td><?= $user_pic ?></td>
                                <td><?= date('Y-m-d') ?></td>
                                <td><?php if($role == 'verifier'){ echo 'Requested';}elseif($role == 'approver-1'){echo 'Verified';} ?></td>
                                <td><a href="<?php echo $this->Url->build(['controller'=>'Pr', 'action'=>'autoRequests']);?>"><?php if($role == 'verifier' || $role == 'approver-1'): ?><span class="btn btn-primary"><?php if($role == 'verifier'){ echo 'Verify';}elseif($role == 'approver-1'){echo 'Approve';} ?></span><?php endif;?></a></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Purchase Requisition (Auto 2)</td>
                                <?php if($role == 'requester'): ?>
                                    <td></td>
                                <?php else: ?>
                                    <td><b><?php if($role == 'verifier'){echo $auto2;}else{ echo $auto2_v;} ?></b></td>
                                <?php endif; ?>
                                <td><?= $user_pic ?></td>
                                <td><?= date('Y-m-d') ?></td>
                                <td><?php if($role == 'verifier'){ echo 'Requested';}elseif($role == 'approver-1'){echo 'Verified';} ?></td>
                                <td><a href="<?php echo $this->Url->build(['controller'=>'Pr', 'action'=>'autoTwoRequests']);?>"><?php if($role == 'verifier' || $role == 'approver-1'): ?><span class="btn btn-primary"><?php if($role == 'verifier'){ echo 'Verify';}elseif($role == 'approver-1'){echo 'Approve';} ?></span><?php endif;?></a></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Purchase Order</td>
                                <td><b><?php if($role == 'verifier'){echo $po_req;}elseif($role == 'approver-1'){echo $po_ver;}elseif($role == 'approver-2'){echo $po_apr1;}?></b></td>
                                <td><?= $user_pic ?></td>
                                <td><?= date('Y-m-d') ?></td>
                                <td><?php if($role == 'verifier'){echo 'Requested';}elseif($role == 'approver-1'){echo 'Verified';}elseif($role == 'approver-2'){echo 'Approved 1';}?></td>
                                <td><a href="<?php echo $this->Url->build(['controller'=>'Po', 'action'=>'requests']);?>"><?php if($role != 'requester'): ?><span class="btn btn-primary"><?php if($role == 'verifier'){ echo 'Verify';}else{echo 'Approve';} ?></span><?php endif; ?></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><!-- Drawing page area -->