<?php
session_start();
require('connection.php');
$no = 'no';
$id = 'id';
$card = $_GET[$no];
$wallet = $_GET[$id];
$sql1 = " DELETE FROM card WHERE card_no = '$card' AND wallet_id = '$wallet'";
if($sql1 == null){
    echo('invalid credidantals!');
}
if($connection->query($sql1)) {
    header("Location: wallet.php");
} else {
    echo "<script type='text/javascript'>alert('The chosen card can not be removed!');</script>";
    echo "<script>window.location = 'wallet.php';</script>";
}  

?>
