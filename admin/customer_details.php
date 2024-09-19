<?php
include("adminheader.php");


$sql = "SELECT * FROM users ORDER BY userid DESC";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();
?>
<br>
<br>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Customer Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-image: url('images/bg2.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #fff;
            text-shadow: 2px 2px 4px #000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
           
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            background-color: #1A5319;
            color: white;
            padding: 15px;
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn {
            display: inline-block;
            padding: 20px 0px;
            margin: 20px 0px;
            text-decoration: none;
            background-color: #1A5319;
            color: white;
            border-radius: 10px;
            text-align: center;
            line-height: 10px;
           
        }
        .btn:hover {
            background-color: #000000;
        }
    </style>
</head>
<body style="background-image: url('../images/bg2.jpg'); background-repeat: no-repeat; background-size: cover;">
    <h1>Customer Data</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Full Name</th>
            <th>Last Name</th>
            <th>Contact</th>
            <th>Role</th>
        </tr>
        <?php
        if (!empty($data)) {
            foreach ($data as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['userid']) . "</td>";
                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
                echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
                echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No data available</td></tr>";
        }
        ?>
    </table>
</body>
</html>
