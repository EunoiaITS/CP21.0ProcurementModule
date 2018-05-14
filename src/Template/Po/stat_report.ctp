<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Purchase Order Statistic Report Oct-17</b></div>
            </div>

            <div class="clearfix"></div>
            <!--============== Add drawing table area ===================-->
            <div class="planner-table table-responsive clearfix">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>No Of PO</th>
                            <th>Approve</th>
                            <th>Reject</th>
                            <th>Pending</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody class="csn-text-up">
                        <tr>
                            <td><?= $total ?></td>
                            <td><?= $approve ?></td>
                            <td><?= $reject ?></td>
                            <td><?= $request ?></td>
                            <td>$ <?= $po->total ?></td>
                        </tr>

                        <tr>
                            <td colspan="4">Grand Total</td>
                            <td>$ 371,188.15</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
