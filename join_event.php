<?php
session_start();
require('connection.php');

$userID = $_SESSION['user_id'];
$eventID = $_GET['data'];


$sql = "SELECT event_date FROM event WHERE event_id = '$eventID'";
$eventDate = (($connection->query($sql))->fetch_assoc())['event_date'];

$sql = "SELECT E.event_date FROM joins J JOIN event E WHERE J.event_id = E.event_id AND J.user_id = '$userID' AND E.event_date = '".$eventDate."'";
$newEventDate = (($connection->query($sql))->fetch_assoc())['event_date'];

if ($eventDate === $newEventDate) {
  echo "<script type='text/javascript'>alert('Collision!');</script>";
  echo "<script>window.location = 'event_filter.php';</script>";
} else {
  if ($connection->query("INSERT INTO joins VALUES ( '" . $userID . "', '" . $eventID . "' )")) {
    echo "<script type='text/javascript'>alert('Participation is successful!');</script>";
    echo "<script>window.location = 'participant_home.php';</script>";
  } else {
    echo "<script type='text/javascript'>alert('Can not participate to this event!');</script>";
    echo "<script>window.location = './event_detail.php?id='$eventID'&page=1';</script>";
  }
}

$connection->close();
?>
