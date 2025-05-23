<?php
session_start();

if (isset($_SESSION["email"])) {
    header("Location: request.php");
    exit();
}

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $pass = $_POST["password"];

    $conn = mysqli_connect('localhost', 'root', '', 'aqi'); // update db name
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get user by email only
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        // Verify hashed password
        if (password_verify($pass, $row['pass'])) {
            $_SESSION["email"] = $email;

            echo "You are now redirected...";
            header("refresh: 2; url = request.php");
            exit();
        } else {
            echo "Incorrect password. Redirecting back...";
            header("refresh: 2; url = index.php");
            exit();
        }
    } else {
        echo "User not found. Redirecting back...";
        header("refresh: 2; url = index.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST["login"])) {
    echo "Please fill in email and password.";
    header("refresh: 2; url = index.php");
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Air Quality Index</title>
    <link rel="stylesheet" type="text/css" href="style.css">    
</head>
<body>
    <div style="text-align: center;">
        <p>
            <img src="aqi.jpg" alt="The Flexbox" height="70px" width="70px" style="border-radius: 60%; border: solid;">
        </p>
        <h1>AQI</h1>
    </div>

    <div class="flex-container">
        <div id="flex1">
            <h2>Registration Form</h2><br>
            <form id="regForm" method="post" action="process.php"onsubmit="return validateForm()">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
                <span class="error-message" id="nameError"></span>


                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <span class="error-message" id="emailError">
                  <?php
    if (isset($_GET['error']) && $_GET['error'] === 'emailexists') {
        echo "Email already registered. Please use a different email.";
    }
?>
                </span>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <span class="error-message" id="passwordError"></span>

                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <span class="error-message" id="confirmPasswordError"></span>

                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" required>
                <span class="error-message" id="dobError"></span>

                <label for="country">Country</label>
                <select id="country" name="country" required>
                    <option value="">Select your country</option>
                    <option value="USA">United States</option>
                    <option value="UK">United Kingdom</option>
                    <option value="Canada">Canada</option>
                    <option value="Australia">Australia</option>
                    <option value="Bangladesh">Bangladesh</option>
                    <option value="India">India</option>
                    <option value="Other">Other</option>
                </select>
                <span class="error-message" id="countryError"></span>

                <label>Gender</label>
                <div class="radio-group">
                    <input type="radio" id="male" name="gender" value="Male" required>
                    <label for="male">Male</label>

                    <input type="radio" id="female" name="gender" value="Female" required>
                    <label for="female">Female</label>

                
                </div>
                <span class="error-message" id="genderError"></span>

                <label for="color">Favorite Color</label>
                <input type="color" id="color" name="color" required>
                

                <label for="opinion">Your Opinion</label>
                <textarea id="opinion" name="opinion" placeholder="Share your thoughts..." required></textarea>
                <span class="error-message" id="opinionError"></span>

                <div id="terms" class="terms-container">
                    <input type="checkbox" id="agreeCheckbox" required>
                    <label for="agreeCheckbox">I agree to the <a href="#top">Terms and Conditions</a></label>   
                </div>

                <button type="submit" name="submit">Register</button>
            </form>
        </div>
        <div class="right-side">
            <div id="flex3" class="flex">
                <h3 style="color: aqua;">LOGIN</h3>
                <form id="loginform" method="post" action="">
                    <label for="email">Email</label>
       <input type="email" id="email" name="email" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>

      <button type="submit" name="login" >Login</button>
    </form>
    </div>
            <div id="flex4" class="flex">
              <div id="loginOverlay">
  <div id="overlayContent">
    <h2>Login Required</h2>
  </div>
</div>
                <div id="innerBox">
                    <div class="refresh-container" id="refreshContainer">
                        <img src="icon.jpg" alt="Refresh" id="refreshGif">
                        <span id="refreshLabel">Refresh</span>
                      </div>
                    <table>
                      <thead>
                        <tr>
                          <th>City</th>
                          <th>AQI</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Row 1, Col 1</td>
                          <td>Row 1, Col 2</td>
                        </tr>
                        <tr>
                          <td>Row 2, Col 1</td>
                          <td>Row 2, Col 2</td>
                        </tr>
                        <tr>
                          <td>Row 3, Col 1</td>
                          <td>Row 3, Col 2</td>
                        </tr>
                        <tr>
                          <td>Row 4, Col 1</td>
                          <td>Row 4, Col 2</td>
                        </tr>
                        <tr>
                          <td>Row 5, Col 1</td>
                          <td>Row 5, Col 2</td>
                        </tr>
                        <tr>
                          <td>Row 6, Col 1</td>
                          <td>Row 6, Col 2</td>
                        </tr>
                        <tr>
                          <td>Row 7, Col 1</td>
                          <td>Row 7, Col 2</td>
                        </tr>
                        <tr>
                          <td>Row 8, Col 1</td>
                          <td>Row 8, Col 2</td>
                        </tr>
                        <tr>
                          <td>Row 9, Col 1</td>
                          <td>Row 9, Col 2</td>
                        </tr>
                        <tr>
                          <td>Row 10, Col 1</td>
                          <td>Row 10, Col 2</td>
                        </tr>
                        <tr>
                          <td>Row 11, Col 1</td>
                          <td>Row 11, Col 2</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>


            </div>
        </div>
    </div>

  
<div id="successPopup" style="display:none; position: fixed; z-index: 5000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); text-align: center;">
    <div style="background-color: white; padding: 20px; margin: 200px auto; width: 300px; border-radius: 10px;">
        <h3>Registered Successfully!</h3>
        <button onclick="document.getElementById('successPopup').style.display='none'">Close</button>
    </div>
</div>




    <script src="validation.js"></script>
</body>
</html>