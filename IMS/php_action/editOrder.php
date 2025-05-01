<?php 	
require_once 'core.php';

$valid['success'] = false;
$valid['messages'] = array();

if($_POST) {	
	$orderId = $_POST['orderId'];

	$orderDate = date('Y-m-d', strtotime($_POST['orderDate']));
	$clientName = $_POST['clientName'];
	$clientContact = $_POST['clientContact'];
	$subTotalValue = $_POST['subTotalValue'];
	$vatValue =	$_POST['vatValue'];
	$totalAmountValue = $_POST['totalAmountValue'];
	$discount = $_POST['discount'];
	$grandTotalValue = $_POST['grandTotalValue'];
	$paid = $_POST['paid'];
	$dueValue = $_POST['dueValue'];
	$paymentType = $_POST['paymentType'];
	$paymentStatus = $_POST['paymentStatus'];
	$paymentPlace = $_POST['paymentPlace'];
	$gstn = $_POST['gstn'];
	$userId = $_SESSION['userId'];
				
	$sql = "UPDATE orders SET order_date = '$orderDate', client_name = '$clientName', client_contact = '$clientContact', sub_total = '$subTotalValue', vat = '$vatValue', total_amount = '$totalAmountValue', discount = '$discount', grand_total = '$grandTotalValue', paid = '$paid', due = '$dueValue', payment_type = '$paymentType', payment_status = '$paymentStatus', order_status = 1, user_id = '$userId', payment_place = '$paymentPlace', gstn = '$gstn' WHERE order_id = {$orderId}";	
	$connect->query($sql);
	
	// Check if the "totalValue" field is set and not empty
	if(isset($_POST['totalValue']) && !empty($_POST['totalValue'])) {
		$readyToUpdateOrderItem = false;
		
		// Add the quantity from the order item to product table
		for($x = 0; $x < count($_POST['productName']); $x++) {
			// Fetch data from product table
			$updateProductQuantitySql = "SELECT product.quantity FROM product WHERE product.product_id = ".$_POST['productName'][$x]."";
			$updateProductQuantityData = $connect->query($updateProductQuantitySql);			
			
			while ($updateProductQuantityResult = $updateProductQuantityData->fetch_row()) {
				// Fetch data from order item table
				$orderItemTableSql = "SELECT order_item.quantity FROM order_item WHERE order_item.order_id = {$orderId}";
				$orderItemResult = $connect->query($orderItemTableSql);
				$orderItemData = $orderItemResult->fetch_row();

				// Update quantity in product table
				$editQuantity = $updateProductQuantityResult[0] + $orderItemData[0];							
				$updateQuantitySql = "UPDATE product SET quantity = $editQuantity WHERE product_id = ".$_POST['productName'][$x]."";
				$connect->query($updateQuantitySql);		
			} // while	
		
			if(count($_POST['productName']) == count($_POST['productName'])) {
				$readyToUpdateOrderItem = true;			
			}
		} // for quantity

		// Remove the order item data from order item table
		for($x = 0; $x < count($_POST['productName']); $x++) {			
			$removeOrderSql = "DELETE FROM order_item WHERE order_id = {$orderId}";
			$connect->query($removeOrderSql);	
		} // for quantity

		if($readyToUpdateOrderItem) {
			// Insert the order item data 
			for($x = 0; $x < count($_POST['productName']); $x++) {			
				$updateProductQuantitySql = "SELECT product.quantity FROM product WHERE product.product_id = ".$_POST['productName'][$x]."";
				$updateProductQuantityData = $connect->query($updateProductQuantitySql);
				
				while ($updateProductQuantityResult = $updateProductQuantityData->fetch_row()) {
					$updateQuantity[$x] = $updateProductQuantityResult[0] - $_POST['quantity'][$x];							
					// Update product table
					$updateProductTable = "UPDATE product SET quantity = '".$updateQuantity[$x]."' WHERE product_id = ".$_POST['productName'][$x]."";
					$connect->query($updateProductTable);

					// Insert into order_item
					$orderItemSql = "INSERT INTO order_item (order_id, product_id, quantity, rate, total, order_item_status) 
					VALUES ({$orderId}, '".$_POST['productName'][$x]."', '".$_POST['quantity'][$x]."', '".$_POST['rateValue'][$x]."', '".$_POST['totalValue'][$x]."', 1)";

					$connect->query($orderItemSql);		
				} // while	
			} // for quantity
		}
	}

	$valid['success'] = true;
	$valid['messages'] = "Successfully Updated";		
	$connect->close();
	header('location:'.$_SERVER['HTTP_REFERER']);

	echo json_encode($valid);
} // /if $_POST
