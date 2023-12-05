<?php
// Check if an ID is provided for deletion
if (isset($_GET["id"])) {
    $id = $_GET["id"];
 
    // Delete user from tblAccounts
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "BlogSite";
 
    $conn = new mysqli($servername, $username, $password, $dbname);
 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
 
    $sql = "DELETE FROM tblAccounts WHERE id=$id";
 
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
 
    $conn->close();
} else {
    echo "Invalid request.";
}
?>