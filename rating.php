<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Документ</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .container {
            width: 50%;
            height: 50%;
        }
    </style>
</head>
<body>
    <div class="container">
        <canvas id="myChart"></canvas>
    </div>
<?php
    require_once("config.php");
    $connect = mysqli_connect($host, $user, $pass, $db);
    if (!$connect) {
        die();
    }

    $query = "SELECT violation_date, COUNT(*) AS total_violations FROM protocol GROUP BY violation_date";
    $result = mysqli_query($connect, $query);
    $labels = [];
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $labels[] = $row['violation_date'];
        $data[] = $row['total_violations'];
    }
    mysqli_close($connect);
?>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Количество нарушений',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: 'rgba(0, 123, 255, 0.5)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                }
            }
        }
    });
</script>
</body>
</html>