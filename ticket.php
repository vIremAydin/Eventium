<?php
require('connection.php');    
session_start();
$id = $_SESSION['user_id'];
$sql1 = "SELECT T.ticket_id, E.event_title, E.event_date, P.purchase_date, T.ticket_price, T.is_refundable
        FROM ticket T NATURAL JOIN purchase P NATURAL JOIN participant PA, event E
        WHERE T.event_id = E.event_id AND P.user_id = PA.user_id AND E.event_date >= CURRENT_DATE AND ticket_id in ( SELECT ticket_id
                                                                                                                     FROM purchase
                                                                                                                     WHERE purchase.user_id = '$id' );";
$query1 = $connection->query($sql1);
$count = 0;

$connection->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="participant.css">

</head>
<body>
<div class="header row align-items-center">
    <div class="col-8 my-header" style="font-size: 30px;">
        Your Tickets
    </div>

    <div class="col-1 mt-3">
        Your Info
    </div>

    <div class="col-2 mt-2">
        <button id="reg-btn" type="button" class="btn btn-light" onclick="window.location.href='./organizer_home.php';">Organize Event</button>
    </div>

    <div class="col-1 mt-3">
        <a href="./logout.php"><img class="image-back" src="icons/arrow-right-circle.svg" alt="back"/></a>
    </div>
</div>

<div class="row mx-4 my-4 justify-content-end">
    <div class="col-1">
        <button id="btn2" type="button" class="btn org"> Wallet</button>
    </div>
</div>

<div class="table-container">

    <table class="table table-striped">
        <thead style="display:table-header-group;">
        <tr>
            <th scope="col">Ticket ID</th>
            <th scope="col">Event Title</th>
            <th scope="col">Event Date</th>
            <th scope="col">Purchase Date</th>
            <th scope="col">Price</th>
            <th scope="col"> </th>
        </tr>
        </thead>
        <tbody>
        <?php while ($result1 = $query1->fetch_assoc()) { ?>
            
        <tr>
            <th scope="row"><?php echo $result1['ticket_id'];?></th>
            <td><?php echo $result1['event_title'];?></td>
            <td><?php echo $result1['event_date'];?></td>
            <td><?php echo $result1['purchase_date'];?></td>
            <td><?php echo $result1['ticket_price'];?></td>
            <?php if ($result1['is_refundable'] == 0) {
            ?> <td><button class="cancel" onclick="return false;" style="background-color: #DDDDDD;">cancel</button></td><?php
            } else { ?>
            <td><button class="cancel" onclick="window.location.href='./cancel_ticket.php?data=<?php echo $result1['ticket_id']; ?>';">cancel</button></td>
            <?php } ?>
            </tr>
            
        <?php } ?>
        </tbody>
    </table>

</div>

<div class="go-back">
    <button style="background-color: transparent; border-width: 0;" onclick="window.location.href='./participant_home.php';">
        <img class="image-back" src="icons/icons8-back-arrow-32.png" alt="back"/>
        <span>Go back to the home page</span>
    </button>
</div>

</body>
</html>