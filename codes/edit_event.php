<?php
session_start();
require('connection.php');
$eventID = $_GET['id'];


$sql1 = "SELECT * FROM event WHERE event_id = '$eventID'";
$query1 = $connection->query($sql1);
$result1 = $query1->fetch_assoc();

$sql2 = "SELECT COUNT('user_id') as count FROM joins WHERE event_id = '$eventID'";
$query2 = $connection->query($sql2);
$result2 = $query2->fetch_assoc();

$connection->close();

?>

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

<form method="post" action="./update_event.php?id=<?php echo $eventID;?>">
  <div class="container">
    <div class="title">Editing Event: <?php echo $result1['event_title'];?></div>
      <div class="box">
        <div class="box-item">
          <label for="title" class="col-sm-4 col-form-label">Title</label>
          <input  type="text" class="form-control" id="title" name="title" placeholder="<?php echo $result1['event_title'];?>">
        </div>
        <div class="box-item">
          <label class="col-sm-4 col-form-label" for="description">Details</label>
          <textarea class="form-control" placeholder="<?php echo $result1['event_description'];?>" id="description" name="description" style="height: 100px"></textarea>
        </div>
        <div class="box-item">
          <label for="location" class="col-sm-4 col-form-label">Location</label>
          <input  type="text" class="form-control" id="location" name="location" placeholder="<?php echo $result1['event_location'];?>">
        </div>

        <div class="box-item">
          <label for="date" class="col-sm-4 col-form-label">Date</label>
          <input  type="date" class="form-control" id="date" name="date" placeholder="Date">
        </div>

        <div class="box-item">
          <label class="col-sm-4 col-form-label" for="category">Choose A Category</label>

          <select class="form-select" id="category" name="category" aria-label="Floating label select example">
              <option value="" disabled selected>Categories..</option>
              <option value="Music">Music</option>
              <option value="Gathering">Gathering</option>
              <option value="Sports">Sports</option>
              <option value="Business">Business</option>
              <option value="Food&Drink">Food&Drink</option>
              <option value="Visual Arts">Visual Arts</option>
          </select>
        </div>

        <div class="box-item">
          <label for="quota" class="col-sm-4 col-form-label">Enter A Quota</label>
          <input  type="number" class="form-control" id="quota" name="quota" placeholder="<?php echo (int) $result1['event_quota'] + (int) $result2['count'];?>">
        </div>

        <div class="box-item">
          <label class="col-sm-4 col-form-label" for="age_restriction">Choose An Age Restriction</label>

          <select class="form-select" id="age_restriction" name="age_restriction" aria-label="Floating label select example">
            <option value="" disabled selected>Restrictions..</option>
            <option value="0">None</option>
            <option value="7">+7</option>
            <option value="18">+18</option>
          </select>
        </div>
      </div>
  </div>
  <div class="evt-btn-container">
    <button id="update-btn" type="submit" class="btn org" value="Update">Update</button>
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
