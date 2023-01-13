<?php
require('connection.php');
session_start();
$eventID = $_GET['id'];
$userType = $_GET['user'];
$userID = $_SESSION['user_id'];

$sql1 = "SELECT event_title FROM event WHERE event_id = '$eventID'";
$query1 = $connection->query($sql1);
$result1 = $query1->fetch_assoc();

if ($userType == 2) {       //enters from organizer home page
    #$sql2 = "SELECT N.first_name, N.middle_name, N.last_name, N.date_of_birth, N.phone, N.user_id FROM joins J NATURAL JOIN non_admin N WHERE J.user_id = N.user_id AND J.event_id = '$eventID'";
    $sql2 = "SELECT * FROM view".strval($eventID);
    $query2 = $connection->query($sql2);
} else if ($userType == 3) {            // enters from verified organzer home page
    $sql2 = "SELECT DISTINCT N.user_id, N.first_name, N.middle_name, N.last_name, N.date_of_birth, N.phone FROM purchase P NATURAL JOIN ticket T NATURAL JOIN non_admin N WHERE T.event_id = '$eventID'";
    $query2 = $connection->query($sql2);    

    if ($query2->fetch_assoc()) {
        $sql2 = "SELECT DISTINCT N.user_id, N.first_name, N.middle_name, N.last_name, N.date_of_birth, N.phone FROM purchase P NATURAL JOIN ticket T NATURAL JOIN non_admin N WHERE T.event_id = '$eventID'";
        $query2 = $connection->query($sql2);
    } else {
        $sql2 = "SELECT N.first_name, N.middle_name, N.last_name, N.date_of_birth, N.phone, N.user_id FROM joins J NATURAL JOIN non_admin N WHERE J.user_id = N.user_id AND J.event_id = '$eventID'";
        $query2 = $connection->query($sql2);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Participants</title>
    <link rel="stylesheet" href="style/organizer-style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style/view-participant-style.css">
</head>
<body>

<h2>All Participants of <?php echo $result1['event_title']; ?> Event</h2>
<table class="p-container table table-striped">
    <thead>
    <tr>
        <th scope="col">Name</th>
        <th scope="col">Age</th>
        <th scope="col">Phone</th>
        <th scope="col"> </th>
    </tr>
    </thead>
    <tbody>
    <?php while( $result2 = $query2->fetch_assoc() ) { ?>
    <tr>
        <th scope="row"><?php if ($result2['middle_name'] == null) {
            echo $result2['first_name'] . " " . $result2['last_name'];
        } else {
            echo $result2['first_name'] . " " . $result2['middle_name'] . " " . $result2['last_name'];
        }?> </th>
        <td><?php echo date("Y") - (int) $result2['date_of_birth']; ?></td>
        <td><?php echo $result2['phone']; ?></td>
        <td>
            <button class="cancel" onclick="window.location.href='./remove_participant.php?partip=<?php echo $result2['user_id']; ?>&user=<?php echo $userType; ?>&event=<?php echo $eventID; ?>';">remove</button>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>

<div class="go-back">
    <?php if($userType == 2) { ?>
        <button style="background-color: transparent; border-width: 0;" onclick="window.location.href='./organizer_home.php';">
            <img class="image-back" src="icons/icons8-back-arrow-32.png" alt="back"/>
            <span>Go back to the home page</span>
        </button>
    <?php } else if ($userType == 3) { ?>
        <button style="background-color: transparent; border-width: 0;" onclick="window.location.href='./verifiedOrganizer_home.php';">
            <img class="image-back" src="icons/icons8-back-arrow-32.png" alt="back"/>
            <span>Go back to the home page</span>
        </button>
    <?php } ?>
</div>
</body>
</html>
