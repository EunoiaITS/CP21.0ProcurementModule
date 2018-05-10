<div class="planner-from">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-sm-12">
                <div class="part-title-planner text-uppercase text-center"><b>Procurement Order List</b></div>
            </div>

            <div class="clearfix"></div>
            <!--============== Add drawing table area ===================-->
            <div class="planner-table table-responsive clearfix">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>PR No</th>
                            <th>PO Date</th>
                            <th>PO No</th>
                            <th>Part No</th>
                            <th>Description</th>
                            <th>Supplier</th>
                            <th>QTY Request</th>
                            <th>Extra 10%</th>
                            <th>Total</th>
                            <th>Create By</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Inform Supply</th>
                            <th>Delivery Type</th>
                            <th>Document</th>
                            <th>Remark</th>
                        </tr>
                        </thead>
                        <tbody class="csn-text-up">
                        <tr>
                            <td>PR12345</td>
                            <td>3/10/20167</td>
                            <td>PO12345</td>
                            <td>0001</td>
                            <td>Conduct Piece Assembly</td>
                            <td>Gulf</td>
                            <td>1000</td>
                            <td>100</td>
                            <td>$ 4,558.00</td>
                            <td>Azlin</td>
                            <td>Procurement</td>
                            <td>Approve</td>
                            <td>Yes</td>
                            <td>
                                <select class="form-control" name="del-type" id="del-type">
                                    <option>Please select...</option>
                                    <option value="Plan"><a href="#">Plan</a></option>
                                    <option value="Complete">Complete</option>
                                </select>
                                <div class="clearfix" id="mds"></div>
                            </td>
                            <td><a href="#">View</a></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>0002</td>
                            <td>Drive bar Assembly</td>
                            <td>Gulf</td>
                            <td>800</td>
                            <td>80</td>
                            <td>$ 7,800.00</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Complete</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>PR123458</td>
                            <td>15/10/2017</td>
                            <td>P0123456</td>
                            <td></td>
                            <td>Desktop For Production</td>
                            <td>Vsc</td>
                            <td>1</td>
                            <td></td>
                            <td>$ 2,870.00</td>
                            <td>Amira</td>
                            <td>Procurement</td>
                            <td>Approve</td>
                            <td>Pending</td>
                            <td>Complete</td>
                            <td><a href="#">View</a></td>
                            <td></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#del-type').on('change', function(e){
            e.preventDefault();
            var sel = $('#del-type :selected').val();
            if(sel === 'Plan'){
                $('#mds').html('<a href="#">Plan</a>');
            }else{
                $('#mds').html('');
            }
        });
    });
</script>
