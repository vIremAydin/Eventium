<?php
session_start();
require('connection.php');

$userID = $_GET['id'];
$banFlag = $_GET['ban'];
$true = "true";


if ( strcmp( $banFlag, $true ) === 0 ) {
    $sql = "UPDATE non_admin SET is_banned = 1 WHERE user_id = '$userID'";
    if ($connection->query($sql)) {
        echo "<script type='text/javascript'>alert('The user ".$userID." is now banned from this application!');</script>";
    } else {
        echo "<script type='text/javascript'>alert('The user can not the banned!');</script>";        
    }
} else {
    $sql = "UPDATE non_admin SET is_banned = 0 WHERE user_id = '$userID'";
    if ($connection->query($sql)) {
        echo "<script type='text/javascript'>alert('The ban of the user ".$userID." is now lifted!');</script>";
    } else {
        echo "<script type='text/javascript'>alert('The ban can not be lifted!');</script>";        
    }
}


echo "<script>window.location = 'admin_review_users.php';</script>";

?>