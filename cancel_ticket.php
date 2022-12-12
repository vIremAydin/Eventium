<?php
    session_start();
    require('connection.php');

    $ticketID = $_GET['data'];
    $userID = $_SESSION['user_id'];
    $sql1 = " DELETE FROM purchase WHERE ticket_id = '$ticketID' AND user_id = '$userID'";
    $sql2 = " DELETE FROM ticket WHERE ticket_id = '$ticketID'";
    if($connection->query($sql1) && $connection->query($sql2)) {
        header("Location: ticket.php");
    } else {
        echo "<script type='text/javascript'>alert('Participation of . $ticketID . can not be cancelled!');</script>";
        echo("<script>window.location = 'participant_home.php';</script>");
    }
    $connection->close();   
?>