<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login/Register Form</title>
<style>
 body {
    background: linear-gradient(135deg, #8e2de2, #4a00e0);
    margin: 0;
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }
  
  .form-container {
    width: 300px;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  
  .form-container h2 {
    text-align: center;
    color: #4a00e0;
    margin-bottom: 20px;
  }
  
  .form-container input[type="text"],
  .form-container input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
    box-sizing: border-box;
  }
  
  .form-container button {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: none;
    border-radius: 5px;
    background-color: #4a00e0;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  .form-container button:hover {
    background-color: #8e2de2;
  }
  
  .form-container form.active {
    display: block;
  }
  
  .form-container form:not(.active) {
    display: none;
  }
  
  .form-container .toggle-btns {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
  }
  
  .form-container .toggle-btns button {
    flex: 1;
    padding: 10px;
    border: none;
    border-radius: 5px;
    background-color: transparent;
    color: #4a00e0;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease;
  }
  
  .form-container .toggle-btns button:hover {
    background-color: #f9f9f9;
  }re */
</style>
</head>
<body>
<div class="form-container">
  <div class="toggle-btns">
    <button onclick="showLogin()">Login</button>
    <button onclick="showRegister()">Register</button>
  </div>
  
  <!-- Registration Form -->
  <form id="registerForm" <?php if(isset($_POST['register'])) echo 'class="active"'; ?> action="" method="post">
    <h2>Register</h2>
    <input type="text" name="gmail" placeholder="Gmail" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="register">Register</button>
  </form>

  <!-- Login Form -->
  <form id="loginForm" <?php if(isset($_POST['login'])) echo 'class="active"'; ?> action="" method="post">
    <h2>Login</h2>
    <input type="text" name="gmail" placeholder="Gmail" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
  </form>
</div>

<script>
function showLogin() {
  document.getElementById("loginForm").classList.add("active");
  document.getElementById("registerForm").classList.remove("active");
}

function showRegister() {
  document.getElementById("loginForm").classList.remove("active");
  document.getElementById("registerForm").classList.add("active");
}
</script>

<?php
// PHP code for handling form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "your_username";
    $password = "your_password";
    $dbname = "project";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['register'])) {
        $email = $_POST['gmail'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashed_password')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration successful. Please login.');</script>";
            // Redirect to the login form or perform other actions
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if (isset($_POST['login'])) {
        // Handle login process here
    }

    $conn->close();
}
?>
</body>
</html>
