<?php
require('connection.php');    
session_start();

$sql = "SELECT * FROM event NATURAL LEFT OUTER JOIN paid_event NATURAL LEFT OUTER JOIN non_admin NATURAL LEFT OUTER JOIN organizer NATURAL LEFT OUTER JOIN verified_organizer";
$query = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="style/admin-style.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
</head>
<body>
<h3>Review Events</h3>
<div>
    <div class="review-container">
    <?php while( $result = $query->fetch_assoc() ) {?>
                <div class="review-item">
                    <div class="item">Id: <?php echo $result['event_id'];?></div>
                    <div class="item">Title: <?php echo $result['event_title'];?></div>
                    <div class="item">by <?php if ($result['organization_name'] != null) {
                        echo $result['organization_name'];
                    } else {
                        echo $result['first_name'] . " " . $result['last_name'];
                    }?></div>
                    <p>
                        <button class="btn org" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample<?php echo $result['event_id'];?>"
                                aria-expanded="false" aria-controls="collapseExample">
                            View Details
                        </button>
                    </p>

                    <p>
                        <?php if ($result['organization_name'] == null) { ?>
                            <button class="btn" type="button" style="background-color: red" onclick="window.location.href='./cancel_event.php?id=<?php echo $result['event_id']; ?>&user=2&ad=1';">
                                Cancel/Remove
                            </button>
                        <?php } else { ?>
                            <button class="btn" type="button" style="background-color: red" onclick="window.location.href='./cancel_event.php?id=<?php echo $result['event_id'];?>&user=3&ad=1';">
                                Cancel/Remove
                            </button><?php } ?>
                    </p>

                </div>
                <div class="collapse" id="collapseExample<?php echo $result['event_id'];?>">
                    <div class="card card-body">
                        <div>Location: <?php echo $result['event_location'];?></div>
                        <div>Event Date: <?php if (date("Y-m-d") > $result['event_date']) {
                            echo $result['event_date']." (PAST)";
                        } else if (date("Y-m-d") == $result['event_date']) {
                            echo $result['event_date']." (TODAY)";
                        } else {
                            echo $result['event_date']." (UPCOMING)";
                        }?></div>
                        <div>Remaining Quota: <?php echo $result['event_quota'];?></div>
                        <div>Total Quota: <?php 
                        $temp = $connection->query("SELECT COUNT('user_id') as count FROM joins WHERE event_id = '".$result['event_id']."'");
                        echo (int)$result['event_quota'] + (int)($temp->fetch_assoc())['count'];
                        ?></div>
                        <div>Age Restriction: <?php if ($result['age_restriction'] != null) {
                            echo "+".$result['age_restriction'];
                        } else {
                            echo "NONE";
                        }?></div>
                        <div>Organizer ID: <?php echo $result['user_id'];?></div>
                        <div>Organizer Phone: <?php echo $result['phone'];?></div>    
                        <div>Is Verified: <?php if ($result['organization_name'] != null) {
                            echo "YES";
                        } else {
                            echo "NO";
                        }?></div>                
                
                    </div>
                </div>
            <?php } ?>


        <!--div>
            <div class="review-item">
                <div class="item">Id: 1234</div>
                <div class="item">Organizer: BSO</div>
                <div class="item">Name: Concert</div>
                <p>
                    <button class="btn org" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample2"
                            aria-expanded="false" aria-controls="collapseExample">
                        View Details
                    </button>
                </p>

                <p>
                    <button class="btn" type="button" style="background-color: red">
                        Cancel Event
                    </button>
                </p>

            </div>
            <div class="collapse" id="collapseExample2">
                <div class="card card-body">
                    <div>Location: Ankara</div>
                    <div>Event Date: 01.01.2000</div>
                    <div>Quota: 33</div>
                    <div>Age Restriction: None</div>
                    <div>Is Verified: Yes</div>
                    <div>Organizer Phone: 055555555</div>
                    <div>Organizer ID: 1111</div>
                </div>
            </div>
        </div-->
    </div>
</div>

<div class="go-back">
    <button style="background-color: transparent; border-width: 0;" onclick="window.location.href='./admin_home.php';">
        <img class="image-back" src="icons/icons8-back-arrow-32.png" alt="back"/>
        <span>Go back to the home page</span>
    </button>
</div>

</body>
</html>
