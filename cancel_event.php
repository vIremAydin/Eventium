<?php
session_start();
require('connection.php');

$adminAccess = $_GET['ad'];
$userType = $_GET['user'];
$eventID = $_GET['id'];
$userID = $_SESSION['user_id'];


if ( $userType == 1 ) {     // enters from participant home page
    $sql1 = " DELETE FROM joins WHERE event_id = '$eventID' AND user_id = '$userID'";
    if($connection->query($sql1)) {
        header("Location: participant_home.php");
    } else {
        echo "<script type='text/javascript'>alert('Participation of . $eventID . can not be cancelled!');</script>";
        echo("<script>window.location = 'participant_home.php';</script>");
    }
        
} else if ( $userType == 2 ){       // enters from organizer home page
    $sql2 = " DELETE FROM joins WHERE event_id = '$eventID'";
    $query2 = $connection->query($sql2);
    $sql3 = " DELETE FROM event WHERE event_id = '$eventID'";
    $query3 = $connection->query($sql3);
    if($query2 && $query3) {
        if ( $adminAccess == 1 ) {
            header("Location: ./admin_review_events.php");
        } else {
            header("Location: organizer_home.php");
        }
    } else {
        echo "<script type='text/javascript'>alert('Organization of event . $eventID . can not be cancelled!');</script>";
        if ( $adminAccess == 1 ) {
            echo("<script>window.location = './admin_review_events.php';</script>");
        } else {
            echo("<script>window.location = 'organizer_home.php';</script>");
        }
    }

} else if ( $userType == 3 ){       // enters from verified organizer home page
    $sql4 = "SELECT ticket_id FROM ticket WHERE event_id = '$eventID'";
    $query4 = $connection->query($sql4);
    while( $result = $query4->fetch_assoc() ){
        $sql4 = "DELETE FROM purchase WHERE ticket_id = '".$result['ticket_id']."'";
        $connection->query($sql4);
    }
    
    $sql4 = "DELETE FROM ticket WHERE event_id = '$eventID'";
    if ($connection->query($sql4)) {
        $sql4 = "DELETE FROM price WHERE event_id = '$eventID'";
        if ($connection->query($sql4)) {
            $sql4 = "DELETE FROM paid_event WHERE event_id = '$eventID'";
            if ($connection->query($sql4)) {
                $sql4 = "DELETE FROM event WHERE event_id = '$eventID'";
                if ($connection->query($sql4)) {
                    if ( $adminAccess == 1 ) {
                        header("Location: ./admin_review_events.php");
                    }
                    header("Location: verifiedOrganizer_home.php");
                } else {
                    echo "<script type='text/javascript'>alert('Organization of paid event . $eventID . can not be cancelled!');</script>";
                    if ($adminAccess == 1) {
                        echo("<script>window.location = './admin_review_events.php';</script>");
                    }
                    echo("<script>window.location = 'verifiedOrganizer_home.php';</script>");
                }
            } else {
                echo "<script type='text/javascript'>alert('Prices of event . $eventID . remains!');</script>";
                if ($adminAccess == 1) {
                    echo("<script>window.location = './admin_review_events.php';</script>");
                }
                echo("<script>window.location = 'verifiedOrganizer_home.php';</script>");
            }
        } else {
            echo "<script type='text/javascript'>alert('Ticket objects of event . $eventID . remains!');</script>";
            if ($adminAccess == 1) {
                echo("<script>window.location = './admin_review_events.php';</script>");
            }
            echo("<script>window.location = 'verifiedOrganizer_home.php';</script>");
        }
    } else {
        echo "<script type='text/javascript'>alert('Ticket purchases of event . $eventID . remains!');</script>";
        if ($adminAccess == 1) {
            echo("<script>window.location = './admin_review_events.php';</script>");
        }
        echo("<script>window.location = 'verifiedOrganizer_home.php';</script>");
    }
    
    
}

$connection->close();   
?>
