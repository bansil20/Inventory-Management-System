<style>
    .img_bg{
        background-image: url("img_tree.gif");
  background-repeat: no-repeat;
  background-attachment: fixed;
  width: 100%;
  height: 100%;
    }
</style>
<?php error_reporting(1); ?>
<?php include('./constant/layout/head.php');?>
<?php include('./constant/layout/header.php');?>

<?php include('./constant/layout/sidebar.php');?>   
<?php 


$lowStockSql = "SELECT * FROM product WHERE quantity <= 3 AND status = 1";
$lowStockQuery = $connect->query($lowStockSql);
$countLowStock = $lowStockQuery->num_rows;


$connect->close();

?>
  
<style type="text/css">
    .ui-datepicker-calendar {
        display: none;
    }
</style>
        
        <div class="page-wrapper">
        <img src="./dashboard_img.jpg" class="img_bg">
            
    </div>
    <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                 
            <?php }?>

            </div>
        </div>
    </div>

            
            <?php include ('./constant/layout/footer.php');?>
        <script>
        $(function(){
            $(".preloader").fadeOut();
        })
        </script>