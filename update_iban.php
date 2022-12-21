<?php
require('connection.php');    
session_start();
$id = $_SESSION['user_id'];


$sql = "UPDATE verified_organizer SET iban = '".$_POST['iban']."' WHERE user_id = '$id'";
$connection->query($sql);
header("Location: verifiedOrganizer_home.php");

$connection->close();

?>