<?php
// Include your database connection
$servername = "localhost"; // Assuming your database is on the same server
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "store1"; // Replace with your database name

// Create connection
$connect = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// Get the input from the client
$q = $_GET['q'];

// Query the database for client names and contact numbers that match the input
$sql = "SELECT client_name, client_contact FROM orders WHERE client_name LIKE '%$q%'";
$result = $connect->query($sql);

// Fetch client names and contact numbers and return them as suggestions
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Echo out suggestion with both client name and contact number
        echo "<div onclick='setSuggestionValue(\"" . $row['client_name'] . "\", \"" . $row['client_contact'] . "\")'>" . $row['client_name'] . "</div>";
    }
} else {
    echo "<div>No suggestions found</div>";
}

// Close the database connection
$connect->close();
?>
