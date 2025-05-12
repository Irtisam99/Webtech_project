<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Submission Summary &amp; City Selection</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      padding: 2rem;
    }
    .wrapper {
      width: 50%;
      text-align: center;
    }
    h2 {
      margin-bottom: 1rem;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 1.5rem;
    }
    th, td {
      border: 1px solid #333;
      padding: 0.5rem;
    }
    th {
      background-color: #f0f0f0;
    }
    .city-select {
      margin-bottom: 1rem;
    }
    select {
      width: 100%;
      height: 10rem;
    }
    button:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <h2>User Details</h2>
    <table>
      <thead>
        <tr>
          <th>Field</th>
          <th>Your Input</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Name</td>
          <td>
            <?php
              if (isset($_POST['submit'])) {
                if ($_POST['name'] != "") {
                  echo htmlspecialchars($_POST['name'], ENT_QUOTES);
                } else {
                  print_r("NO DATA");
                }
              } else {
                print_r("NO DATA");
              }
            ?>
          </td>
        </tr>
        <tr>
          <td>Email</td>
          <td>
            <?php
              if (isset($_POST['submit'])) {
                if ($_POST['email'] != "") {
                  echo htmlspecialchars($_POST['email'], ENT_QUOTES);
                } else {
                  print_r("NO DATA");
                }
              } else {
                print_r("NO DATA");
              }
            ?>
          </td>
        </tr>
        <tr>
          <td>Date of Birth</td>
          <td>
            <?php
              if (isset($_POST['submit'])) {
                if ($_POST['dob'] != "") {
                  echo htmlspecialchars($_POST['dob'], ENT_QUOTES);
                } else {
                  print_r("NO DATA");
                }
              } else {
                print_r("NO DATA");
              }
            ?>
          </td>
        </tr>
        <tr>
          <td>Country</td>
          <td>
            <?php
              if (isset($_POST['submit'])) {
                if ($_POST['country'] != "") {
                  echo htmlspecialchars($_POST['country'], ENT_QUOTES);
                } else {
                  print_r("NO DATA");
                }
              } else {
                print_r("NO DATA");
              }
            ?>
          </td>
        </tr>
        <tr>
          <td>Gender</td>
          <td>
            <?php
              if (isset($_POST['submit'])) {
                if ($_POST['gender'] != "") {
                  echo htmlspecialchars($_POST['gender'], ENT_QUOTES);
                } else {
                  print_r("NO DATA");
                }
              } else {
                print_r("NO DATA");
              }
            ?>
          </td>
        </tr>
        <tr>
          <td>Favourite Color</td>
          <td>
            <?php
              if (isset($_POST['submit'])) {
                if ($_POST['color'] != "") {
                  echo htmlspecialchars($_POST['color'], ENT_QUOTES);
                } else {
                  print_r("NO DATA");
                }
              } else {
                print_r("NO DATA");
              }
            ?>
          </td>
        </tr>
        <tr>
          <td>Opinion</td>
          <td>
            <?php
              if (isset($_POST['submit'])) {
                if ($_POST['opinion'] != "") {
                  echo htmlspecialchars($_POST['opinion'], ENT_QUOTES);
                } else {
                  print_r("NO DATA");
                }
              } else {
                print_r("NO DATA");
              }
            ?>
          </td>
        </tr>
      </tbody>
    </table>

  <div class="city-select">
  <label><strong>Select your 11 preferred cities:</strong></label><br><br>

  <div id="checkboxes" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; text-align: left;">
    <?php
      $cities = [
        'Dhaka','Chattogram','Khulna','Sylhet','Barishal','Rajshahi',
        'Rangpur','Mymensingh','Cox’s Bazar','Comilla','Jessore',
        'Narayanganj','Gazipur','Tangail','Bogra'
      ];
      foreach ($cities as $c) {
        echo "<label><input type='checkbox' name='cities[]' value='{$c}' onchange='updateConfirm();'> {$c}</label>";
      }
    ?>
  </div>

  <p id="msg" style="color:red; display:none; margin-top:10px;">
    Please select exactly <strong>11</strong> cities.
  </p>
</div>

<button id="confirm" disabled onclick="alert('Confirmed!');" style="margin-top:15px;">
  Confirm
</button>


  <script>
  function updateConfirm() {
    const checkboxes = document.querySelectorAll('#checkboxes input[type="checkbox"]');
    let picked = 0;

    for (let cb of checkboxes) {
      if (cb.checked) {
        picked++;
      }
    }

    const btn = document.getElementById('confirm');
    const msg = document.getElementById('msg');

    if (picked === 11) {
      btn.disabled = false;
      msg.style.display = 'none';
    } else {
      btn.disabled = true;
      msg.style.display = 'block';
    }
  }
</script>

</body>
</html>
