<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Admin Dashboard</h2>
 
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
 
    // Fetch user accounts from tblAccounts
    $sql = "SELECT id, username, email FROM tblUserAccounts";
    $result = $conn->query($sql);
 
    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>";
 
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["username"] . "</td>
                    <td>" . $row["email"] . "</td>
                    <td>
                        <a href='edit.php?id=" . $row["id"] . "'>Edit</a> |
                        <a href='delete.php?id=" . $row["id"] . "'>Delete</a>
                    </td>
                </tr>";
        }
 
        echo "</table>";
    } else {
        echo "0 results";
    }
 
    $conn->close();
    ?>
</body>
</html>