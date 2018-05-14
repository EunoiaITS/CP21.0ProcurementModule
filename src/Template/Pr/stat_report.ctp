<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>PR Statistic Report</b></div>
            </div>

            <div class="clearfix"></div>
            <!--============== Add drawing table area ===================-->
            <div class="planner-table table-responsive clearfix">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Department</th>
                            <th>No Of PR</th>
                            <th>Approve</th>
                            <th>Reject</th>
                            <th>Pending</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody class="csn-text-up">
                        <tr>
                            <td>Procurement</td>
                            <td><?= $total ?></td>
                            <td><?= $approve ?></td>
                            <td><?= $reject ?></td>
                            <td><?= $request ?></td>
                            <td>$<?= $am->amount ?></td>
                        </tr>
                        <tr>
                            <td colspan="5">Grand Total</td>
                            <td>$ 379,043.80</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
