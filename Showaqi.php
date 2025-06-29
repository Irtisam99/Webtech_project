<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION["email"];
$e            = urlencode($email);
$cookieName   = "color_" . str_replace('.', '_', $e);

$bgColor = '#ffffff';

if (isset($_COOKIE[$cookieName])) {
    $raw = $_COOKIE[$cookieName];  

    if (strpos($raw, '%23') === 0) {
        $decoded = urldecode($raw);      
    } else {
        $decoded = $raw;                
    }
    if (preg_match('/^#[0-9A-Fa-f]{6}$/', $decoded)) {
        $bgColor = htmlspecialchars($decoded);
    }
}

if (!isset($_SESSION['selected_cities']) || empty($_SESSION['selected_cities'])) {
    echo "No cities selected. Please go back and select cities.";
    exit();
}

$selectedCities = $_SESSION['selected_cities'];

$conn = mysqli_connect("localhost", "root", "", "aqi");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$cityList = "";
foreach ($selectedCities as $city) {
    $cityList .= "'" . mysqli_real_escape_string($conn, $city) . "',";
}
$cityList = rtrim($cityList, ',');

$sql    = "SELECT city, country, aqi FROM info WHERE city IN ($cityList)";
$result = mysqli_query($conn, $sql);

$data = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Selected Cities AQI</title>
    <link rel="stylesheet" href="aqi.css">
    <style>
        :root {
            --bg-color: <?= $bgColor ?>;
        }
    </style>
</head>
<body>

<div class="username">
    Username: <?= htmlspecialchars($email) ?>
</div>

<h2>Air Quality Index for Selected Cities</h2>

<?php if (count($data) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>City</th>
                <th>Country</th>
                <th>AQI</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['city']) ?></td>
                    <td><?= htmlspecialchars($row['country']) ?></td>
                    <td><?= htmlspecialchars($row['aqi']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="no-data">No AQI data found for the selected cities.</p>
<?php endif; ?>

<form action="request.php" method="post" class="back-form">
    <button type="submit" class="back-button">Back to Selection</button>
</form>

<form action="logout.php" method="post" class="back-form">
    <button type="submit" class="logout-button">Logout</button>
</form>

<script>
    window.addEventListener("pageshow", function (event) {
        if (event.persisted || (performance && performance.navigation.type === 2)) {
            window.location.reload();
        }
    });
</script>

</body>
</html>
