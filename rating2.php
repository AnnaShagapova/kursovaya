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
function getWeeks($year) {
    $startDate = new DateTime($year . '-01-01');
    $endDate = new DateTime($year . '-12-31');
    $weeks = [];

    $currentDate = $startDate;

    while ($currentDate <= $endDate) {
        $startOfWeek = clone $currentDate;
        $endOfWeek = clone $currentDate;
        $startOfWeek->modify('Monday this week');
        $endOfWeek->modify('Sunday this week');
        $weekRange = $startOfWeek->format('d.m.Y') . " - " . $endOfWeek->format('d.m.Y');
        $weeks[$currentDate->format('W')] = $weekRange; 
        $currentDate->modify('+1 week');
    }

    return $weeks;
}


$selectedWeek = isset($_POST['selectedWeek']) ? $_POST['selectedWeek'] : null;
$weekStart = null;
$weekEnd = null;
$year = 2023;
$weeks = getWeeks($year); 
if ($selectedWeek) {
    $weekStart = $weeks[$selectedWeek]; 
    $weekEnd = DateTime::createFromFormat('d.m.Y', substr($weekStart, 0, 10)); 
    $weekEnd->modify('+6 days'); 
    $weekEnd = $weekEnd->format('Y-m-d'); 
}
$query = "SELECT WEEKDAY(violation_date) AS day_of_week, COUNT(*) AS total_violations FROM protocol WHERE violation_date BETWEEN '$weekStart' AND '$weekEnd' AND WEEK(violation_date) = '$selectedWeek' GROUP BY day_of_week";
$result = mysqli_query($connect, $query);
$labels = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница','Суббота','Воскресенье'];
$data = [0, 0, 0, 0, 0, 0, 0];
$message = "График за числа с " . $weekStart . "";


while ($row = mysqli_fetch_assoc($result)) {
    $dayOfWeek = intval($row['day_of_week']);
    $data[$dayOfWeek] = $row['total_violations'];
}

mysqli_close($connect);
?>
<form method="POST" action="rating2.php">
    <select name="selectedWeek">
        <?php foreach ($weeks as $weekNumber => $weekRange): ?>
            <option value="<?php echo $weekNumber; ?>"><?php echo $weekRange; ?></option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="Посмотреть на текущую неделю">
</form>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
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
<?php endif; ?>
<h3><?php echo $message; ?></h3>
</body>
</html>