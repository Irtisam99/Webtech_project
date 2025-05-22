<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aqi";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['cancel'])) {
    session_unset();
    session_destroy();
    header("Location: index.html");
    exit();
}

if (isset($_POST['confirm'])) {
    if (!empty($_SESSION['color'])) {
        setcookie("color", $_SESSION['color'], time() + (86400 * 30), "/");
    }

    $rawPassword = $_SESSION['password'] ?? '';
    $maskedPassword = str_repeat('*', strlen($rawPassword)); // Store as dots or stars

    $name = mysqli_real_escape_string($conn, $_SESSION['name'] ?? '');
    $email = mysqli_real_escape_string($conn, $_SESSION['email'] ?? '');
    $dob = mysqli_real_escape_string($conn, $_SESSION['dob'] ?? '');
    $gender = mysqli_real_escape_string($conn, $_SESSION['gender'] ?? '');
    $country = mysqli_real_escape_string($conn, $_SESSION['country'] ?? '');

    $sql = "INSERT INTO user(name, email, pass, dob, country, gender) VALUES ('$name', '$email', '$maskedPassword', '$dob', '$country', '$gender')";
    mysqli_query($conn, $sql);

    mysqli_close($conn);

    session_unset();
    session_destroy();

    header("Location: index.php");
    exit();
}

if (isset($_POST['submit'])) {
    $_SESSION['name'] = $_POST['name'] ?? '';
    $_SESSION['email'] = $_POST['email'] ?? '';
    $_SESSION['password'] = $_POST['password'] ?? '';
    $_SESSION['dob'] = $_POST['dob'] ?? '';
    $_SESSION['gender'] = $_POST['gender'] ?? '';
    $_SESSION['color'] = $_POST['color'] ?? '';
    $_SESSION['country'] = $_POST['country'] ?? '';
    $_SESSION['opinion'] = $_POST['opinion'] ?? '';

    echo '<!DOCTYPE html>
<html>
<head>
    <title>Submitted User Data</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 50%;
        }
        th, td {
            padding: 10px;
            border: 1px solid #555;
        }
        th {
            background-color: #eee;
        }
        h2 {
            margin-top: 40px;
        }
    </style>
</head>
<body>

    <h2>Submitted User Information</h2>
    <table>
        <tr><th>Field</th><th>Value</th></tr>
        <tr><td>Name</td><td>' . htmlspecialchars($_SESSION['name']) . '</td></tr>
        <tr><td>Email</td><td>' . htmlspecialchars($_SESSION['email']) . '</td></tr>
        <tr><td>Password</td><td>' . htmlspecialchars($_SESSION['password']) . '</td></tr>
        <tr><td>Date of Birth</td><td>' . htmlspecialchars($_SESSION['dob']) . '</td></tr>
        <tr><td>Gender</td><td>' . htmlspecialchars($_SESSION['gender']) . '</td></tr>
        <tr><td>Color</td><td>' . htmlspecialchars($_SESSION['color']) . '</td></tr>
        <tr><td>Country</td><td>' . htmlspecialchars($_SESSION['country']) . '</td></tr>
        <tr><td>Opinion</td><td>' . htmlspecialchars($_SESSION['opinion']) . '</td></tr>
    </table>

    <form action="process.php" method="POST">
        <input type="submit" name="confirm" value="Confirm">
        <input type="submit" name="cancel" value="Cancel">
    </form>

</body>
</html>';
} else {
    echo "NO DATA";
}
?>
