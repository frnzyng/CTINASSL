<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BlogSite";
 
$conn = new mysqli($servername, $username, $password, $dbname);
 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 
// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $email = $_POST["email"];
 
    // Insert user data into tblUserAccounts
    $sql = "INSERT INTO tblUserAccounts (username, password, email) VALUES ('$username', '$password', '$email')";
 
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
 
$conn->close();
?>