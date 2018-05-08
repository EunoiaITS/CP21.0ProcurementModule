<div class="planner-from">
    <div class="container-fluid">
    <form action="<?php echo $this->Url->build(['controller'=>'po','action'=>'index'])?>" method="post">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Purchase Order Request List</b></div>
            </div>

            <div class="clearfix"></div>
            <!--============== Add drawing table area ===================-->
            <div class="planner-table table-responsive clearfix">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Select</th>
                            <th>SO NO</th>
                            <th>Delivery Date</th>
                            <th>PR Date</th>
                            <th>PR NO</th>
                            <th>Part No</th>
                            <th>Description</th>
                            <th>Suplier</th>
                            <th>QTY Request</th>
                            <th>Total</th>
                            <th>Create By</th>
                            <th>Department</th>
                        </tr>
                        </thead>
                        <tbody class="csn-text-up">
                        <?php $count=0;foreach ($pr as $p): foreach ($p->items as $i):$count++;?>
                        <tr>
                            <td><?= $count ?></td>
                            <td><input name="checkbox<?= $count ?>" type="checkbox" class="form-check-input" value="<?= $i->id?>" ></td>
                            <td><input type="hidden" name="so_no<?= $count ?>" value="<?= $p->so_no ?>"><?= $p->so_no ?></td>
                            <td><input type="hidden" name="delivery_date<?= $count ?>" value="<?= date('Y-m-d',strtotime($p->del_date)) ?>"><?= date('Y-m-d',strtotime($p->del_date)) ?></td>
                            <td><input type="hidden" name="date<?= $count ?>" value="<?= date('Y-m-d',strtotime($p->date)) ?>"><?= date('Y-m-d',strtotime($p->date)) ?></td>
                            <td>PR<?= $p->id ?></td>
                            <td><input type="hidden" name="part_no<?= $count ?>" value="<?= $i->eng->partNo?>"><?= $i->eng->partNo?></td>
                            <td><input type="hidden" name="part_name<?= $count ?>" value="<?= $i->eng->partName?>"><?= $i->eng->partName?></td>
                            <td><input type="hidden" name="supplier_name<?= $count ?>" value="<?= $i->supplier_name->name?>"><?= $i->supplier_name->name?></td>
                            <td><input type="hidden" name="supplier_name<?= $count ?>" value="<?= $i->order_qty?>"><?= $i->order_qty?></td>
                            <td><input type="hidden" name="supplier_name<?= $count ?>" value="<?= $i->total?>"><?= $i->total?></td>
                            <td></td>
                            <td></td>
                        </tr>
                            <input type="hidden" name="mover" value="<?= $p->model .' (' . $p->version . ') '?>">
                            <input type="hidden" name="customer" value="<?= $p->customer ?>">
                            <input type="hidden" name="count" value="<?=$count?>">
                        <?php endforeach;endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-sm-offset-8 col-sm-4 col-xs-12">
                <div class="prepareted-by-csn">
                    <button class="button btn btn-info">Generate PO</button>
                </div>
            </div>
        </form>
        </div>
    </div>