<?php include('./constant/layout/head.php');?>
<?php include('./constant/layout/header.php');?>

<?php include('./constant/layout/sidebar.php');?>

<?php include('./constant/connect.php');
 $user=$_SESSION['userId'];
$sql = "SELECT order_id, order_date, client_name, client_contact, grand_total, paid, payment_status FROM orders WHERE order_status = 1 AND user_id = '$user'";
$result = $connect->query($sql);

//echo $sql;exit;

    //echo $itemCountRow;exit; 
?>
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary"> View Invoice</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">View Invoice</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">                

        <div class="card">
            <div class="card-body">                              
                <a href="add-order.php"><button class="btn btn-primary">Add Invoice</button></a>
                <a href="all_download_client_invoice_pdf.php"><button class="btn btn-primary">Download Pdf</button></a>
                <div class="table-responsive m-t-40">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Invoice no.</th>
                                <th>Invoice Date</th>
                                <th>Client Name</th>
                                <th>Contact</th>
                                <th>Total Invoice amt</th>
                                <th>Paid</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $row) { ?>
                                <tr>
                                    <td><?php echo $row['order_id'] ?></td>
                                    <td><?php echo $row['order_date'] ?></td>
                                    <td><?php echo $row['client_name'] ?></td>
                                    <td><?php echo $row['client_contact'] ?></td>
                                    <td><?php echo $row['grand_total'] ?></td> 
                                    <td><?php echo $row['paid'] ?></td> 
                                    <td><?php  
                                        if ($row['payment_status'] == 1) {
                                            echo "<label class='label label-success'><h4>Full Payment</h4></label>";
                                        } elseif ($row['payment_status'] == 2) {
                                            echo "<label class='label label-danger'><h4>Advance Payment</h4></label>";
                                        } else {
                                            echo "<label class='label label-warning'><h4>No Payment</h4></label>";
                                        } 
                                    ?></td>
                                    <td>
                                        
                                        <a href='download_client_invoice_pdf.php?id=<?php echo $row['order_id']?>' ><button type='button' class='btn btn-xs btn-success'><i class='fa fa-download'></i></button></a>
                                        <a href="editorder.php?id=<?php echo $row['order_id']?>"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></button></a>
                                        <a href="php_action/removeOrder.php?id=<?php echo $row['order_id']?>" ><button type="button" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this record?')"><i class="fa fa-trash"></i></button></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php include('./constant/layout/footer.php');?>
        <script>
            $(document).ready(function() {
                if ($.fn.DataTable.isDataTable('#myTable')) {
                    $('#myTable').DataTable().destroy();
                }

                $('#myTable').DataTable({
                    searching: true,
                    // Other DataTables options...
                });
            });
        </script>
    </div>
</div>
