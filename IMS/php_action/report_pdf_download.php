<?php
// Include the Dompdf library
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

try {
    // Create a Dompdf instance
    $dompdf = new Dompdf();

    // Retrieve HTML content from the POST request
    $html = $_POST['htmlContent'];

    if (empty($html)) {
        throw new Exception('HTML content is empty');
    }

    // CSS styles for the PDF
    $css = '
        <style>
            /* Add your CSS styles here */
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
            /* Add more CSS rules as needed */
        </style>';

    // Load HTML content with CSS into Dompdf
    $dompdf->loadHtml($css . $html);

    // Set paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the PDF
    $dompdf->render();

    // Output the PDF as a download
    $dompdf->stream('Datewise_Report.pdf', array('Attachment' => 1));
} catch (Exception $e) {
    // Handle any exceptions
    echo 'Error: ' . $e->getMessage();
}
?>