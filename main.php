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

// Initialize a variable to store error messages
$error_message = '';

// Handle registration form submission
if(isset($_POST['register'])) {
    $gmail = $_POST['gmail'];
    $password = $_POST['password'];

    // Validate email format
    if (!filter_var($gmail, FILTER_VALIDATE_EMAIL) || !str_ends_with($gmail, '@gmail.com')) {
        $error_message = "Only @gmail.com email addresses are allowed";
    } elseif (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
        // Validate password complexity
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
            $sql = "INSERT INTO users (gmail, password) VALUES ('$gmail', '$hashed_password')";
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
if(isset($_POST['login'])) {
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
<title>Dashboard</title>
<style>
  /* General Styling */
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: linear-gradient(135deg, #8e2de2, #4a00e0);
    color: #fff;
  }

  /* Pop-up Styles */
  .popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    justify-content: center;
    align-items: center;
  }

  .popup {
    background: #fff;
    padding: 20px 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    text-align: center;
    animation: fadeInScale 0.5s;
  }

  .popup h2 {
    margin-bottom: 20px;
    color: #4a00e0;
    font-size: 24px;
    font-weight: bold;
  }

  .popup button {
    padding: 10px 20px;
    border: none;
    background: #4a00e0;
    color: #fff;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
  }

  .popup button:hover {
    background: #8e2de2;
    transform: scale(1.05);
  }

  @keyframes fadeInScale {
    from {
      opacity: 0;
      transform: scale(0.7);
    }
    to {
      opacity: 1;
      transform: scale(1);
    }
  }

  .show-overlay {
    display: flex;
  }

  /* Error Pop-up Styles */
  .error-popup h2 {
    color: #e00;
  }

  .error-popup button {
    background: #e00;
  }

  .error-popup button:hover {
    background: #ff5e5e;
  }
</style>
</head>
<body>

<!-- Success Pop-up HTML -->
<div class="popup-overlay" id="successPopupOverlay">
  <div class="popup" id="successPopup">
    <h2>Registration Successful!</h2>
    <button onclick="closeSuccessPopup()">OK</button>
  </div>
</div>

<!-- Error Pop-up HTML -->
<div class="popup-overlay" id="errorPopupOverlay">
  <div class="popup error-popup" id="errorPopup">
    <h2 id="errorPopupMessage"></h2>
    <button onclick="closeErrorPopup()">OK</button>
  </div>
</div>

<script>
  // JavaScript to show and hide the success pop-up
  function showSuccessPopup() {
    var popupOverlay = document.getElementById('successPopupOverlay');
    popupOverlay.classList.add('show-overlay');
  }

  function closeSuccessPopup() {
    var popupOverlay = document.getElementById('successPopupOverlay');
    popupOverlay.classList.remove('show-overlay');
    window.location.href = 'form.html'; // Redirect after closing pop-up
  }

  // JavaScript to show and hide the error pop-up
  function showErrorPopup(message) {
    var popupOverlay = document.getElementById('errorPopupOverlay');
    var popupMessage = document.getElementById('errorPopupMessage');
    popupMessage.textContent = message;
    popupOverlay.classList.add('show-overlay');
  }

  function closeErrorPopup() {
    var popupOverlay = document.getElementById('errorPopupOverlay');
    popupOverlay.classList.remove('show-overlay');
    window.location.href = 'form.html'; // Redirect after closing pop-up
  }

</script>



</body>
</html>
