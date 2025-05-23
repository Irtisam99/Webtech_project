<?php
session_start();

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
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: <?= $bgColor ?>;
            padding: 30px;
        }

        .username {
            text-align: right;
            font-weight: 600;
            color: #007bff;
            margin-bottom: 15px;
            font-size: 14px;
            max-width: 80%;
            margin-left: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 15px 20px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:hover {
            background-color: #f1f9ff;
        }

        .no-data {
            text-align: center;
            margin-top: 20px;
            color: #555;
            font-size: 18px;
        }

        .back-form {
            text-align: center;
            margin-top: 30px;
        }

        .back-button, .logout-button {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
        }

        .back-button {
            background: #007bff;
            color: white;
        }

        .back-button:hover {
            background: #0056b3;
        }

        .logout-button {
            background: #dc3545;
            color: white;
            margin-top: 10px;
        }

        .logout-button:hover {
            background: #a71d2a;
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

</body>
</html>
