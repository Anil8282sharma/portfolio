<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Page</title>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .box {
        width: 150px;
        height: 150px;
        background-color: #3498db;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border-radius: 15px;
        margin: 10px;
        transition: background-color 0.3s ease;
    }

    .box:hover {
        background-color: #2980b9;
    }

    .box h2 {
        color: #fff;
        font-size: 24px;
    }
</style>
</head>
<body>
<div class="container">
    <div class="box" onclick="redirectToPage('page1.html')">
        <h2>carousel 1</h2>
    </div>
    <div class="box" onclick="redirectToPage('page2.html')">
        <h2>carousel 2</h2>
    </div>
    <div class="box" onclick="redirectToPage('page3.html')">
        <h2>carousel 3</h2>
    </div>
</div>

<script>
    function redirectToPage(page) {
        window.location.href = page;
    }
</script>
</body>
</html>
