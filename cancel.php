<?php
    session_start();
    require('connection.php');

    $eventID = $_GET['data'];
    $userID = $_SESSION['user_id'];
    $sql1 = " DELETE FROM joins WHERE event_id = '$eventID' AND user_id = '$userID'";
    if($connection->query($sql1)) {
        header("Location: participant_home.php");
    } else {
        echo "<script type='text/javascript'>alert('Participation of . $eventID . can not be cancelled!');</script>";
        echo("<script>window.location = 'participant_home.php';</script>");
    }
    $connection->close();   
?>
