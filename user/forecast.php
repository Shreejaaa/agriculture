<?php
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Forecast and Planting Suggestions</title>
    <link rel="stylesheet" href="../css/forecast.css">
</head>
<body style="background-image: url('../images/bg2.jpg'); background-repeat: no-repeat; background-size: cover;">


<h1>Weather Forecast and Planting Suggestions</h1>

<form method="post">
    <label for="city">Enter your city:</label>
    <input type="text" id="city" name="city" value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; ?>" required><br><br>

    
    <label for="plant">Select the plant you have planted:</label>
    <select id="plant" name="plant" required>
    <option value="lettuce" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'lettuce') echo 'selected'; ?>>Lettuce</option>
        <option value="spinach" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'spinach') echo 'selected'; ?>>Spinach</option>
        <option value="peas" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'peas') echo 'selected'; ?>>Peas</option>
        <option value="tomatoes" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'tomatoes') echo 'selected'; ?>>Tomatoes</option>
        <option value="peppers" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'peppers') echo 'selected'; ?>>Peppers</option>
        <option value="cucumbers" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'cucumbers') echo 'selected'; ?>>Cucumbers</option>
        <option value="okra" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'okra') echo 'selected'; ?>>Okra</option>
        <option value="sweet potatoes" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'sweet potatoes') echo 'selected'; ?>>Sweet Potatoes</option>
        <option value="watermelon" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'watermelon') echo 'selected'; ?>>Watermelon</option>
        <option value="broccoli" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'broccoli') echo 'selected'; ?>>Broccoli</option>
        <option value="cauliflower" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'cauliflower') echo 'selected'; ?>>Cauliflower</option>
        <option value="radishes" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'radishes') echo 'selected'; ?>>Radishes</option>
        <option value="kale" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'kale') echo 'selected'; ?>>Kale</option>
        <option value="brussels_sprouts" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'brussels_sprouts') echo 'selected'; ?>>Brussels Sprouts</option>
        <option value="eggplants" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'eggplants') echo 'selected'; ?>>Eggplants</option>
        <option value="zucchini" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'zucchini') echo 'selected'; ?>>Zucchini</option>
        <option value="beans" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'beans') echo 'selected'; ?>>Beans</option>
        <option value="squash" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'squash') echo 'selected'; ?>>Squash</option>
        <option value="corn" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'corn') echo 'selected'; ?>>Corn</option>
        <option value="melons" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'melons') echo 'selected'; ?>>Melons (Cantaloupe, Honeydew)</option>
        <option value="pumpkins" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'pumpkins') echo 'selected'; ?>>Pumpkins</option>
        <option value="hot_peppers" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'hot_peppers') echo 'selected'; ?>>Hot Peppers (Jalapeño, Habanero)</option>
        <option value="amaranth" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'amaranth') echo 'selected'; ?>>Amaranth</option>
        <option value="cassava" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'cassava') echo 'selected'; ?>>Cassava</option>
        <option value="habanero" <?php if(isset($_POST['plant']) && $_POST['plant'] == 'habanero') echo 'selected'; ?>>Habanero</option>
    </select>
    <br><br>
    
    <input type="submit" value="Get Weather and Suggestions">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $apiKey = "6ac3ad55a10cf3a9ff4c5409971ee30d";
    $city = htmlspecialchars($_POST['city']);
    $plant = htmlspecialchars($_POST['plant']);
    $apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response === FALSE) {
        die('Error occurred');
    }

    $data = json_decode($response, true);

    if ($data['cod'] != 200) {
        echo "<p>City not found</p>";
        exit();
    }

    $temperature = $data['main']['temp'];
    $weather = $data['weather'][0]['description'];
    $humidity = $data['main']['humidity'];
    $windSpeed = $data['wind']['speed'];

    echo "<table>";
    echo "<tr><th colspan='2'>Weather in $city</th></tr>";
    echo "<tr><td>Temperature:</td><td>" . $temperature . "°C</td></tr>";
    echo "<tr><td>Weather:</td><td>" . ucfirst($weather) . "</td></tr>";
    echo "<tr><td>Humidity:</td><td>" . $humidity . "%</td></tr>";
    echo "<tr><td>Wind Speed:</td><td>" . $windSpeed . " m/s</td></tr>";

    echo "<tr><th colspan='2'>Agricultural Recommendations</th></tr>";
    if ($temperature < 20) {
        echo "<tr><td colspan='2'>Suitable for planting cool-season crops like lettuce, spinach, and peas.</td></tr>";
    } elseif ($temperature >= 20 && $temperature <= 30) {
        echo "<tr><td colspan='2'>Suitable for planting warm-season crops like tomatoes, peppers, and cucumbers.</td></tr>";
    } else {
        echo "<tr><td colspan='2'>Suitable for planting heat-tolerant crops like okra, sweet potatoes, and watermelon.</td></tr>";
    }

    echo "<tr><th colspan='2'>Suggestions for your plant: $plant</th></tr>";

    switch ($plant) {
        case "lettuce":
        case "spinach":
        case "peas":
        case "broccoli":
        case "cauliflower":
        case "radishes":
        case "kale":
        case "brussels_sprouts":
            if ($temperature < 20) {
                echo "<tr><td colspan='2'>The current temperature is suitable for $plant.</td></tr>";
            } else {
                echo "<tr><td colspan='2'>The current temperature is not ideal for $plant. Consider shading or cooling methods.</td></tr>";
            }
            break;
        case "tomatoes":
        case "peppers":
        case "cucumbers":
        case "eggplants":
        case "zucchini":
        case "beans":
        case "squash":
        case "corn":
            if ($temperature >= 20 && $temperature <= 30) {
                echo "<tr><td colspan='2'>The current temperature is suitable for $plant.</td></tr>";
            } else {
                echo "<tr><td colspan='2'>The current temperature is not ideal for $plant. Consider appropriate adjustments.</td></tr>";
            }
            break;
        case "okra":
        case "sweet potatoes":
        case "melons":
        case "pumpkins":
        case "jalapeño":
        case "amaranth":
        case "cassava":
        case "habanero":
            if ($temperature > 30) {
                echo "<tr><td colspan='2'>The current temperature is suitable for $plant.</td></tr>";
            } else {
                echo "<tr><td colspan='2'>The current temperature is not ideal for $plant. Consider heating methods.</td></tr>";
            }
            break;
    }

    echo "<tr><th colspan='2'>Personalized Watering Schedule for $plant</th></tr>";

    switch ($plant) {
        case "lettuce":
        case "spinach":
        case "peas":
        case "broccoli":
        case "cauliflower":
        case "radishes":
        case "kale":
        case "brussels_sprouts":
            echo "<tr><td colspan='2'>Water 1-2 inches per week, preferably in the morning.</td></tr>";
            break;
        case "tomatoes":
        case "peppers":
        case "cucumbers":
        case "eggplants":
        case "zucchini":
        case "beans":
        case "squash":
        case "corn":
            echo "<tr><td colspan='2'>Water 1-1.5 inches per week, preferably in the morning or evening.</td></tr>";
            break;
        case "okra":
        case "sweet potatoes":
        case "melons":
        case "pumpkins":
        case "jalapeño":
        case "amaranth":
        case "cassava":
        case "habanero":
            echo "<tr><td colspan='2'>Water 1 inch per week, preferably in the early morning.</td></tr>";
            break;
    }

    if ($humidity < 30) {
        echo "<tr><td colspan='2'>Soil is dry, increase watering frequency for $plant.</td></tr>";
    } elseif ($humidity >= 30 && $humidity <= 60) {
        echo "<tr><td colspan='2'>Soil moisture is optimal, maintain current watering schedule for $plant.</td></tr>";
    } else {
        echo "<tr><td colspan='2'>Soil is very moist, reduce watering frequency for $plant.</td></tr>";
    }

    echo "</table>";
}
?>

</body>
</html>