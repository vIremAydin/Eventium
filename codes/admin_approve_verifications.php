<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Approve Verifications</title>
    <link rel="stylesheet" href="style/organizer-style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style/admin-style.css">
</head>
<body>
<h3>Verify Organizer</h3>
<div>
    <form method="post">
        <div class="v-container">
            <div class="item">
                <label for="org_id" class="col-sm-4 col-form-label">Enter Organizer ID</label>
                <input type="text" class="form-control" name="org_id" id="org_id" placeholder="enter ID">
            </div>
            <div class="item">
                <label for="org_name" class="col-sm-4 col-form-label">Enter Organizer Company Name</label>
                <input type="text" class="form-control" name="org_name" id="org_name" placeholder="enter name">
            </div>

            <button class="btn org" style="margin-top: 30px; margin-left: 150px; margin-right: 150px;">Verify</button>
        </div>
    </form>
</div>

<div class="go-back">
    <button style="background-color: transparent; border-width: 0;" onclick="window.location.href='./admin_home.php';">
        <img class="image-back" src="icons/icons8-back-arrow-32.png" alt="back"/>
        <span>Go back to the home page</span>
    </button>
</div>
</body>
</html>

<?php
session_start();
require('connection.php');
 
if (isset($_POST['org_id']) && isset($_POST['org_name'])) {
    $stmt = $connection->prepare("INSERT INTO verified_organizer VALUES (?, ?, NULL, ?, ?)");
    $stmt->bind_param("isis", $_POST['org_id'], $_POST['org_name'], $_SESSION['user_id'], date("Y-m-d"));
    if ($stmt->execute()) {
        echo "<script type='text/javascript'>alert('Verification is successful!');</script>";
        echo "<script>window.location = 'admin_home.php';</script>";
    } else {
        echo "<script type='text/javascript'>alert('Verification is not successful!');</script>";
        echo "<script>window.location = 'admin_home.php';</script>";
    }
}

$stmt->close();
?>
