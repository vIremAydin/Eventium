<?php
session_start();
require('connection.php');

$userID = $_SESSION['user_id'];
$eventID = $_GET['data'];

if ($connection->query("INSERT INTO joins VALUES ( '" . $userID . "', '" . $eventID . "' )")) {
    echo "<script type='text/javascript'>alert('Participation is successful!');</script>";
    echo "<script>window.location = 'participant_home.php';</script>";
} else {
    echo "<script type='text/javascript'>alert('Can not participate to this event!');</script>";
    echo "<script>window.location = './event_detail.php?id='$eventID'&page=1';</script>";
}

$connection->close();
?>