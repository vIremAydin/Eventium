<?php
    session_start();
    require('connection.php');

    $userType = $_GET['user'];
    $eventID = $_GET['id'];
    $userID = $_SESSION['user_id'];

    if ( $userType == 1 ) {
        $sql1 = " DELETE FROM joins WHERE event_id = '$eventID' AND user_id = '$userID'";
        if($connection->query($sql1)) {
            header("Location: participant_home.php");
        } else {
            echo "<script type='text/javascript'>alert('Participation of . $eventID . can not be cancelled!');</script>";
            echo("<script>window.location = 'participant_home.php';</script>");
        }
        
    } else if ( $userType == 2 ){
        $sql2 = " DELETE FROM joins WHERE event_id = '$eventID'";
        $query2 = $connection->query($sql2);
        $sql3 = " DELETE FROM event WHERE event_id = '$eventID'";
        $query3 = $connection->query($sql3);
        if($query2 && $query3) {
            header("Location: organizer_home.php");
        } else {
            echo "<script type='text/javascript'>alert('Organization of event . $eventID . can not be cancelled!');</script>";
            echo("<script>window.location = 'organizer_home.php';</script>");
        }
    }

    $connection->close();   
?>
