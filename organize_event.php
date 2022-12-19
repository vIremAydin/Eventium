<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style/participant.css">
    <link rel="stylesheet" href="style/add-event.css">

</head>
<body>
<div class="container">
    <div class="title">Create An Event</div>
    <form method="post">
<div class="box">
    <div class="box-item">
        <label for="title" class="col-sm-4 col-form-label">Title</label>
        <input  type="text" class="form-control" id="title" name="title" placeholder="Title" required="required">
    </div>
    <div class="box-item">
        <label class="col-sm-4 col-form-label" for="floatingTextarea2">Details</label>
        <textarea class="form-control" placeholder="Please explain details of the event..." id="description" name="description" required="required" style="height: 100px"></textarea>
    </div>
    <div class="box-item">
        <label for="Location" class="col-sm-4 col-form-label">Location</label>
        <input  type="text" class="form-control" id="location" name="location" placeholder="Location" required="required">
    </div>

    <div class="box-item">
        <label for="Date" class="col-sm-4 col-form-label">Date</label>
        <input  type="date" class="form-control" id="date" name="date" placeholder="Date" required="required">
    </div>

    <div class="box-item">
        <label class="col-sm-4 col-form-label" for="floatingSelect">Choose A Category</label>

            <select class="form-select" id="category" name="category" aria-label="Floating label select example" required="required">
                <option value="Music" selected>Music</option>
                <option value="Gathering">Gathering</option>
                <option value="Sports">Sports</option>
                <option value="Business">Business</option>
                <option value="Food&Drink">Food&Drink</option>
                <option value="Visual Arts">Visual Arts</option>
            </select>
    </div>

    <div class="box-item">
        <label for="Quota" class="col-sm-4 col-form-label">Enter A Quota</label>
        <input  type="number" class="form-control" id="quota" name="quota" placeholder="Quota" required="required">
    </div>

    <div class="box-item">
        <label class="col-sm-4 col-form-label" for="floatingSelect1">Choose An Age Restriction</label>

        <select class="form-select" id="age_restriction" name="age_restriction" aria-label="Floating label select example" required="required">
            <option value="0" selected>None</option>
            <option value="7">+7</option>
            <option value="18">+18</option>
        </select>
    </div>
</div>
</div>
<div class="evt-btn-container">
    <button class="btn org" type="submit" value="Submit">Create!</button>
</div>
</form>


<div class="go-back">
    <button style="background-color: transparent; border-width: 0;" onclick="window.location.href='./organizer_home.php';">
      <img class="image-back" src="icons/icons8-back-arrow-32.png" alt="back"/>
      <span>Go back to the home page</span>
  </button>
</div>

</body>
</html>

<?php
require('connection.php');
session_start();

$uid = $_SESSION['user_id'];

echo "<script type='text/javascript'>alert('AAAAAAAA!');</script>";

if(isset($_POST['title'])) {
    echo "<script type='text/javascript'>alert('title!');</script>";
}
if(isset($_POST['description'])) {
    echo "<script type='text/javascript'>alert('description!');</script>";
}
if(isset($_POST['location'])) {
    echo "<script type='text/javascript'>alert('location!');</script>";
}
if(isset($_POST['date'])) {
    echo "<script type='text/javascript'>alert('date!');</script>";
}
if(isset($_POST['category'])) {
    echo "<script type='text/javascript'>alert('category!');</script>";
}
if(isset($_POST['quota'])) {
    echo "<script type='text/javascript'>alert('quota!');</script>";
}
if(isset($_POST['age_restriction'])) {
    echo "<script type='text/javascript'>alert('age_restriction!');</script>";
}

if( isset($_POST['title']) && isset($_POST['description']) && isset($_POST['location']) && isset($_POST['date']) && isset($_POST['category']) && isset($_POST['quota']) ) {
    echo "<script type='text/javascript'>alert('AAAAAAAA!');</script>";
    if( $statement = $connection->prepare( "INSERT INTO event (`event_id`, `user_id`, `event_location`, `event_date`, `event_category`, `event_title`, `event_description`, `event_quota`, `age_restriction`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?)") ){
        $statement->bind_param( "isssssii", $uid, $_POST['location'], $_POST['date'], $_POST['category'], $_POST['title'], $_POST['description'], $_POST['quota'], $_POST['age_restriction'] );
        if ($statement->execute()) {
            echo "<script type='text/javascript'>alert('Event is added!');</script>";
        } else {
            echo "<script type='text/javascript'>alert('Event creation is failed!!');</script>";
        }
    }
}
?>