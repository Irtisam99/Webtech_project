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

$conn = mysqli_connect("localhost", "root", "", "aqi");
if (!$conn) {
    die("Connection failed.");
}

$cities = [];
$sql = "SELECT city FROM info LIMIT 20";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $cities[] = $row['city'];
}

$error = '';
$selected = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cities'])) {
        $selected = $_POST['cities'];
    }

    $count = count($selected);
    if ($count < 1 || $count > 10) {
        $error = "Please select between 1 and 10 countries. You selected $count.";
    } else {
        $_SESSION['selected_cities'] = $selected;
        header("Location: showAQI.php");
        exit();
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Select Countries</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: lightblue;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 60px;
            margin: 0;
            min-height: 100vh;
        }

        .container {
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            width: 450px;
            max-width: 90%;
        }

        .username {
            text-align: right;
            font-weight: 600;
            color: #007bff;
            margin-bottom: 15px;
            font-size: 14px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        h2 {
            margin-bottom: 25px;
            color: #333;
            text-align: center;
        }

        .error {
            color: #e60000;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .city-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }

        .city-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            background: #f1f9ff;
            border-radius: 6px;
        }

        .city-item:hover {
            background: #e0f0ff;
        }

        input[type="checkbox"] {
            transform: scale(1.3);
            accent-color: #007bff;
        }

        button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        form + form {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="username">
        Username: <?php echo htmlspecialchars($email); ?>
    </div>

    <h2>Select between 1 and 10 countries</h2>

    <?php if ($error != ''): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="post" action="request.php">
        <div class="city-list">
            <?php foreach ($cities as $city): ?>
                <?php $checked = in_array($city, $selected) ? 'checked' : ''; ?>
                <div class="city-item">
                    <span><?php echo htmlspecialchars($city); ?></span>
                    <input type="checkbox" name="cities[]" value="<?php echo htmlspecialchars($city); ?>" <?php echo $checked; ?>>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit">Submit</button>
    </form>

    <form method="post" action="logout.php">
        <button type="submit" style="margin-top: 10px; background: #dc3545;">Logout</button>
    </form>
</div>


<script>
    window.addEventListener("pageshow", function (event) {
        if (event.persisted || (performance && performance.navigation.type === 2)) {
            window.location.reload();
        }
    });
</script>

</body>
</html>
