<?php
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

$year = 2023;
$weeks = getWeeks($year);
?>

<select>
<?php foreach ($weeks as $weekNumber => $weekRange): ?>
    <option value="<?php echo $weekNumber; ?>"><?php echo $weekRange; ?></option>
<?php endforeach; ?>
</select>