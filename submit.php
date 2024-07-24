<?php
// Start session
session_start();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $user_id = $_POST['user_id'];
    $user_email = $_POST['user_email'];

    // Handle file upload
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        $uploadOk = 0;
        $error_message = "File is not an image.";
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        $uploadOk = 0;
        $error_message = "Sorry, your file is too large.";
    }

    // Allow only specific file formats
    $allowed_formats = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowed_formats)) {
        $uploadOk = 0;
        $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
        $error_message = "Sorry, file already exists.";
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        // Show error message and exit
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    showModal('$error_message');
                });
              </script>";
        exit;
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Save file path in the database
            $stmt = $conn->prepare("INSERT INTO user_images (user_id, email, image_path) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $user_id, $user_email, $target_file);
            if ($stmt->execute()) {
                // Record successfully updated, show success message
                $success_message = "image updated successfully!";
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showModal('$success_message');
                        });
                      </script>";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
       
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
            border-radius: 10px;
            text-align: center;
            position: relative;
        }

        .close {
            position: absolute;
            top: 5px;
            right: 10px;
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-content button {
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #4a00e0;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            outline: none;
        }

        .modal-content button:hover {
            background-color: #8e2de2;
        }
    </style>
</head>
<body>
    <!-- Your HTML content here -->
    <!-- Add this HTML after the form container -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p id="modalMessage"></p>
            <button id="okButton">OK</button>
        </div>
    </div>

  

    <script>
        // Show modal with message
        function showModal(message) {
            var modal = document.getElementById('successModal');
            var modalMessage = document.getElementById('modalMessage');
            modalMessage.textContent = message;
            modal.style.display = 'block';
        }

        // Close the modal when the user clicks on the close button (×)
        function closeModal() {
            var modal = document.getElementById('successModal');
            modal.style.display = 'none';
        }

        // Redirect to dashboard.php after clicking OK
        document.getElementById('okButton').addEventListener('click', function() {
            window.location.href = '<?php echo $_SERVER['PHP_SELF']; ?>';
        });

        // Animate the OK button
        document.getElementById('successModal').addEventListener('click', function() {
            var button = document.getElementById('okButton');
            button.style.transform = 'scale(1.1)';
            setTimeout(function() {
                button.style.transform = 'scale(1)';
            }, 200);
        });
        // Update the JavaScript code for redirection
document.getElementById('okButton').addEventListener('click', function() {
    window.location.href = 'dashboard.php'; // Update the URL to dashboard.php
});

    </script>
</body>
</html>
