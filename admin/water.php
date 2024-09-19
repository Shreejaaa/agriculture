<?php
include("adminheader.php");

$sql = "SELECT * FROM water_usage ORDER BY timestamp DESC";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}


?>
<br>
<br>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Usage Tracking - Admin View</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-image: url('../images/bg2.jpg');
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
            background-color: #45a049;
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
<body>
    <br>
    <h1>Detailed Reports On Water Usage And System Efficiency</h1>
    <a href="graph.php" class="btn">Graph Display</a>
    <table>
        <tr>
            <th>City</th>
            <th>Plant</th>
            <th>Water Used (L)</th>
            <th>Timestamp</th>
            <th>User</th>
            <th>Detailed Report</th>
        </tr>
        <?php
        include("../admin_and_user/connection.php");

        $query = "SELECT w.city, w.plant, w.water_used, w.timestamp, u.username
                  FROM water_usage w 
                  INNER JOIN users u ON w.user_id = u.userid";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['city']) . "</td>";
                echo "<td>" . htmlspecialchars($row['plant']) . "</td>";
                echo "<td>" . htmlspecialchars($row['water_used']) . "</td>";
                echo "<td>" . htmlspecialchars($row['timestamp']) . "</td>";
                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                echo "<td>";
                // Generate a simple example report (can be customized based on your needs)
                $detailedReport = "Water used in " . htmlspecialchars($row['city']) . " for planting " . htmlspecialchars($row['plant']) . " by ". htmlspecialchars($row['username']) . " is about ". htmlspecialchars($row['water_used']) . " liters.";
                echo $detailedReport;
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No data available</td></tr>";
        }
        mysqli_close($conn);
        ?>
    </table>
</body>
</html>
