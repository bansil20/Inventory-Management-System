
<?php

require_once('./dompdf/autoload.inc.php');
use Dompdf\Dompdf;

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "store1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data from the orders table
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

// Initialize Dompdf
$dompdf = new Dompdf();

// Set some content to display
$html = '<h1>Orders Report</h1>';

// Check if there are orders in the database
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // Add data to the HTML
        $html .= '<div style="margin-bottom: 20px;">';
        $html .= '<p><strong>Order ID:</strong> ' . $row["order_id"] . '</p>';
        $html .= '<p><strong>Order Date:</strong> ' . $row["order_date"] . '</p>';
        $html .= '<p><strong>Client Name:</strong> ' . $row["client_name"] . '</p>';
        $html .= '<p><strong>Client Contact:</strong> ' . $row["client_contact"] . '</p>';
        $html .= '<p><strong>Grand Total:</strong> ' . $row["grand_total"] . '</p>';
        $html .= '<p><strong>Paid:</strong> ' . $row["paid"] . '</p>';
    
        $html .= '</div>';
        // Add spacing between orders
        $html .= '<hr>';
    }
} else {
    $html .= '<p>No orders found.</p>';
}

// Load HTML content into Dompdf
$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render PDF (output buffering)
$dompdf->render();

// Output the PDF to the browser
$dompdf->stream('orders_report.pdf');

// Close MySQL connection
$conn->close();
?>