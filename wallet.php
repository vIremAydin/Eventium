<?php
require('connection.php');    
session_start();
$id = $_SESSION['user_id'];
$sql1 = "SELECT participation_points FROM participant WHERE user_id = '$id'";
$query1 = $connection->query($sql1);
$result1 = $query1->fetch_assoc();

$sql2 = "SELECT wallet_id, balance FROM has NATURAL JOIN wallet WHERE user_id = '$id'";
$query2 = $connection->query($sql2);
$result2 = $query2->fetch_assoc();

$sql3 = "SELECT * FROM wallet NATURAL JOIN card WHERE wallet_id = '".$result2['wallet_id']."'";
$query3 = $connection->query($sql3);
$query4 = $connection->query($sql3);

$connection->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wallet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>    <link rel="stylesheet" href="style/participant.css">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style/wallet-style.css">
</head>
<body>

<div class="header row align-items-center">
    <div class="col-4 my-header" style="font-size: 30px;">
        Your Wallet
    </div>

    <div class="col-3 mt-3">
        <!--Participation points: -->
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

<div>
    <div class="row mx-4 my-4 justify-content-end">
        <div class="col-1">
            <button id="btn2" type="button" class="btn org" onclick="window.location.href='./ticket.php';"> Tickets</button>
        </div>
        <!--div class="col-1">
            <button id="btn2" type="button" class="btn org" disabled> Wallet</button>
        </div-->
    </div>

</div>

<div class="row">
    <div class="col-6 card-box">
        <div class="name" style="text-align: center; font-size: 25px">Your Saved Cards</div>
        <div class="card-container">
        <?php while($result3 = $query3->fetch_assoc()){ ?>
            <div class="card">
                <div class="card-item"><?php echo $result3['card_no'];?></div>
                <div class="card-item">Valid by: <?php echo date("m", strtotime($result3['valid_date'])) . "/" . date("y", strtotime($result3['valid_date'])); ?></div>
                <button class="btn btn-light" onclick="window.location.href='./remove_card.php?no=<?php echo $result3['card_no'];?>&id=<?php echo $result3['wallet_id'];?>';">Remove</button>
            </div>
        <?php } ?>
        </div>
        <div class=" btn-card">
            <button class="btn org" onclick="window.location.href='./add_card.php';">Add a New Card</button>
        </div>

    </div>
    <div class="col-6">
        <div class="row box-out">
            <div class="col-5">
                <img class="image-wallet" src="icons/wallet.png" alt="back"/>
            </div>
            <div class="col-7 card-box">
                <div class="box-in">
                    <div>Total Balance: <?php echo $result2['balance'];?>TL</div>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModal">Increase Balance</button>
                </div>
                <div>Total Participation Points: <?php echo $result1['participation_points']; ?></div>
            </div>
        </div>


    </div>

</div>

<div class="go-back">
<button style="background-color: transparent; border-width: 0;" onclick="window.location.href='./participant_home.php';">
        <img class="image-back" src="icons/icons8-back-arrow-32.png" alt="back"/>
        <span>Go back to the home page</span>
    </button>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Saved Cards</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="./add_balance.php">
                <div class="modal-body">
                    <div class="card-container">
                        <?php while($result4 = $query4->fetch_assoc()){ ?>
                            <div class="card">
                                <div class="card-item"><?php echo $result4['card_no'];?></div>
                                <div class="card-item">Valid by: <?php echo date("m", strtotime($result4['valid_date'])) . "/" . date("y", strtotime($result4['valid_date'])); ?></div>
                                <button class="btn btn-light" onclick="return false;">Select</button>
                            </div>
                        <?php } ?>
                        <div style="display: flex; margin: 15px">
                            <label for="amount" class="col-sm-4 col-form-label">Enter An Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Amount" min="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Balance</button>
                </div>
            </form>
        </div>
    </div>
</div>


</body>
</html>
