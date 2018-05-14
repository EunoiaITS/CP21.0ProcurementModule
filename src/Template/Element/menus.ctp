<!--==================
     sidebar area
     ====================-->

<div id="sidebar">
    <ul>
        <!-- about user section -->
        <li class="div-userid">
            <div class="col-sm-3 col-xs-3 padding-zero">
                <div class="user-image">
                    <img src="<?php echo $this->request->webroot.'assets/img/user-png.png'; ?>" alt="">
                </div>
            </div>
            <div class="col-sm-9 col-xs-9 padding-zero">
                <div class="user-details text-uppercase">
                    <div class="user-name">
                        <span class="user-label"><b>User Name</b> :</span>
                        <span class="user-label-no"><?= $user_pic ?></span>
                    </div>
                    <div class="user-name">
                        <span class="user-label"><b>Role</b> :</span>
                        <span class="user-label-no"><?= $role ?></span>
                    </div>
                    <div class="user-name">
                        <span class="user-label"><b>Department</b> :</span>
                        <span class="user-label-no">Procurement</span>
                    </div>
                </div>
            </div>
        </li>
        <li><a href="#" class="active">Home (Login)</a></li>
        <?php if($role != 'approver-2' || $role != 'approver-3'): ?>
        <div class="btn-group-vertical" role="group" class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                PURCHASE REQUESITION &nbsp;
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li class="color-hsh"><a href="<?php echo $this->Url->build(['controller'=>'Pr','action'=>'manualRequests'])?>">PR Request List (manual)</a></li>
                <?php if($role == 'requester'): ?><li class="color-hsh2"><a href="<?php echo $this->Url->build(['controller'=>'Pr','action'=>'addManual'])?>">PR Generate (manual)</a></li><?php endif;?>
                <li class="color-hsh"><a href="<?php echo $this->Url->build(['controller'=>'Pr','action'=>'autoRequests'])?>">PR Request List (auto)</a></li>
                <?php if($role == 'requester'): ?><li class="color-hsh2"><a href="<?php echo $this->Url->build(['controller'=>'Pr','action'=>'addAuto'])?>">PR 1 Generate (auto)</a></li><?php endif;?>
<!--                <li class="color-hsh"><a href="#">Customization Item</a></li>-->
                <li class="color-hsh"><a href="<?php echo $this->Url->build(['controller'=>'Pr','action'=>'autoTwoRequests'])?>">PR 2 Request List (auto)</a></li>
                <?php if($role == 'requester'): ?><li class="color-hsh2"><a href="<?php echo $this->Url->build(['controller'=>'Pr','action'=>'addTwoAuto'])?>">PR 2 Generate (auto)</a></li><?php endif;?>
                <li class="color-hsh3"><a href="#">PR Approval Status</a></li>
                <li class="color-hsh3"><a href="<?php echo $this->Url->build(['controller'=>'Pr','action'=>'report'])?>">PR Report</a></li>
                <li class="color-hsh3"><a href="#">PR Statistic Report</a></li>
            </ul>
        </div>
        <?php endif;?>
        <div class="btn-group-vertical" role="group" class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                PURCHASE ORDER &nbsp;
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li class="color-hsh"><a href="<?php echo $this->Url->build(['controller'=>'Po','action'=>'requests'])?>">PO Request List</a></li>
                <?php if($role == 'requester'): ?><li class="color-hsh"><a href="<?php echo $this->Url->build(['controller'=>'Po','action'=>'index'])?>">PO Form Create</a></li><?php endif;?>
                <li class="color-hsh2"><a href="<?php echo $this->Url->build(['controller'=>'Po','action'=>'approvalStatus'])?>">PO Approval Status</a></li>
                <li class="color-hsh2"><a href="<?php echo $this->Url->build(['controller'=>'Po','action'=>'report'])?>">PO Report</a></li>
                <li class="color-hsh2"><a href="<?php echo $this->Url->build(['controller'=>'Po','action'=>'statReport'])?>">PO Statistic Report</a></li>
            </ul>
        </div>
        <div class="btn-group-vertical" role="group" class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                PURCHASE ORDER LIST &nbsp;
                <span class="caret"></span>
            </button>
            <ul  class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li class="color-hsh2"><a href="<?php echo $this->Url->build(['controller'=>'PoList','action'=>'index'])?>">PO List</a></li>
                <li class="color-hsh2"><a href="#">PO list Report</a></li>
                <li class="color-hsh2"><a href="#">PO list Search list</a></li>
            </ul>
        </div>
<!--        <div class="btn-group-vertical" role="group" class="dropdown">-->
<!--            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">-->
<!--                RTVN &nbsp;-->
<!--                <span class="caret"></span>-->
<!--            </button>-->
<!--            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">-->
<!--                <li class="color-hsh"><a href="#">RTVN Descrepency List</a></li>-->
<!--                <li class="color-hsh"><a href="#">RTVN Create</a></li>-->
<!--                <li class="color-hsh"><a href="#">RTVN Verification</a></li>-->
<!--                <li class="color-hsh"><a href="#">RTVN Approval</a></li>-->
<!--                <li class="color-hsh2"><a href="#">RTVN Approval Status</a></li>-->
<!--                <li class="color-hsh2"><a href="#">RTVN Report</a></li>-->
<!--            </ul>-->
<!--        </div>-->
        <li><a href="<?php echo $this->Url->build(['controller'=>'Ps','action'=>'index'])?>">PRODUCTION SCHEDULER</a></li>
<!--        <div class="btn-group-vertical" role="group" class="dropdown">-->
<!--            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">-->
<!--                INCOMING PARTS INSPECTION &nbsp;-->
<!--                <span class="caret"></span>-->
<!--            </button>-->
<!--            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">-->
<!--                <li class="color-hsh"><a href="#">IPI Create</a></li>-->
<!--                <li class="color-hsh"><a href="#">IPI Verification</a></li>-->
<!--                <li class="color-hsh"><a href="#">IPI Approval</a></li>-->
<!--                <li class="color-hsh"><a href="#">IPI Approval Status</a></li>-->
<!--                <li class="color-hsh"><a href="#">IPI Report</a></li>-->
<!--            </ul>-->
<!--        </div>-->
        <div class="btn-group-vertical" role="group" class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                SUPPLIER &nbsp;
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li class="color-hsh"><a href="<?php echo $this->Url->build(['controller' => 'Supplier', 'action' => 'add']); ?>">Supplier Create</a></li>
                <li class="color-hsh"><a href="<?php echo $this->Url->build(['controller' => 'Supplier', 'action' => 'index']); ?>">Supplier List</a></li>
            </ul>
        </div>
        <div class="btn-group-vertical" role="group" class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                PART INFO &nbsp;
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li class="color-hsh"><a href="<?php echo $this->Url->build(['controller'=>'Pi','action'=>'search'])?>">Part Information Search</a></li>
                <li class="color-hsh"><a href="<?php echo $this->Url->build(['controller'=>'Pi','action'=>'index'])?>">Part Information Report</a></li>
            </ul>
        </div>
    </ul>
</div>