<?php
session_start();
require('connection.php');
$eventID = $_GET['id'];


$sql1 = "SELECT * FROM event WHERE event_id = '$eventID'";
$query1 = $connection->query($sql1);
$result1 = $query1->fetch_assoc();

$result3 = ($connection->query("SELECT event_id FROM paid_event WHERE event_id = '$eventID'"))->fetch_assoc();
if (isset($result3['event_id'])) {
  $sql2 = "SELECT COUNT('ticket_id') as count FROM purchase NATURAL JOIN ticket WHERE event_id = '$eventID'";
  $query2 = $connection->query($sql2);
  $result2 = $query2->fetch_assoc();
} else {
  $sql2 = "SELECT COUNT('user_id') as count FROM joins WHERE event_id = '$eventID'";
  $query2 = $connection->query($sql2);
  $result2 = $query2->fetch_assoc();
}

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
    <div class="title-v">Editing Event: <?php echo $result1['event_title'];?></div>
    <div class="box-v">
      <div class="box-item">
        <label for="title" class="col-sm-4 col-form-label">Title</label>
        <input  type="text" class="form-control" id="title" placeholder="<?php echo $result1['event_title'];?>">
      </div>
      <div class="box-item">
        <label class="col-sm-4 col-form-label" for="floatingTextarea2">Details</label>
        <textarea class="form-control" placeholder="<?php echo $result1['event_description'];?>" id="floatingTextarea2" style="height: 100px"></textarea>
      </div>
      <div class="box-item">
        <label for="Location" class="col-sm-4 col-form-label">Location</label>
        <input  type="text" class="form-control" id="Location" placeholder="<?php echo $result1['event_location'];?>">
      </div>

      <div class="box-item">
        <label for="Date" class="col-sm-4 col-form-label">Date</label>
        <input  type="date" class="form-control" id="Date" placeholder="<?php echo $result1['event_date'];?>">
      </div>

      <div class="box-item">
        <label class="col-sm-4 col-form-label" for="floatingSelect">Choose A Category</label>

        <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
          <option disabled selected>Categories...</option>
          <option value="Gathering">Gathering</option>
          <option value="Sports">Sports</option>
          <option value="Business">Business</option>
          <option value="Food&Drink">Food&Drink</option>
          <option value="Visual Arts">Visual Arts</option>
        </select>
      </div>

      <div class="box-item">
        <label for="Quota" class="col-sm-4 col-form-label">Enter A Quota</label>
        <input  type="number" class="form-control" id="Quota" placeholder="<?php echo (int) $result1['event_quota'] + (int) $result2['count'];?>">
      </div>

      <div class="box-item">
        <label class="col-sm-4 col-form-label" for="floatingSelect1">Choose An Age Restriction</label>

        <select class="form-select" id="floatingSelect1" aria-label="Floating label select example">
          <option value="" disabled selected>Restrictions..</option>
          <option value="0">None</option>
          <option value="7">+7</option>
          <option value="18">+18</option>
          <option value="21">+21</option>
        </select>
      </div>
      
      <?php if (isset($result3['event_id'])) { 
        $sql = "SELECT row_number() over ( PARTITION by event_id ORDER BY ticket_price DESC ) category, ticket_price FROM price WHERE event_id = '".$result3['event_id']."'";
        $tickets = $connection->query($sql);
        while ($res = $tickets->fetch_assoc()) { ?>
          <div class="box-item">
            <label for="new_price<?php echo $res['category'];?>" class="col-sm-4 col-form-label">Ticket Price for Category <?php echo $res['category'];?></label>
            <input type="number" class="form-control" id="new_price<?php echo $res['category'];?>" name="new_price<?php echo $res['category'];?>" placeholder="<?php echo $res['ticket_price']; ?>">
            <button type="button">Remove</button>
          </div>
      <?php } } ?>
    </div>
  </div>
  <div class="evt-btn-container">
    <button class="btn pink">Update</button>
  </div>
</form>


<div class="go-back">
  <button style="background-color: transparent; border-width: 0;" onclick="window.location.href='./verifiedOrganizer_home.php';">
      <img class="image-back" src="icons/icons8-back-arrow-32.png" alt="back"/>
      <span>Go back to the home page</span>
  </button>
</div>

</body>
</html>
