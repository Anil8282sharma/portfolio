<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session at the beginning of the script
session_start();

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the 'username' column exists, if not, add it
$check_column = $conn->query("SHOW COLUMNS FROM users LIKE 'username'");
if ($check_column->num_rows == 0) {
    $conn->query("ALTER TABLE users ADD COLUMN username VARCHAR(255) NOT NULL");
}

// Check if the 'age' column exists, if not, add it
$check_column = $conn->query("SHOW COLUMNS FROM users LIKE 'age'");
if ($check_column->num_rows == 0) {
    $conn->query("ALTER TABLE users ADD COLUMN age INT");
}

// Initialize a variable to store error messages
$error_message = '';

// Handle registration form submission
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $gmail = $_POST['gmail'];
    $password = $_POST['password'];
    $age = isset($_POST['age']) ? (int)$_POST['age'] : null;

    // Validate username: no special characters allowed
    if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
        $error_message = "Username must not contain special characters";
    } 
    // Validate email format
    elseif (!filter_var($gmail, FILTER_VALIDATE_EMAIL) || !str_ends_with($gmail, '@gmail.com')) {
        $error_message = "Only @gmail.com email addresses are allowed";
    } 
    // Validate password complexity
    elseif (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
        $error_message = "Password must be at least 8 characters long and include both letters and numbers";
    } else {
        // Check if email already exists
        $check_sql = "SELECT * FROM users WHERE gmail='$gmail'";
        $check_result = $conn->query($check_sql);
        if ($check_result->num_rows > 0) {
            $error_message = "Email already exists";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, gmail, password, age) VALUES ('$username', '$gmail', '$hashed_password', $age)";
            if ($conn->query($sql) === TRUE) {
                // Echo JavaScript to show the success pop-up
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showSuccessPopup();
                        });
                      </script>";
            } else {
                $error_message = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

// Handle login form submission
if (isset($_POST['login'])) {
    $gmail = $_POST['gmail'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE gmail='$gmail'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the hashed password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['logged_in'] = true;
            $_SESSION['gmail'] = $gmail;

            // Redirect to dashboard.php
            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Invalid email or password";
        }
    } else {
        $error_message = "Invalid email or password";
    }
}

$conn->close();

// Display the error message using JavaScript
if ($error_message != '') {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showErrorPopup('$error_message');
            });
          </script>";
}
?>

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
  .form-container input[type="password"],
  .form-container input[type="number"] {
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
  }
</style>
</head>
<body>
<div class="form-container">
  <div class="toggle-btns">
    <button onclick="showLogin()">Login</button>
    <button onclick="showRegister()">Register</button>
  </div>
  
  <form id="loginForm" class="active" action="main.php" method="post">
    <h2>Login</h2>
    <input type="text" name="gmail" placeholder="Gmail" required>
    <input type="password" name="password" placeholder="Password" required>
    <div style="display:flex; align-items:center; justify-content: space-between;">
      <label>
        <input type="checkbox" name="rememberMe"> Remember Me
      </label>
      <a href="forget.html">Forgot Password?</a>
    </div>
    <button type="submit" name="login">Login</button>
  </form>
  
  <form id="registerForm" action="main.php" method="post">
    <h2>Register</h2>
    <input type="text" name="username" placeholder="Username" required>
    <input type="text" name="gmail" placeholder="Gmail" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="number" name="age" placeholder="Age">
    <div style="display:flex; align-items:center; justify-content: space-between;">
      <label>
        <input type="checkbox" name="rememberMe"> Remember Me
      </label>
    </div>
    <button type="submit" name="register">Register</button>
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
</body>
</html>
