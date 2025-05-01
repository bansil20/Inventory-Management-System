<?php
require_once('./dompdf/autoload.inc.php');
use Dompdf\Dompdf;

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "store1";

// Check if the order ID is provided in the URL
if(isset($_GET['id'])) {
    // Extract the order ID
    $order_id = $_GET['id'];

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to fetch data for the specific order
    $sql = "SELECT * FROM orders WHERE order_id = $order_id";
    $result = $conn->query($sql);

    // Initialize Dompdf
    $dompdf = new Dompdf();

    // Set some content to display
    $html = '
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #333;
        }
        h1 {
            color: #007bff;
        }
        p {
            margin: 0;
            padding: 5px 0;
        }
        .order-details {
            margin: 20px 0;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .order-details p {
            font-size: 16px;
        }
        .order-details p:nth-child(odd) {
            background-color: #f9f9f9;
        }
    </style>
    <h1>Order Details</h1>';

    // Check if the order exists
    if ($result->num_rows > 0) {
        // Output data of the order
        $row = $result->fetch_assoc();

        // Add data to the HTML
        $html .= '
        <div class="order-details">
            <p><strong>Order ID:</strong> ' . $row["order_id"] . '</p>
            <p><strong>Order Date:</strong> ' . $row["order_date"] . '</p>
            <p><strong>Client Name:</strong> ' . $row["client_name"] . '</p>
            <p><strong>Client Contact:</strong> ' . $row["client_contact"] . '</p>
            <p><strong>Sub Total:</strong> ' . $row["sub_total"] . '</p>
            <p><strong>VAT:</strong> ' . $row["vat"] . '</p>
            <p><strong>Total Amount:</strong> ' . $row["total_amount"] . '</p>
            <p><strong>Discount:</strong> ' . $row["discount"] . '</p>
            <p><strong>Grand Total:</strong> ' . $row["grand_total"] . '</p>
            <p><strong>Paid:</strong> ' . $row["paid"] . '</p>
            <p><strong>Due:</strong> ' . $row["due"] . '</p>
            <p><strong>Payment Type:</strong> ' . $row["payment_type"] . '</p>
            <p><strong>Payment Status:</strong> ' . $row["payment_status"] . '</p>
            <p><strong>Payment Place:</strong> ' . $row["payment_place"] . '</p>
            <p><strong>GSTN:</strong> ' . $row["gstn"] . '</p>
            <p><strong>Order Status:</strong> ' . $row["order_status"] . '</p>
            <p><strong>User ID:</strong> ' . $row["user_id"] . '</p>
        </div>';

        // Load HTML content into Dompdf
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (output buffering)
        $dompdf->render();

        // Output the PDF to the browser with file name as order_id.pdf
        $dompdf->stream('order_'.$order_id.'.pdf');

    } else {
        echo "Order not found.";
    }

    // Close MySQL connection
    $conn->close();
} else {
    echo "Order ID not provided.";
}
?>
