<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Image Form</title>
 
</head>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 600px;
    margin: 50px auto;
    background-color: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

.image-form {
    text-align: center;
}

.custom-file-upload {
    border: 1px solid #ccc;
    background-color: #f9f9f9;
    color: #333;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    display: inline-block;
    margin-bottom: 10px;
}

.custom-file-upload i {
    margin-right: 5px;
}

input[type="file"] {
    display: none;
}

button {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #0056b3;
}

.image-container {
    margin-top: 20px;
    text-align: center;
}

#displayedImage {
    max-width: 100%;
    max-height: 400px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}


</style>
<body>
    <div class="container">
        <h1>Change Image</h1>
        <div class="image-container">
            <img src="default.jpg" alt="Image" id="displayedImage">
        </div>
        <form id="imageForm" class="image-form">
            <label for="imageInput" class="custom-file-upload">
                <i class="fas fa-cloud-upload-alt"></i> Choose Image
            </label>
            <input type="file" id="imageInput" accept="image/*">
            <button type="button" id="changeImageButton">Change Image</button>
            <button type="submit">Submit</button>
        </form>
    </div>

    <script>document.addEventListener('DOMContentLoaded', function () {
    const imageForm = document.getElementById('imageForm');
    const imageInput = document.getElementById('imageInput');
    const displayedImage = document.getElementById('displayedImage');

    imageForm.addEventListener('submit', function (e) {
        e.preventDefault();
        // Add your code to submit the form data here
    });

    document.getElementById('changeImageButton').addEventListener('click', function () {
        imageInput.click();
    });

    imageInput.addEventListener('change', function () {
        const file = imageInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                displayedImage.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
