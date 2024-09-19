<?php
include("adminheader.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Admin</title>
</head>
<body style="background-image: url('../images/bg2.jpg'); background-repeat: no-repeat; background-size: cover;">
<ul class="cards">
  <li class="cards__item">
    <div class="card">
    <div class="card__image" style="background-image: url('../images/admin1.jpg');"></div>
      <div class="card__content">
        <div class="card__title">Customer Details</div>
        <p class="card__text">All the Personal Information About The Registered Customers And Users Are Listed Here.</p>
        <button class="btn btn--block card__btn"><a href="customer_details.php">Details</a></button>
      </div>
    </div>
  </li>
  <li class="cards__item">
    <div class="card">
    <div class="card__image" style="background-image: url('../images/admin3.jpg');"></div>
      <div class="card__content">
        <div class="card__title">Data Tracking</div>
        <p class="card__text">Real-Time Data Tracking On Water Usage And System Efficiency.</p>
        <button class="btn btn--block card__btn"><a href="water.php">Real time data</a></button>
      </div>
    </div>
  </li>
  <li class="cards__item">
    <div class="card">
    <div class="card__image" style="background-image: url('../images/admin2.jpg');"></div>
      <div class="card__content">
        <div class="card__title">Graph</div>
        <p class="card__text">Real-Time Data TrackingVisual Represenation and Detailed Reports on Water Usage.</p>
        <button class="btn btn--block card__btn"><a href="graph.php">Visual Representation</a></button>
      </div>
    </div>
  </li>
</ul>
</body>
</html>
