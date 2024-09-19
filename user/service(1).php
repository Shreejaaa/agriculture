<?php
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/service.css">
    <title>Service</title>
</head>
<body  style="background-image: url('../images/bg2.jpg')";>
<ul class="cards">
  <li class="cards__item">
    <div class="card">
    <div class="card__image" style="background-image: url('../images/img1.jpg');"></div>

      <div class="card__content">
        <div class="card__title">Service 1</div>
        <p class="card__text">Development Of Personalized Watering Schedules Based On Soil, Plant, And Climate Data.</p>
        <button class="btn btn--block card__btn"><a href="forecast.php">Forecast</a></button>
      </div>
    </div>
  </li>
  <li class="cards__item">
    <div class="card">
    <div class="card__image" style="background-image: url('../images/img3.jpg');"></div>

      <div class="card__content">
        <div class="card__title">Service 2</div>
        <p class="card__text">Real-Time Data Tracking And Detailed Reports On Water Usage And System Efficiency.</p>
        <button class="btn btn--block card__btn"><a href="water_tracking.php">Real time data</a></button>
      </div>
    </div>
  </li>
</ul>
</body>
</html>
