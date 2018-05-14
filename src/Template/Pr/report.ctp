<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Purchase Requesition Report</b></div>
            </div>

            <div class="clearfix"></div>
            <!--============== Add drawing table area ===================-->
            <div class="planner-table table-responsive clearfix">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Serial</th>
                            <th>SO NO</th>
                            <th>Delivery Date</th>
                            <th>PR Date</th>
                            <th>PR No</th>
                            <th>Part No</th>
                            <th>Description</th>
                            <th>Supplier</th>
                            <th>QTY Request</th>
                            <th>Total</th>
                            <th>Create By</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Document</th>
                            <th>Date</th>
                            <th>PO Status</th>
                            <th>Remark</th>
                        </tr>
                        </thead>
                        <tbody class="csn-text-up">
                        <?php $count = 0; foreach ($pr as $p): foreach ($p->items as $i): $count++;?>
                        <tr>
                            <td><?= $count?></td>
                            <td>SO12345</td>
                            <td>11/12/2017</td>
                            <td>3/10/2017</td>
                            <td>PR12345</td>
                            <td>0001</td>
                            <td>Conduct Piece Assembly</td>
                            <td>Gulf</td>
                            <td>1000</td>
                            <td>$ 4,558.00</td>
                            <td>Azlin</td>
                            <td>Procurement</td>
                            <td >Approve</td>
                            <td><a href="#">View</a></td>
                            <td></td>
                            <td class="colored-csn">Create</td>
                            <td></td>
                        </tr>
                        <?php endforeach;endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>