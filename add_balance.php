<?php
require('connection.php');    
session_start();
$id = $_SESSION['user_id'];
$sql1 = "SELECT balance, wallet_id FROM has NATURAL JOIN wallet WHERE user_id = '$id'";
$query1 = $connection->query($sql1);
$result1 = $query1->fetch_assoc();

$balance = $result1['balance'];
$addition = $_POST['amount'];
$balance += $addition;

$sql2 = "UPDATE wallet SET balance = '$balance' WHERE wallet_id = '".$result1['wallet_id']."'";
$connection->query($sql2);

header("location: ./wallet.php");

$connection->close();

?>