<?php
include("../admin_and_user/connection.php");
session_start();
if(!isset($_SESSION['username'])){
    header("Location:../admin_and_user/signin_up.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['water_used'])) {
    $city = htmlspecialchars($_POST['city']);
    $plant = htmlspecialchars($_POST['plant']);
    $water_used = floatval($_POST['water_used']);
    $user_id = $_SESSION['customer_id']; // Retrieve user_id from session

    $sql = "INSERT INTO water_usage (city, plant, water_used, user_id) VALUES ('$city', '$plant', $water_used, $user_id)";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Usage Tracking</title>
    <link rel="stylesheet" href="../css/water_tracking.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function trackWaterUsage() {
            const city = $("#city").val();
            const plant = $("#plant").val();
            const waterUsed = $("#water_used").val();

            $.post("", { city: city, plant: plant, water_used: waterUsed }, function(response) {
                alert(response);
                fetchWaterUsageData();
            });
        }

        function fetchWaterUsageData() {
            $.get("fetch_water_usage.php", function(response) {
                const data = JSON.parse(response);
                let tableContent = "<tr><th>City</th><th>Plant</th><th>Water Used (L)</th><th>Timestamp</th></tr>";
                data.forEach(row => {
                    tableContent += `<tr><td>${row.city}</td><td>${row.plant}</td><td>${row.water_used}</td><td>${row.timestamp}</td></tr>`;
                });
                $("#data-table").html(tableContent);
            });
        }

        $(document).ready(function() {
            fetchWaterUsageData();
        });
    </script>
</head>
<body style="background-image: url('../images/bg2.jpg'); background-repeat: no-repeat; background-size: cover;">


<h1>Water Usage Tracking</h1>
<form method="POST" onsubmit="trackWaterUsage(); return false;">
    <label for="city">Enter your city:</label>
    <input type="text" id="city" name="city" required><br>

    <label for="plant">Select the plant you have planted:</label>
    <select id="plant" name="plant" required>
        <option value="lettuce">Lettuce</option>
        <option value="spinach">Spinach</option>
        <option value="peas">Peas</option>
        <option value="tomatoes">Tomatoes</option>
        <option value="peppers">Peppers</option>
        <option value="cucumbers">Cucumbers</option>
        <option value="okra">Okra</option>
        <option value="sweet potatoes">Sweet Potatoes</option>
        <option value="watermelon">Watermelon</option>
        <option value="broccoli">Broccoli</option>
        <option value="cauliflower">Cauliflower</option>
        <option value="radishes">Radishes</option>
        <option value="kale">Kale</option>
        <option value="brussels_sprouts">Brussels Sprouts</option>
        <option value="eggplants">Eggplants</option>
        <option value="zucchini">Zucchini</option>
        <option value="beans">Beans</option>
        <option value="squash">Squash</option>
        <option value="corn">Corn</option>
        <option value="melons">Melons (Cantaloupe, Honeydew)</option>
        <option value="pumpkins">Pumpkins</option>
        <option value="hot_peppers">Hot Peppers (Jalapeño, Habanero)</option>
        <option value="amaranth">Amaranth</option>
        <option value="cassava">Cassava</option>
        <option value="habanero">Habanero</option>
    </select><br>

    <label for="water_used">Enter water used (liters):</label>
    <input type="number" id="water_used" name="water_used" step="0.01" required><br>

    <input type="submit" value="Track Water Usage"><br><br>
    <input type="button" value="BACK" 
       style="background-color: #000000; border: none; color: white; padding: 5px 10px; text-align: center; text-decoration: none; display: inline-block; font-size: 13px; margin: 4px 2px; cursor: pointer; border-radius: 5px;"
       onclick="window.location.href='service.php'">


</form>


</body>
</html>
