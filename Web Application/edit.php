<?php
// Check if an ID is provided
if (isset($_GET["id"])) {
    $id = $_GET["id"];
 
    // Fetch user data based on ID from tblAccounts
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "BlogSite";
 
    $conn = new mysqli($servername, $username, $password, $dbname);
 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
 
    $sql = "SELECT id, username, email FROM tblAccounts WHERE id = $id";
    $result = $conn->query($sql);
 
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row["username"];
        $email = $row["email"];
 
        // Display a form to edit user data
        echo "<form action='update.php' method='post'>
                <input type='hidden' name='id' value='$id'>
                <label for='username'>Username:</label>
                <input type='text' name='username' value='$username' required><br>
 
                <label for='email'>Email:</label>
                <input type='email' name='email' value='$email' required><br>
 
                <input type='submit' value='Update'>
            </form>";
    } else {
        echo "User not found.";
    }
 
    $conn->close();
} else {
    echo "Invalid request.";
}
?>