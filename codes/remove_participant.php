<?php
require('connection.php');    
session_start();

$userType = $_GET['user'];
$participantID = $_GET['partip'];
$eventID = $_GET['event'];

if( $userType == 2){        // enters as an organizer
    $sql = "DELETE FROM joins WHERE user_id = '$participantID' AND event_id = '$eventID'";
    if ($connection->query($sql)) {
        header("Location: ./view_participants.php?id=".urlencode($eventID)."&user=".urlencode($userType));
    } else {
        echo "<script type='text/javascript'>alert('Participant '". $participantID ."' can not be removed!');</script>";
        echo("<script>window.location = 'view_participants.php?id=".$eventID."&user=".$userType."';</script>");
    }
} else if( $userType == 3 ) {       // enters as a verified organizer
    
    $sql1 = "SELECT ticket_id FROM ticket WHERE event_id = '$eventID'";
    $query1 = $connection->query($sql1);
    while( $result = $query1->fetch_assoc() ){
        $flag = false;
        $sql2 = "DELETE FROM purchase WHERE user_id = '$participantID' AND ticket_id = '" . $result['ticket_id'] . "'";
        if ($connection->query($sql2)) {
            $flag = true;
        }
    }
    
    $sql3 = "UPDATE event SET event_quota = (SELECT event_quota FROM event WHERE event_id = '$eventID')+1 WHERE event_id = '$eventID';";
    
    if ($flag == true && $connection->query($sql3)) {
        header("Location: ./view_participants.php?id=".urlencode($eventID)."&user=".urlencode($userType));
    } else {
        echo "<script type='text/javascript'>alert('Participant '". $participantID ."' can not be removed!');</script>";
        echo("<script>window.location = 'view_participants.php?id=".$eventID."&user=".$userType."';</script>");
    }
}

$connection->close();
?>