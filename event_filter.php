<?php
require('connection.php');    
session_start();
$id = $_SESSION['user_id'];
$sql1 = "SELECT first_name, participation_points, city, YEAR(date_of_birth) as age_year FROM non_admin NATURAL JOIN participant WHERE user_id = '$id'";
$query1 = $connection->query($sql1);
$result1 = $query1->fetch_assoc();

$age = (int) date("Y") - (int)$result1['age_year'];

if ($_POST['sql'] == null) {
  $sql2 = "SELECT E.event_id, E.event_date, E.event_title, N.first_name, N.last_name, V.organization_name, E.event_category 
        FROM event E NATURAL JOIN non_admin N NATURAL LEFT OUTER JOIN verified_organizer V
        WHERE E.event_date > CURRENT_TIMESTAMP AND event_location in (SELECT NA.city FROM non_admin NA WHERE NA.user_id = '$id' AND ('$age' >= E.age_restriction OR E.age_restriction IS NULL))";
} else {
  $sql2 = $_POST['sql'];
}

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

  <form method="post" action="./filtering.php?age=<?php echo $age; ?>">
    <div class="d-flex filter-box">
      <label for="min_date">Closest Date:  </label>
      <input id="min_date" name="min_date" type="date" placeholder="Closest Date">
      <label for="max_date">Farthest Date:  </label>
      <input id="max_date" name="max_date" type="date" placeholder="Farthest Date">
      <input id="filter_title" name="filter_title" class="" type="text" placeholder="Filter by Title" aria-label="Search an event">
      <input id="filter_org" name="filter_org" class="me-2" type="txt" placeholder="Filter by Organizer" aria-label="Search an event">
      <div>
        <select class="form-select" id="filter_cate" name="filter_cate" aria-label="Floating label select example">
          <option value="" selected>Choose a Category</option>
          <option value="Music">Music</option>
          <option value="Gathering">Gathering</option>
          <option value="Sports">Sports</option>
          <option value="Business">Business</option>
          <option value="Food&Drink">Food&Drink</option>
          <option value="Visual Arts">Visual Arts</option>
        </select>
      </div>
      <div>
        <select class="form-select" id="date_sort" name="date_sort" aria-label="Floating label select example">
          <option >Sort</option>
          <option value="descend">Farthest to Closest</option>
          <option value="ascend" selected>Closest to Farthest</option>
        </select>
      </div>
      <button class="btn btn-success" type="submit">Filter</button>
    </div>
</form>

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
