<?php
    session_start();
    require('connection.php');

    $fromPage = $_GET['page'];
    $eventID = $_GET['id'];
    $userID = $_SESSION['user_id'];

    $sql1 = "SELECT first_name, participation_points FROM non_admin NATURAL JOIN participant WHERE user_id = '$userID'";
    $query1 = $connection->query($sql1);
    $result1 = $query1->fetch_assoc();


    $sql2 = "SELECT E.event_id, E.event_date, E.event_title, E.event_description, E.age_restriction, E.event_location, N.first_name, N.middle_name, N.last_name, V.organization_name, E.event_category, E.event_quota, P.max_ticket_per_part
             FROM event E NATURAL LEFT OUTER JOIN paid_event P NATURAL JOIN non_admin N NATURAL LEFT OUTER JOIN verified_organizer V
             WHERE E.event_id = '$eventID'";
    $query2 = $connection->query($sql2);
    $result2 = $query2->fetch_assoc();

    $organizer_name = $result2['first_name'];
    if ($result2['middle_name'] == null) {
        $organizer_name .= " ".$result2['last_name'];
    } else {
        $organizer_name .= " ".$result2['middle_name']." ".$result2['last_name'];
    }

    $sql3 = "SELECT user_id, event_id FROM joins WHERE user_id = '$userID' AND event_id = '$eventID'";
    $query3 = $connection->query($sql3);
    $result3 = $query3->fetch_assoc();

    $sql4 = "SELECT row_number() over ( PARTITION by event_id ORDER BY ticket_price DESC ) category, ticket_price FROM price WHERE event_id = '$eventID'";
    $query4 = $connection->query($sql4);    

    $connection->close();   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style/participant.css">
    <link rel="stylesheet" href="style/wallet-style.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
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

<div class="container-md box mt-4">
    <h3><?php echo $result2['event_title']; ?></h3>
    <h4><?php echo $result2['event_category']; ?> - by <?php echo $organizer_name; ?></h4>
    <div class="details"><?php echo $result2['event_description']; ?></div>
    <div style="display: flex; justify-content: space-around; margin: 20px">
        <div class="date">Location: <?php echo $result2['event_location']; ?></div>
        <div class="date">Date: <?php echo $result2['event_date']; ?></div>
        <div class="date">Remaining Quota: <?php echo $result2['event_quota']; ?></div>
    </div>
    <?php if ($result2['age_restriction'] == 0) {
                ?> <div style="margin: 10px; font-size: 20px">No age restriction!</div> <?php
    } else { ?>
        <div style="margin: 10px; font-size: 20px">Any one younger than <?php echo $result2['age_restriction']; ?> is not accepted to this event!</div>
    <?php } ?>
</div>
<div class="btn-container">
<?php if( isset($result3['user_id']) && isset($result3['event_id']) ){ ?>
    <div class="btn" style="background-color: gray; border-width: 0; color: whitesmoke">Joined</div>
<?php } else if ( isset($result2['organization_name'])  ){ ?>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin-left: 70px">Purchase!</button>
<?php } else { ?>
    <button type="button" class="btn btn-success" style="margin-left: 70px" onclick="window.location.href='./join_event.php?data=<?php echo $result2['event_id']; ?>';">Join!</button>
<?php } ?>
</div>

<div class="go-back">
    <?php if($fromPage == 1) { ?>
        <button style="background-color: transparent; border-width: 0;" onclick="window.location.href='./participant_home.php';">
            <img class="image-back" src="icons/icons8-back-arrow-32.png" alt="back"/>
            <span>Go back to the home page</span>
        </button>
    <?php } else if ($fromPage == 2) { ?>
        <button style="background-color: transparent; border-width: 0;" onclick="window.location.href='./event_filter.php';">
            <img class="image-back" src="icons/icons8-back-arrow-32.png" alt="back"/>
            <span>Go back to the list</span>
        </button>
    <?php } ?>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ticket Categories</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="./purchase_ticket.php">
            <div class="modal-body">
                <div class="card-container">
                    <?php while( $result4 = $query4->fetch_assoc()) { ?>
                        <div class="card">
                            <div class="card-item">Category <?php echo $result4['category']; ?></div>
                            <div class="card-item">Price <?php echo $result4['ticket_price']; ?>$</div>
                            <label for="btn">Select</label>
                            <input type="radio" class="btn btn-light" id="btn" name="btn" value="<?php echo $result4['ticket_price']; ?>">
                        </div>
                    <?php }
                    $_SESSION['event_id'] = $eventID; ?>
                    <div style="display: flex; margin: 15px">
                        <label for="amount" class="col-sm-8 col-form-label">Enter Ticket Amount</label>
                        <input  type="number" class="form-control" id="amount" name="amount" placeholder="Amount" min="0" max="<?php echo $result2['max_ticket_per_part']; ?>">
                    </div>
                    <div style="display: flex; margin: 15px">
                        <label for="refund1" class="col-sm-8 col-form-label">Are tickets refundable: </label>
                        <input type="radio" id="refund1" name="refundable" value="TRUE">
                        <label style="margin: 20px;" for="refund1">Yes</label>
                        <input type="radio" id="refund2" name="refundable" value="FALSE">
                        <label  style="margin: 20px;" for="refund2">No</label>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" >Purchase</button>
            </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
