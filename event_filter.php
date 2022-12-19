<?php
require('connection.php');    
session_start();
$id = $_SESSION['user_id'];
$sql1 = "SELECT first_name, participation_points, city FROM non_admin NATURAL JOIN participant WHERE user_id = '$id'";
$query1 = $connection->query($sql1);
$result1 = $query1->fetch_assoc();

//$sql2 = "SELECT E.event_date, E.event_title, N.first_name, N.last_name, E.event_category 
//        FROM event E NATURAL JOIN non_admin N
//        WHERE E.event_date > CURRENT_TIMESTAMP AND event_location in (SELECT NA.city FROM non_admin NA WHERE NA.user_id = 3 AND 20 >= E.age_restriction)";

$sql2 = "SELECT E.event_id, E.event_date, E.event_title, N.first_name, N.last_name, V.organization_name, E.event_category 
        FROM event E NATURAL JOIN non_admin N NATURAL LEFT OUTER JOIN verified_organizer V
        WHERE E.event_date > CURRENT_TIMESTAMP AND event_location in (SELECT NA.city FROM non_admin NA WHERE NA.user_id = '$id' AND (70 > E.age_restriction OR E.age_restriction IS NULL))";

$query2 = $connection->query($sql2);

$connection->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Event Filter</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
          crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style/participant.css">
</head>
<body>

<div class="header row align-items-center">
  <div class="col-4 my-header" style="font-size: 30px;">
    Welcome <?php echo $result1['first_name']; ?>!
  </div>

  <div class="col-3 mt-3">
    Participation points: <?php echo $result1['participation_points']; ?>
  </div>

  <div class="col-2 mt-3">
    <a href="./update_profile.php" style="color: whitesmoke; text-decoration: none;">Your Info</a>
  </div>

  <div class="col-2 mt-2">
    <button id="reg-btn" type="button" class="btn btn-light" onclick="window.location.href='./organizer_home.php';">Organize Event</button>
  </div>

  <div class="col-1 mt-3">
    <a href="./logout.php"><img class="image-back" src="icons/arrow-right-circle.svg" alt="back"/></a>

  </div>
</div>
<div>
  <div class="row mx-4 my-4 justify-content-end">
    <div class="col-1">
      <button id="btn1" type="button" class="btn org" onclick="window.location.href='./ticket.php';"> Tickets</button>
    </div>
    <div class="col-1">
      <button id="btn2" type="button" class="btn org" onclick="window.location.href='./wallet.php';"> Wallet</button>
    </div>
  </div>
  <h3 class="search-box" style="margin-bottom: 20px;">Events in <?php echo $result1['city']; ?></h3>

  <div>
    <form class="d-flex filter-box">
      <label for="search">Filters:  </label>
      <input id="search" type="date" placeholder="Filter by Date">
      <input id="search1" class="" type="text" placeholder="Filter by Title" aria-label="Search an event">
      <input id="search2" class="me-2" type="text" placeholder="Filter by Organizer" aria-label="Search an event">
      <div>
        <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
          <option selected>Choose a Category</option>
          <option value="0">Music</option>
          <option value="1">Gathering</option>
          <option value="2">Sports</option>
          <option value="3">Business</option>
          <option value="4">Food&Drink</option>
          <option value="4">Visual Arts</option>
        </select>
      </div>
      <button class="btn btn-success" type="submit">Filter</button>
      <div>
        <select class="form-select" id="floatingSelect1" aria-label="Floating label select example">
          <option selected>Sort</option>
          <option value="1">Farthest to Closest</option>
          <option value="2">Closest to Farthest</option>
        </select>
      </div>
    </form>
  </div>

</div>
<div class="filter-display">

  <ul>
  <?php while($result2 = $query2->fetch_assoc()){ ?>
       <li>
        <div class="date"><?php echo $result2['event_date']; ?></div>
        <div class="name"><?php echo $result2['event_title']; ?></div>
        <div class="name">
          <?php if (isset($result2['organization_name'])) {
                  echo $result2['organization_name'];
                } else {
                  echo $result2['first_name'] . " " . $result2['last_name'];
                } ?>
        </div>
        <div class="name"><?php echo $result2['event_category']; ?></div>
        <div >
          <button class="cancel" style="background-color: #198754;" onclick="window.location.href='./event_detail.php?id=<?php echo $result2['event_id'];?>&page=2';">details</button>
        </div>
       </li>
  <?php } ?>
  </ul>

</div>

<div class="go-back">
    <button style="background-color: transparent; border-width: 0;" onclick="window.location.href='./participant_home.php';">
        <img class="image-back" src="icons/icons8-back-arrow-32.png" alt="back"/>
        <span>Go back to the home page</span>
    </button>
</div>

</body>
</html>
