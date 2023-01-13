<?php
require('connection.php');
session_start();
$id = $_SESSION['user_id'];
$age = $_GET['age'];


$sql = "SELECT E.event_id, E.event_date, E.event_title, CONCAT(N.first_name, ' ', N.last_name) as full_name, V.organization_name, E.event_category
        FROM event E NATURAL JOIN non_admin N NATURAL LEFT OUTER JOIN verified_organizer V
        WHERE E.event_date > CURRENT_TIMESTAMP AND event_location in (SELECT NA.city FROM non_admin NA WHERE NA.user_id = '$id' AND ('$age' >= E.age_restriction OR E.age_restriction IS NULL)) ";

if( strlen($_POST['min_date']) || strlen($_POST['max_date']) ) {
    $min = $_POST['min_date'];
    $max = $_POST['max_date'];

    if (strlen($_POST['min_date']) && strlen($_POST['max_date'])) {
        $sql .= " AND E.event_date >= '$min' AND E.event_date <= '$max'";

        if (strlen($_POST['filter_title']) && strlen($_POST['filter_cate']) && strlen($_POST['filter_org'])) {
            $sql .= " AND E.event_title LIKE '%" . $_POST['filter_title'] . "%'";
            $sql .= " AND ( CONCAT(N.first_name, ' ' , N.last_name) LIKE '%" . $_POST['filter_org'] . "%' OR V.organization_name LIKE '%" . $_POST['filter_org'] . "%')";
            $sql .= " AND E.event_category = '" . $_POST['filter_cate']."'";

        } else if (strlen($_POST['filter_title']) && strlen($_POST['filter_org'])) {
            $sql .= " AND E.event_title LIKE '%" . $_POST['filter_title'] . "%'";
            $sql .= " AND ( CONCAT(N.first_name, ' ' , N.last_name) LIKE '%" . $_POST['filter_org'] . "%' OR V.organization_name LIKE '%" . $_POST['filter_org'] . "%')";

        } else if (strlen($_POST['filter_title']) && strlen($_POST['filter_cate'])) {
            $sql .= " AND E.event_title LIKE '%" . $_POST['filter_title'] . "%'";
            $sql .= " AND E.event_category = '" . $_POST['filter_cate']."'";

        } else if (strlen($_POST['filter_cate']) && strlen($_POST['filter_org'])) {
            $sql .= " AND E.event_category = '" . $_POST['filter_cate']."'";
            $sql .= " AND ( CONCAT(N.first_name, ' ' , N.last_name) LIKE '%" . $_POST['filter_org'] . "%' OR V.organization_name LIKE '%" . $_POST['filter_org'] . "%')";

        } else if (strlen($_POST['filter_title'])) {
            $sql .= " AND E.event_title LIKE '%" . $_POST['filter_title'] . "%'";

        } else if (strlen($_POST['filter_org'])) {
            $sql .= " AND ( CONCAT(N.first_name, ' ' , N.last_name) LIKE '%" . $_POST['filter_org'] . "%' OR V.organization_name LIKE '%" . $_POST['filter_org'] . "%')";

        } else if (strlen($_POST['filter_cate'])) {
            $sql .= " AND E.event_category = '" . $_POST['filter_cate']."'";

        }

    } else if (strlen($_POST['min_date'])) {
        $sql .= " AND E.event_date >= '$min'";

        if (strlen($_POST['filter_title']) && strlen($_POST['filter_cate']) && strlen($_POST['filter_org'])) {
            $sql .= " AND E.event_title LIKE '%" . $_POST['filter_title'] . "%'";
            $sql .= " AND ( CONCAT(N.first_name, ' ' , N.last_name) LIKE '%" . $_POST['filter_org'] . "%' OR V.organization_name LIKE '%" . $_POST['filter_org'] . "%')";
            $sql .= " AND E.event_category = '" . $_POST['filter_cate']."'";

        } else if (strlen($_POST['filter_title']) && strlen($_POST['filter_org'])) {
            $sql .= " AND E.event_title LIKE '%" . $_POST['filter_title'] . "%'";
            $sql .= " AND ( CONCAT(N.first_name, ' ' , N.last_name) LIKE '%" . $_POST['filter_org'] . "%' OR V.organization_name LIKE '%" . $_POST['filter_org'] . "%')";

        } else if (strlen($_POST['filter_title']) && strlen($_POST['filter_cate'])) {
            $sql .= " AND E.event_title LIKE '%" . $_POST['filter_title'] . "%'";
            $sql .= " AND E.event_category = '" . $_POST['filter_cate']."'";

        } else if (strlen($_POST['filter_cate']) && strlen($_POST['filter_org'])) {
            $sql .= " AND E.event_category = '" . $_POST['filter_cate']."'";
            $sql .= " AND ( CONCAT(N.first_name, ' ' , N.last_name) LIKE '%" . $_POST['filter_org'] . "%' OR V.organization_name LIKE '%" . $_POST['filter_org'] . "%')";

        } else if (strlen($_POST['filter_title'])) {
            $sql .= " AND E.event_title LIKE '%" . $_POST['filter_title'] . "%'";

        } else if (strlen($_POST['filter_org'])) {
            $sql .= " AND ( CONCAT(N.first_name, ' ' , N.last_name) LIKE '%" . $_POST['filter_org'] . "%' OR V.organization_name LIKE '%" . $_POST['filter_org'] . "%')";

        } else if (strlen($_POST['filter_cate'])) {
            $sql .= " AND E.event_category = '" . $_POST['filter_cate']."'";

        }

    } else if (strlen($_POST['max_date'])) {
        $sql .= " AND E.event_date <= '$max'";

        if (strlen($_POST['filter_title']) && strlen($_POST['filter_cate']) && strlen($_POST['filter_org'])) {
            $sql .= " AND E.event_title LIKE '%" . $_POST['filter_title'] . "%'";
            $sql .= " AND ( CONCAT(N.first_name, ' ' , N.last_name) LIKE '%" . $_POST['filter_org'] . "%' OR V.organization_name LIKE '%" . $_POST['filter_org'] . "%')";
            $sql .= " AND E.event_category = '" . $_POST['filter_cate']."'";

        } else if (strlen($_POST['filter_title']) && strlen($_POST['filter_org'])) {
            $sql .= " AND E.event_title LIKE '%" . $_POST['filter_title'] . "%'";
            $sql .= " AND ( CONCAT(N.first_name, ' ' , N.last_name) LIKE '%" . $_POST['filter_org'] . "%' OR V.organization_name LIKE '%" . $_POST['filter_org'] . "%')";

        } else if (strlen($_POST['filter_title']) && strlen($_POST['filter_cate'])) {
            $sql .= " AND E.event_title LIKE '%" . $_POST['filter_title'] . "%'";
            $sql .= " AND E.event_category = '" . $_POST['filter_cate']."'";

        } else if (strlen($_POST['filter_cate']) && strlen($_POST['filter_org'])) {
            $sql .= " AND E.event_category = '" . $_POST['filter_cate']."'";
            $sql .= " AND ( CONCAT(N.first_name, ' ' , N.last_name) LIKE '%" . $_POST['filter_org'] . "%' OR V.organization_name LIKE '%" . $_POST['filter_org'] . "%')";

        } else if (strlen($_POST['filter_title'])) {
            $sql .= " AND E.event_title LIKE '%" . $_POST['filter_title'] . "%'";

        } else if (strlen($_POST['filter_org'])) {
            $sql .= " AND ( CONCAT(N.first_name, ' ' , N.last_name) LIKE '%" . $_POST['filter_org'] . "%' OR V.organization_name LIKE '%" . $_POST['filter_org'] . "%')";

        } else if (strlen($_POST['filter_cate'])) {
            $sql .= " AND E.event_category = '" . $_POST['filter_cate']."'";

        }

    }

} else {

    if (strlen($_POST['filter_title']) && strlen($_POST['filter_cate']) && strlen($_POST['filter_org'])) {
        $sql .= " AND E.event_title LIKE '%" . $_POST['filter_title'] . "%'";
        $sql .= " AND ( CONCAT(N.first_name, ' ' , N.last_name) LIKE '%" . $_POST['filter_org'] . "%' OR V.organization_name LIKE '%" . $_POST['filter_org'] . "%')";
        $sql .= " AND E.event_category = '" . $_POST['filter_cate']."'";

    } else if (strlen($_POST['filter_title']) && strlen($_POST['filter_org'])) {
        $sql .= " AND E.event_title LIKE '%" . $_POST['filter_title'] . "%'";
        $sql .= " AND ( CONCAT(N.first_name, ' ' , N.last_name) LIKE '%" . $_POST['filter_org'] . "%' OR V.organization_name LIKE '%" . $_POST['filter_org'] . "%')";

    } else if (strlen($_POST['filter_title']) && strlen($_POST['filter_cate'])) {
        $sql .= " AND E.event_title LIKE '%" . $_POST['filter_title'] . "%'";
        $sql .= " AND E.event_category = '" . $_POST['filter_cate']."'";

    } else if (strlen($_POST['filter_cate']) && strlen($_POST['filter_org'])) {
        $sql .= " AND E.event_category = '" . $_POST['filter_cate']."'";
        $sql .= " AND ( CONCAT(N.first_name, ' ' , N.last_name) LIKE '%" . $_POST['filter_org'] . "%' OR V.organization_name LIKE '%" . $_POST['filter_org'] . "%')";

    } else if (strlen($_POST['filter_title'])) {
        $sql .= " AND E.event_title LIKE '%" . $_POST['filter_title'] . "%'";

    } else if (strlen($_POST['filter_org'])) {
        $sql .= " AND ( CONCAT(N.first_name, ' ' , N.last_name) LIKE '%" . $_POST['filter_org'] . "%' OR V.organization_name LIKE '%" . $_POST['filter_org'] . "%')";

    } else if (strlen($_POST['filter_cate'])) {
        $sql .= " AND E.event_category = '" . $_POST['filter_cate']."'";

    }
}


$sql .= " ORDER BY E.event_date " . $_POST['date_sort'];

$_SESSION['sql'] = $sql;
echo "<script>window.location = './event_filter.php';</script>";
$connection->close();
?>
