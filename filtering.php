<?php
require('connection.php');    
session_start();
$id = $_SESSION['user_id'];
$age = $_GET['age'];

/*
echo "<script type='text/javascript'>alert('AAAAAAAA!');</script>";

if(isset($_POST['filter_date']) && strlen($_POST['filter_date'])) {
    echo "<script type='text/javascript'>alert('filter_date!');</script>";
}
if(isset($_POST['filter_title']) && strlen($_POST['filter_title'])) {
    echo "<script type='text/javascript'>alert('filter_title!');</script>";
}
if(isset($_POST['filter_org']) && strlen($_POST['filter_org'])) {
    echo "<script type='text/javascript'>alert('filter_org!');</script>";
}
if(isset($_POST['filter_cate']) && strlen($_POST['filter_cate'])) {
    echo "<script type='text/javascript'>alert('filter_cate!');</script>";
}
if(isset($_POST['date_sort']) && strlen($_POST['date_sort'])) {
    echo "<script type='text/javascript'>alert('date_sort!');</script>";
}

$filterDate = $_POST['filter_date'];
$filterTitle = $_POST['filter_title'];
$filterOrg = $_POST['filter_org'];
$filterCate = $_POST['filter_cate'];
$sortDate = $_POST['date_sort'];*/

$sql = "SELECT E.event_id, E.event_date, E.event_title, CONCAT(N.first_name, ' ', N.last_name) as full_name, V.organization_name, E.event_category 
        FROM event E NATURAL JOIN non_admin N NATURAL LEFT OUTER JOIN verified_organizer V
        WHERE E.event_date > CURRENT_TIMESTAMP AND event_location in (SELECT NA.city FROM non_admin NA WHERE NA.user_id = '$id' AND ('$age' >= E.age_restriction OR E.age_restriction IS NULL)) ";

if( strlen($_POST['filter_date']) ) {
        echo "<script type='text/javascript'>alert('work in progress');</script>";
} else {

    if (strlen($_POST['filter_title'])) {
        $sql .= " AND E.event_title LIKE '%" . $_POST['filter_title'] . "%'";

    } else if (strlen($_POST['filter_org'])) {
        $sql .= " AND ( full_name LIKE '%" . $_POST['filter_org'] . "%' OR V.organization_name LIKE '%" . $_POST['filter_org'] . "%')";
    
    }

}

$_SESSION['sql'] = $sql;
header("location: event_filter.php");
$connection->close();
?>