<?php
require('connection.php');    
session_start();
$id = $_SESSION['user_id'];
$sql1 = "SELECT participation_points FROM participant WHERE user_id = '$id'";
$query1 = $connection->query($sql1);
$result1 = $query1->fetch_assoc();
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/participant.css">
    <link rel="stylesheet" href="style/wallet-style.css">
</head>
<body>

<div class="header row align-items-center">
    <div class="col-4 my-header" style="font-size: 30px;">
        Your Wallet
    </div>

    <div class="col-3 mt-3">
        <!--Participation points-->
    </div>

    <div class="col-2 mt-3">
        <a href="./update_profile.php" style="color: whitesmoke; text-decoration: none;">Your Info</a>
    </div>

    <div class="col-2 mt-2">
        <button id="reg-btn" type="button" class="btn btn-light" onclick="window.location.href='./organizer_home.php';">Organize Event</button>
    </div>

    <div class="col-1 mt-3">
        <a href="./logout.php"><img class="image-back" src="icons/arrow-right-circle.svg" alt="back"/></a>

    </div>
</div>

<form method="post" action="./add_new_card.php">
    <div class="wallet-card">
        <div class="row">
            <div class="col-6">
                <label for="name" class=" col-form-label">Card Holder's Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
            </div>
            <div class="col-6">
                <label for="no" class=" col-form-label">Card No</label>
                <input type="number" class="form-control" id="no" name="no" placeholder="Card No">
            </div>

        </div>
        <div class="row">
            <div class="col-6">
                <label for="date" class=" col-form-label">Validation Date</label>
                <input type="date" class="form-control" id="date" name="date" placeholder="Date">
            </div>
            <div class="col-6">
                <label for="cvc" class=" col-form-label">CVC</label>
                <input type="number" class="form-control" id="cvc" name="cvc" placeholder="CVC">
            </div>

        </div>

    </div>

    <div class="btn-wallet">
        <button class="btn org">Add</button>
    </div>
</form>

<div class="go-back">
<button style="background-color: transparent; border-width: 0;" onclick="window.location.href='./wallet.php';">
        <img class="image-back" src="icons/icons8-back-arrow-32.png" alt="back"/>
        <span>Go back to wallet</span>
    </button>
</div>
</body>
</html>
