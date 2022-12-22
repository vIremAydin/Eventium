<?php
session_start();
require('connection.php');
$userID = $_SESSION['user_id'];
$eventID = $_GET['id'];
$page = $_GET['page'];


if(isset($_POST['title']) && strlen($_POST['title'])) {
    $connection->query("UPDATE event SET event_title = '".$_POST['title']."' WHERE event_id = '$eventID'");
}

if(isset($_POST['description']) && strlen($_POST['description'])) {
    $connection->query("UPDATE event SET event_description = '".$_POST['description']."' WHERE event_id = '$eventID'");
}

if(isset($_POST['location']) && strlen($_POST['location'])) {
    $connection->query("UPDATE event SET event_location = '".$_POST['location']."' WHERE event_id = '$eventID'");
}

if(isset($_POST['date']) && strlen($_POST['date'])) {
    $connection->query("UPDATE event SET event_date = '".$_POST['date']."' WHERE event_id = '$eventID'");
}

if(isset($_POST['category']) && strlen($_POST['category'])) {
    $connection->query("UPDATE event SET event_category = '".$_POST['category']."' WHERE event_id = '$eventID'");
}

if(isset($_POST['quota']) && strlen($_POST['quota'])) {
    $temp = $connection->query("SELECT COUNT('user_id') as count FROM joins WHERE event_id = '$eventID'");
    $newQuota = (int)$_POST['quota'] - (int)($temp->fetch_assoc())['count'];
    $connection->query("UPDATE event SET event_quota = '$newQuota' WHERE event_id = '$eventID'");
}

if(isset($_POST['age_restriction']) && strlen($_POST['age_restriction'])) {
    $connection->query("UPDATE event SET age_restriction = '".$_POST['age_restriction']."' WHERE event_id = '$eventID'");
}

if ($page == "v") {

    if(isset($_POST['ticket_category']) && strlen($_POST['ticket_category'])) {
        $query = $connection->query("SELECT COUNT('event_id') as ticket_categories FROM price WHERE event_id = '$eventID'");
        $ticketCategories = ($query->fetch_assoc())['ticket_categories'];
        $total = $ticketCategories + 1;
// HOW TO UPDATE A FUCKING TICKET PRICE WITH ONLY A NUMBER FOR CATEGORY IMMA LOSE MY MIND
        $connection->query("UPDATE event SET ticket_category = '".$_POST['ticket_category']."' WHERE event_id = '$eventID'");
    }

    header("Location: ./verified_edit_event.php?id=".urlencode($eventID));
} else {
    header("Location: ./edit_event.php?id=".urlencode($eventID));
}

?>