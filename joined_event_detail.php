<?php
    session_start();
    require('connection.php');

    $eventID = $_GET['data'];
    $userID = $_SESSION['user_id'];

    $sql1 = "SELECT first_name, participation_points FROM non_admin NATURAL JOIN participant WHERE user_id = '$userID'";
    $query1 = $connection->query($sql1);
    $result1 = $query1->fetch_assoc();
    
    $sql2 = " SELECT event_location, event_date, event_category, event_title, event_description, event_quota, age_restriction, first_name, middle_name, last_name
              FROM event E NATURAL JOIN non_admin N
              WHERE E.event_id = '$eventID'";
    $query2 = $connection->query($sql2);
    $result2 = $query2->fetch_assoc();

    $sql3 = " SELECT COUNT(user_id) AS num_of_participants
              FROM joins J
              WHERE J.event_id = '$eventID'";
    $query3 = $connection->query($sql3);
    $result3 = $query3->fetch_assoc();

    $remaining_quota = (int)$result2['event_quota'] - (int)$result3['num_of_participants'];

    $organizer_name = $result2['first_name'];
    if ($result2['middle_name'] == null) {
        $organizer_name .= " ".$result2['last_name'];
    } else {
        $organizer_name .= " ".$result2['middle_name']." ".$result2['last_name'];
    }

    $connection->close();   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style/participant.css">
</head>
<body>
<div class="header row align-items-center">
    <div class="col-4 my-header" style="font-size: 30px;">
        Welcome <?php echo $result1['first_name']; ?>!
    </div>

    <div class="col-3 mt-3">
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

<div class="container-md box mt-4">
    <h3><?php echo $result2['event_title']; ?></h3>
    <h4><?php echo $result2['event_category']; ?> - by <?php echo $organizer_name; ?></h4>
    <div class="details"><?php echo $result2['event_description']; ?></div>
    <div style="display: flex; justify-content: space-around; margin: 20px">
        <div class="date">Location: <?php echo $result2['event_location']; ?></div>
        <div class="date">Date: <?php echo $result2['event_date']; ?></div>
        <div class="date">Remaining Quota: <?php echo (int) $remaining_quota; ?></div>

    </div>
    <?php if ($result2['age_restriction'] == null) {
                ?> <div style="margin: 10px; font-size: 20px">No age restriction!</div> <?php
    } else { ?>
        <div style="margin: 10px; font-size: 20px">Any one younger than <?php echo $result2['age_restriction']; ?> is not accepted to this event!</div>
    <?php } ?>
    

</div>
<div class="btn-container" style="justify-content: center; text-align: center;">
    <div class="btn" style="background-color: gray; border-width: 0; color: whitesmoke">Joined</div>
</div>

<div class="go-back">
    <button style="background-color: transparent; border-width: 0;" onclick="window.location.href='./participant_home.php';">
        <img class="image-back" src="icons/icons8-back-arrow-32.png" alt="back"/>
        <span>Go back to the home page</span>
    </button>
</div>

</body>
</html>
