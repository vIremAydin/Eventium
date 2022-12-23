<?php
require('connection.php');    
session_start();
$id = $_SESSION['user_id'];
$sql1 = "SELECT first_name, participation_points FROM non_admin NATURAL JOIN participant WHERE user_id = '$id'";
$sql2 = "SELECT E.event_id, event_date, event_title, N.first_name, event_description FROM non_admin N, joins J, event E WHERE J.user_id = '$id' AND J.event_id = E.event_id AND E.user_id = N.user_id AND E.event_date >= CURRENT_DATE ORDER BY event_date";
$query1 = $connection->query($sql1);
$result1 = $query1->fetch_assoc();
$query2 = $connection->query($sql2);
$count = 0;

$connection->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Participant Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/participant.css">
</head>
<body>

<div class="header row align-items-center">
    <div class="col-4 my-header" style="font-size: 30px;">
        Welcome <?php echo $result1['first_name']; ?>!
    </div>

    <div class="col-3 mt-3" style="font-size: 20px;">
        Participation points: <?php echo $result1['participation_points']; ?>
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
            <button id="btn1" type="button" class="btn org" onclick="window.location.href='./ticket.php';"> Tickets</button>
        </div>
        <div class="col-1">
            <button id="btn2" type="button" class="btn org" onclick="window.location.href='./wallet.php';"> Wallet</button>
        </div>
    </div>
    <div class="search-box">
        <form class="d-flex" method="post" action="./filtering.php">
            <input class="form-control me-2" type="text" id="filter_title" name="filter_title" placeholder="Search an event" aria-label="Search an event">
            <button class="btn btn-outline-dark" type="submit" onclick="window.location.href='./filtering.php';">Search</button>
        </form>
    </div>

</div>
<div class="container-md box mt-4">
    <h3>Your Upcoming Events</h3>


   <ul>
   <?php while($result2 = $query2->fetch_assoc()){ ?>
       <li>

    
       <div class="date"><?php echo $result2['event_date']; ?></div>
       <div class="name"><?php echo $result2['event_title']; ?></div>
       <div ><?php echo $result2['event_description']; ?></div>
       <div >
       <button class="cancel" style="background-color: #198754;" onclick="window.location.href='./event_detail.php?id=<?php echo $result2['event_id'];?>&page=1';">details</button>
        <button class="cancel" onclick="window.location.href='./cancel_event.php?id=<?php echo $result2['event_id'];?>&user=1&ad=0';">cancel</button>
       </div>
       </li>
       <?php $count = $count + 1; }
            if ($count == 0) {
                ?> <li style="font-size: 25px;"> <div class="container-md box mt-4"> You have no active participations! </div> </li> <?php
            }
       ?>
   </ul>

</div>

</body>
</html>
