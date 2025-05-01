<!DOCTYPE html>
<html>
<head>
    <title>Clientwise Report</title>
    <style>
        /* Your existing CSS styles */
        body {
            font-family: Arial, sans-serif;
        }
        h2 {
            color: #333;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
        }
        /* Style for the "Download as PDF" button */
        #pdfForm input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        #pdfForm input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<!-- Search Form -->
<form id="searchForm" action="" method="post">
    <label for="clientName">Client Name:</label>
    <input type="text" id="clientName" name="clientName">
    <input type="submit" value="Search">
</form>

<?php 
require_once 'core.php';
if($_POST) {
    $clientName = $_POST['clientName'];

    $sql = "SELECT * FROM orders WHERE client_name LIKE '%$clientName%' AND order_status = 1";
    $query = $connect->query($sql);

    // Start building the HTML table with CSS styling
    $table = '
        <h2>Clientwise Report</h2>
        <!-- Table -->
        <table id="orderTable">
            <!-- Table header -->
            <tr>
                <th>Invoice No.</th>
                <th>Order Date</th>
                <th>Client Name</th>
                <th>Contact</th>
                <th>Grand Total</th>
            </tr>';

    $totalAmount = 0;
    while ($result = $query->fetch_assoc()) {
        // Add table rows with order data
        $table .= '<tr>
            <td>'.$result['order_id'].'</td>
            <td>'.$result['order_date'].'</td>
            <td>'.$result['client_name'].'</td>
            <td>'.$result['client_contact'].'</td>
            <td>'.$result['grand_total'].'</td>
        </tr>';    
        $totalAmount += $result['grand_total'];
    }

    // Add the total row to the table
    $table .= '
        <tr class="total-row">
            <td colspan="4">Total Amount</td>
            <td>'.$totalAmount.'</td>
        </tr>
    </table>';

    // Display the HTML table
    echo $table;
    ?>
    <!-- Download PDF button -->
    <form id="pdfForm" action="report_pdf_download.php" method="post">
        <input type="hidden" name="htmlContent" value="<?php echo htmlspecialchars($table); ?>">
        <input type="submit" value="Download as PDF">
    </form>
<?php
}
?>
</body>
</html>
