<?php include('./constant/layout/head.php');?>
<?php include('./constant/layout/header.php');?>

<?php include('./constant/layout/sidebar.php');?>   
<?php include('./constant/connect.php');
$sql = "SELECT product_id, product_name, product_image, rate, quantity, brand_id, categories_id, active, status FROM product WHERE status = 1";
$result = $connect->query($sql);
//echo $sql;exit;

?>
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary"> View Product</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">View Product</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">                

        <div class="card">
            <div class="card-body">                              
                <a href="add-product.php"><button class="btn btn-primary">Add Product</button></a>
                <div class="table-responsive m-t-40">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th style="width:10%;">Photo</th>                           
                                <th>Product Name</th>
                                <th>Rate</th>                           
                                <th>Quantity</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($result as $row) {
                                // Initialize $row1 to null
                                $row1 = null;

                                // Fetch brand data
                                $sql_brand = "SELECT * FROM brands WHERE brand_id='".$row['brand_id']."'";
                                $result_brand = $connect->query($sql_brand);
                                if ($result_brand && $result_brand->num_rows > 0) {
                                    $row1 = $result_brand->fetch_assoc();
                                }
                                
                                // Fetch category data
                                $sql_category = "SELECT * FROM categories WHERE categories_id='".$row['categories_id']."'";
                                $result_category = $connect->query($sql_category);
                                if ($result_category && $result_category->num_rows > 0) {
                                    $row2 = $result_category->fetch_assoc();
                                }

                                ?>
                                <tr>
                                    <td><?php echo $row['product_id'] ?></td>
                                    <td><img src="assets/myimages/<?php echo $row['product_image'];?>" style="width: 80px; height: 80px;"></td>
                                    <td><?php echo $row['product_name'] ?></td>
                                    <td><?php echo $row['rate'] ?></td>
                                    <td><?php echo $row['quantity'] ?></td>
                                    <td><?php echo isset($row1['brand_name']) ? $row1['brand_name'] : '' ?></td>
                                    <td><?php echo isset($row2['categories_name']) ? $row2['categories_name'] : '' ?></td>
                                    <td><?php echo $row['active'] == 1 ? 'Available' : 'Not Available'; ?></td>
                                    <td>
                                        <a href="editproduct.php?id=<?php echo $row['product_id']?>"><button type="button" class="btn btn-xs btn-primary" ><i class="fa fa-pencil"></i></button></a>
                                        <a href="php_action/removeProduct.php?id=<?php echo $row['product_id']?>" ><button type="button" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this record?')"><i class="fa fa-trash"></i></button></a>
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
