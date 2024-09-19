<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Usage Charts</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 200px;
        }
        .chart-container {
            width: 45%;
            float: left;
            margin-right: 5%;
        }
        .chart-container:last-child {
            margin-right: 0;
        }
        .chart-container canvas {
            display: block;
            width: 100%;
            height: 100%;
        }
        .pie-chart-container {
            width: 45%;
            margin-left: 5%;
        }
        .bar-chart-container {
            width: 40%;
            margin-top: 10%;
         
        }
    </style>
</head>
<body bgcolor = "E1F0DA">
   
    <div class="chart-container pie-chart-container">
        <canvas id="pieChart"></canvas>
    </div>
    <div class="chart-container bar-chart-container">
        <canvas id="barChart"></canvas>
    </div>

    <script>
        // This script will be filled with data and chart rendering code
    </script>
</body>
</html>

<?php
include("adminheader.php");

$sql = "SELECT plant, SUM(water_used) as total_water_used FROM water_usage GROUP BY plant";
$result = $conn->query($sql);

$plants = [];
$waterUsed = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $plants[] = $row['plant'];
        $waterUsed[] = $row['total_water_used'];
    }
}

$conn->close();
?>

<script>
    // Convert PHP arrays to JavaScript arrays
    const plants = <?php echo json_encode($plants); ?>;
    const waterUsed = <?php echo json_encode($waterUsed); ?>;

    // Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    const pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: plants,
            datasets: [{
                label: 'Water Used (L)',
                data: waterUsed,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    // Add more colors if needed
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    // Add more border colors if needed
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Water Usage by Plant (Pie Chart)'
                }
            }
        },
    });

    // Bar Chart
    const barCtx = document.getElementById('barChart').getContext('2d');
    const barChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: plants,
            datasets: [{
                label: 'Water Used (L)',
                data: waterUsed,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Water Usage by Plant (Bar Chart)'
                }
            }
        },
    });
</script>
