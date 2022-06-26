<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Mission Transit, LLC</title>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet">
<style>
body { margin: 0; padding: 0; }
#customerTblDiv {
    width: 100%; 
    height: 80vh;
    overflow-x: auto;
    overflow-y: auto;
}
#customerTbl {
    width: 100%;
}
#customerTbl th, td {
    text-align: center; 
    vertical-align: middle;
}
</style>
</head>
<body>

<div class="container" style="max-width: 90%;">
    <div style="margin-top: 10px; height: 100px; padding-top: 10px;">
        <h1 style="color: darkgray; text-align: center;">Customer Table</h1>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12" id="customerTblDiv" style="">
            <div class="form-group">
                <a class="btn btn-primary float-right" href="<?php echo base_url(); ?>customer"><i class="fa fa-info-circle"></i> Customer Form</a>
            </div>
            <table class="table table-striped table-bordered table-responsive table-hover" id="customerTbl">
                <thead>
                    <tr>
                        <th colspan="3"></th>
                        <th colspan="4">Starting Address</th>
                        <th colspan="4">Ending Address</th>
                        <th colspan="3"></th>
                    </tr>
                    <tr>
                        <th>Payment<br> Status</th>
                        <th>QR-CODE <br>Reference</th>
                        <th>User Email</th>
                        <th>Street <br>Address</th>
                        <th>City/<br>Burrough</th>
                        <th>State</th>
                        <th>Zip Code</th>
                        <th>Street <br>Address</th>
                        <th>City/<br>Burrough</th>
                        <th>State</th>
                        <th>Zip Code</th>
                        <th>I must be at<br> work by</th>
                        <th>I get off<br> work at</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($allCustomers)){
                    foreach($allCustomers as $row){
                ?>
                    <tr>
                        <td><?php echo (intval($row->payment_status) == 0) ? "Not Paid" : "Paid"; ?></td>
                        <td><?php echo $row->qr_code_ref; ?></td>
                        <td><?php echo $row->user_email; ?></td>
                        <td><?php echo $row->street_addr1; ?></td>
                        <td><?php echo $row->city1; ?></td>
                        <td><?php echo $row->state1; ?></td>
                        <td><?php echo $row->zip_code1; ?></td>
                        <td><?php echo $row->street_addr2; ?></td>
                        <td><?php echo $row->city2; ?></td>
                        <td><?php echo $row->state2; ?></td>
                        <td><?php echo $row->zip_code2; ?></td>
                        <td><?php echo $row->at_work_by; ?></td>
                        <td><?php echo $row->off_work_at; ?></td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'customerEdit/'.$row->id; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-sm btn-danger deleteCustomer" href="#" data-userid="<?php echo $row->id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- <div class="card">
        <div class="card-body">
            <div class="row">
                
            </div>
        </div>
    </div> -->
</div>
<script>
    $(document).ready(function(){
        $("#customerTbl").DataTable({
            fixedHeader: true,
            dom: 'lBfrtip',
            buttons: [{
                extend: 'csv',
                text: 'Export to CSV',
                title: 'Customer Information',
                download: 'open',
                orientation:'landscape',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                },
                customize: function (csv) {
                    //Split the csv to get the rows
                    var split_csv = csv.split("\n");
                    var head0 = '"","","","","Starting Address","","","","Ending Address","","","",""';
                    split_csv.unshift(head0);
                    //Join the rows with line breck and return the final csv (datatables will take the returned csv and process it)
                    csv = split_csv.join("\n");
                    return csv;
                }
            }]
        });

        $(".deleteCustomer").click(function(){
            var customerId = $(this).data("userid");
            var currentRow = $(this);
            var post_url = "<?php echo base_url(); ?>deleteCustomer";
            var confirmation = confirm("Are you sure to delete this customer information?");
            if(confirmation){
                $.post(
                    post_url,
                    {
                        customerId: customerId
                    },
                    function(res) {
                        if (res == "success"){
                            alert("You have deleted the customer information successfully!");
                            currentRow.parents('tr').remove();
                        } else {
                            alert("You can not delete the customer information! Please contact the developer.");
                        }
                    }
                );
            }
        });

        $(window).resize(function(){
            $("#customerTbl").css("width", "100%");
        });
    });
</script>

</body>
</html>