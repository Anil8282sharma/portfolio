<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    height: 100vh;
    background: linear-gradient(135deg, #8e2de2, #4a00e0);
    color: #fff;
  }

  header {
    width: 100%;
    padding: 20px;
    background-color: #4a00e0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
  }

  header h1 {
    margin: 0;
    font-size: 24px;
  }

  header .header-buttons {
    display: flex;
    align-items: center;
  }

  header .header-button {
    background-color: #fff;
    color: #4a00e0;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    margin-left: 10px;
    transition: background-color 0.3s ease, color 0.3s ease;
    margin-right: 40px;
  }

  header .header-button:hover {
    background-color: #8e2de2;
    color: #fff;
  }

  .container {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
  }

  .form-container {
    background-color: #fff;
    color: #333;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    width: 400px;
    text-align: center;
    animation: fadeIn 0.5s;
    position: relative;
  }

  .form-container h2 {
    margin-bottom: 20px;
    color: #4a00e0;
  }

  .form-container input[type="text"],
  .form-container input[type="email"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
  }

  .form-container input[type="file"] {
    display: none;
  }

  .form-container label[for="imageInput"] {
    display: inline-block;
    background-color: #4a00e0;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin: 10px 0;
  }

  .form-container label[for="imageInput"]:hover {
    background-color: #8e2de2;
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

  .image-preview {
    position: absolute;
    top: 50%;
    left: -150px;
    transform: translateY(-50%);
    width: 120px;
    height: 120px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    background-color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .image-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
</style>
</head>
<body>

<header>
<div class="header-buttons">
    <a href="edit.php" class="header-button">Edit</button>
  </div>
  <h1>Welcome to My Dashboard</h1>
  <div class="header-buttons">
  <a href="main.html" class="header-button">Logout</a>

  </div>
</header>

<div class="container">
  <div class="form-container">
    <h2>Dashboard Form</h2>
    <div class="image-preview" id="imagePreview">
      <img src="" alt="Image Preview" id="previewImage">
    </div>
    <?php
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

    // Fetch user data
    $user_email = $_SESSION['gmail']; // Assume email is stored in session after login
    $sql = "SELECT id, gmail FROM users WHERE gmail='$user_email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
        $user_email = $row['gmail'];
    } else {
        echo "No user found.";
        $user_id = '';
        $user_email = '';
    }

    $conn->close();
    ?>
   <form id="dashboardForm" action="submit.php" method="post" enctype="multipart/form-data">
  <label for="userId">User ID:</label>
  <input type="text" id="userId" name="user_id" placeholder="User ID" value="<?php echo $user_id; ?>" readonly>
  <label for="userEmail">Email:</label>
  <input type="email" id="userEmail" name="user_email" placeholder="Email" value="<?php echo $user_email; ?>" readonly>
  <label for="imageInput">Upload Image:</label>
  <input type="file" id="imageInput" name="image" required>
  <button type="submit">Submit</button>
</form>

  </div>
</div>

<script>
  // Function to preview the image
  document.getElementById('imageInput').addEventListener('change', function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var previewImage = document.getElementById('previewImage');
      previewImage.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
  });

  var idleTime = 0;

// Increment idle time counter every second
var idleInterval = setInterval(timerIncrement, 1000);

// Reset idle time counter on mouse movement or keypress
document.addEventListener("mousemove", function(event){
  idleTime = 0;
});
document.addEventListener("keypress", function(event){
  idleTime = 0;
});

// Function to increment idle time counter
function timerIncrement() {
  idleTime++;
  if (idleTime >= 3) { // Display error message after 3 seconds of inactivity
    alert("Error: Your session will be timed out. Please save your work.");
    clearInterval(idleInterval); // Stop checking for idle time
    setTimeout(function(){
      window.location.href = "main.html"; // Redirect after showing the alert
    }, 10000); // Redirect after 2 seconds of showing the alert
  }
}
  
  
  
</script>


</script>

</body>
</html>