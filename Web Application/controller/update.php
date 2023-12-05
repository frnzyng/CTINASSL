<?php
// Process form submission for updating user data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $usernameNew = $_POST["username"];
    $emailNew = $_POST["email"];
 
    // Update user data in tblAccounts
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "BlogSite";
 
    $conn = new mysqli($servername, $username, $password, $dbname);
 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
 
    $sql = "UPDATE tblAccounts SET username='$usernameNew', email='$emailNew' WHERE id=$id";
 
    if ($conn->query($sql) === TRUE) {
        echo "Update successful!";
    } else {
        echo "Error updating record: " . $conn->error;
    }
 
    $conn->close();
}
?>