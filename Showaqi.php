

<?php

$favColor = 'white';
if (!empty($_COOKIE['fav_color'])) {
    // sanitize to prevent CSS injection
    $favColor = htmlspecialchars($_COOKIE['fav_color'], ENT_QUOTES);
}
$connection = new mysqli("localhost", "root", "", "aqi");
if ($connection->connect_error) {
    die("Database connection failed: " . $connection->connect_error);
}
$selectedCities = $_POST['cities'] ?? [];

if (empty($selectedCities) || count($selectedCities) !== 10) {
    die("No cities selected or invalid selection. Please select exactly 10 cities first.");
}


$escapedCities = array_map([$connection, 'real_escape_string'], $selectedCities);
$cityList = "'" . implode("','", $escapedCities) . "'";

$query = "SELECT City, AQI FROM info WHERE City IN ($cityList)";
$result = $connection->query($query);

$aqiValues = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $aqiValues[$row['City']] = $row['AQI'];
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>AQI for Selected Cities</title>
    <style>
    
        body {
            background-color: <?= $favColor ?>;
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        table { margin: 0 auto; border-collapse: collapse; width: 60%; }
        th, td { border: 1px solid black; padding: 10px; }
        th { background-color: #555; color: white; }
    </style>
</head>
<body>

<h1>Air Quality Index (AQI) for Your Cities</h1>

<table>
    <tr>
        <th>City</th>
        <th>AQI</th>
    </tr>

    <?php foreach ($selectedCities as $city): ?>
    <tr>
        <td><?= htmlspecialchars($city) ?></td>
        <td><?= isset($aqiValues[$city]) ? htmlspecialchars($aqiValues[$city]) : "N/A" ?></td>
    </tr>
    <?php endforeach; ?>

</table>

</body>
</html>
