 <?php

require('connection.php');    
session_start();
$id = $_SESSION['user_id'];


if (isset($_POST['email']) && strlen($_POST['email'])) {
    $email = $_POST['email'];
    $connection->query("UPDATE user SET email = '$email' WHERE user_id = '$id'");
}

if (isset($_POST['password1']) && isset($_POST['password2']) && strlen($_POST['password1']) && strlen($_POST['password2'])) {
    if (strcmp($_POST['password1'], $_POST['password2']) === 0) {
        
        $connection->query("UPDATE user SET password = '".$_POST['password1']."' WHERE user_id = '$id'");

    } else {
        echo "<script type='text/javascript'>alert('The passwords must match!');</script>";
    }
}

if (isset($_POST['first_name']) && strlen($_POST['first_name'])) {
    $first_name = ucfirst(strtolower($_POST['first_name']));
    $connection->query("UPDATE non_admin SET first_name = '$first_name' WHERE user_id = '$id'");
}

if (isset($_POST['middle_name']) && strlen($_POST['middle_name'])) {
    $middle_name = ucfirst(strtolower($_POST['middle_name']));
    $connection->query("UPDATE non_admin SET middle_name = '$middle_name' WHERE user_id = '$id'");
}

if (isset($_POST['last_name']) && strlen($_POST['last_name'])) {
    $last_name = ucfirst(strtolower($_POST['last_name']));
    $connection->query("UPDATE non_admin SET last_name = '$last_name' WHERE user_id = '$id'");
}

if (isset($_POST['city']) && strlen($_POST['city'])) {
    $city = ucfirst(strtolower($_POST['city']));
    $connection->query("UPDATE non_admin SET city = '$city' WHERE user_id = '$id'");
}

if (isset($_POST['province']) && strlen($_POST['province'])) {
    $province = ucfirst(strtolower($_POST['province']));
    $connection->query("UPDATE non_admin SET province = '$province' WHERE user_id = '$id'");
}

if (isset($_POST['street']) && strlen($_POST['street'])) {
    $street = ucfirst(strtolower($_POST['street']));
    $connection->query("UPDATE non_admin SET street = '$street' WHERE user_id = '$id'");
}

if (isset($_POST['postal_code']) && strlen($_POST['postal_code'])) {
    $connection->query("UPDATE non_admin SET postal_code = '".$_POST['postal_code']."' WHERE user_id = '$id'");
}

if (isset($_POST['phone']) && strlen($_POST['phone'])) {
    $connection->query("UPDATE non_admin SET phone = '".$_POST['phone']."' WHERE user_id = '$id'");
}

if (isset($_POST['bdate']) && strlen($_POST['bdate'])) {
    $connection->query("UPDATE non_admin SET date_of_birth = '".$_POST['bdate']."' WHERE user_id = '$id'");
}

echo "<script>window.location = 'update_profile.php';</script>";

?>