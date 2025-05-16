<?php
session_start();

// Connect to database (change username, password, database name if needed)
$connection = new mysqli("localhost", "root", "", "aqi");

// Check connection
if ($connection->connect_error) {
    die("Database connection failed: " . $connection->connect_error);
}

// Get the 10 selected cities from the session
$selectedCities = [];
for ($i = 1; $i <= 10; $i++) {
    if (isset($_SESSION['city' . $i])) {
        $selectedCities[] = $_SESSION['city' . $i];
    }
}

if (empty($selectedCities)) {
    die("No cities selected. Please select 10 cities first.");
}

// Make a list of cities for the query, adding quotes around each city
$cityList = "'" . implode("','", $selectedCities) . "'";

// Get AQI values for these cities from the database
$query = "SELECT City, AQI FROM info WHERE City IN ($cityList)";
$result = $connection->query($query);

// Save the AQI values in an array
$aqiValues = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $aqiValues[$row['City']] = $row['AQI'];
    }
}

// Close the database connection
$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>AQI for Selected Cities</title>
    <style>
        body { font-family: Arial; text-align: center; margin-top: 50px; }
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
