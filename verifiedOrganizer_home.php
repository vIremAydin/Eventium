<?php
require('connection.php');    
session_start();
$id = $_SESSION['user_id'];
$sql1 = "SELECT organization_name, organizer_popularity, iban FROM organizer NATURAL JOIN verified_organizer WHERE user_id = '$id'";
$query1 = $connection->query($sql1);
$result1 = $query1->fetch_assoc();

$sql2 = "SELECT event_title, event_date, event_location, event_quota, event_id
         FROM event E
         WHERE E.user_id = '$id' and E.event_date > CURRENT_TIMESTAMP";

$query2 = $connection->query($sql2);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verified Organizer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
            crossorigin="anonymous"></script>

    <link rel="stylesheet" href="style/organizer-style.css">
</head>
<body>
<div class="header row align-items-center" style="background-color: deeppink">
    <div class="col-8 my-header" style="font-size: 30px;" >
        <?php echo $result1['organization_name']; ?>
    </div>

    <div class="col-1 mt-3">
        Popularity: <?php echo $result1['organizer_popularity']; ?>
    </div>
    <!--div class="col-2 mt-3">
        
    </div-->
    <div class="col-2 mt-3">
        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModal">Add IBAN
        </button>
    </div>

    <div class="col-1 mt-3">
        <a href="./logout.php"><img class="image-back" src="icons/arrow-right-circle.svg" alt="back"/></a>
    </div>
</div>

<div class="span-style">Your Ongoing Events</div>


<div class="table-container">

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Date</th>
            <th scope="col" style="text-align: center;">Location</th>
            <th scope="col" style="text-align: center;">Remaining Quota</th>
            <th scope="col"> </th>
        </tr>
        </thead>
        <tbody>
        <?php while ($result2 = $query2->fetch_assoc()) { ?>
            
            <tr>
                <th scope="row"><?php echo $result2['event_title'];?></th>
                <td><?php echo $result2['event_date'];?></td>
                <td style="text-align: center;"><?php echo $result2['event_location'];?></td>
                <td style="text-align: center;"><?php echo $result2['event_quota'];?></td>
                <td>
                    <button class="edit" onclick="window.location.href='./verified_edit_event.php?id=<?php echo $result2['event_id'];?>';">edit</button>
                    <button class="view" onclick="window.location.href='./view_participants.php?id=<?php echo $result2['event_id'];?>&user=3';">view participants</button>
                    <button class="cancel" onclick="window.location.href='./cancel_event.php?id=<?php echo $result2['event_id'];?>&user=3&ad=0';">cancel</button>
                </td>
            </tr>
                
        <?php } ?>
        </tbody>
    </table>



</div>


<div class="organize-btn-container">
    <button id="pink-btn" type="button" class="btn pink" onclick="window.location.href='./verified_add_event.php';">Organize A New Event!</button>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="./update_iban.php">
                <div class="modal-body">
                    <div class="card-container">
                        <div style="display: flex; margin: 15px">
                            <label for="iban" class="col-sm-4 col-form-label">Enter Your IBAN</label>
                            <input type="text" class="form-control" id="iban" name="iban" placeholder="<?php echo $result1['iban']; ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!--button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button-->
                    <button type="submit" class="btn btn-primary">Add IBAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
