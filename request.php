<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}
$cities = [
  "New York","Los Angeles","London","Paris","Berlin",
  "Beijing","Delhi","Tokyo","Moscow","Cairo",
  "Sydney","Toronto","Mexico City","Sao Paulo","Rome",
  "Seoul","Bangkok","Istanbul","Jakarta","Tehran"
];

$error = '';
$selected = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected = $_POST['cities'] ?? [];

    if (count($selected) !== 10) {
        $error = "Please select exactly 10 cities. You selected " . count($selected) . ".";
    } else {
        // Valid selection — redirect via POST using hidden form
        echo '<form id="forwardForm" action="showAQI.php" method="post">';
        foreach ($selected as $city) {
            echo '<input type="hidden" name="cities[]" value="' . htmlspecialchars($city) . '">';
        }
        echo '</form>';
        echo '<script>document.getElementById("forwardForm").submit();</script>';
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Select Cities</title>
</head>
<body>
  <h2>Select Exactly 10 Cities</h2>

  <?php if ($error): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form method="post" action="request.php">
    <?php foreach ($cities as $city): ?>
      <label>
        <input type="checkbox" name="cities[]" value="<?= htmlspecialchars($city) ?>"
          <?= in_array($city, $selected) ? 'checked' : '' ?>>
        <?= htmlspecialchars($city) ?>
      </label><br>
    <?php endforeach; ?>
    <br>
    <button type="submit">Submit</button>
  </form>
  <form action="logout.php" method="post">
    <button type="submit">Logout</button>
</form>
</body>
</html>
