<?php
session_start();


$cities = [
  "New York","Los Angeles","London","Paris","Berlin",
  "Beijing","Delhi","Tokyo","Moscow","Cairo",
  "Sydney","Toronto","Mexico City","Sao Paulo","Rome",
  "Seoul","Bangkok","Istanbul","Jakarta","Tehran"
];

$error = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sel = $_POST['cities'] ?? [];
    
    if (count($sel) !== 10) {
        $error = "Please select exactly 10 cities (you selected " . count($sel) . ").";
    } else {
      
        for ($i = 0; $i < 10; $i++) {
            $_SESSION['city' . ($i+1)] = $sel[$i];
        }
        header('Location: showAQI.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Select 10 Cities</title>
</head>
<body>
  <h1>Select Exactly 10 Cities</h1>
  <?php if ($error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form method="post">
    <?php foreach ($cities as $city): ?>
      <label>
        <input type="checkbox" name="cities[]" value="<?= htmlspecialchars($city) ?>">
        <?= htmlspecialchars($city) ?>
      </label><br>
    <?php endforeach; ?>
    <button type="submit">Submit</button>
  </form>
</body>
</html>
