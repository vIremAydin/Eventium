<?php
require('connection.php');    
session_start();

$sql = "SELECT * FROM user NATURAL LEFT OUTER JOIN non_admin NATURAL LEFT OUTER JOIN participant NATURAL LEFT OUTER JOIN organizer NATURAL LEFT OUTER JOIN verified_organizer";
$query = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="style/admin-style.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
</head>
<body>
<h3>Review Users</h3>
<div>
    <div class="review-container">
       
            <div>
            <?php while( $result = $query->fetch_assoc() ) {
                if ($result['first_name'] == null) {
                    continue;
                }?>
                <div class="review-item">
                    <div class="item">Id: <?php echo $result['user_id'];?></div>
                    <div class="item">Name: <?php if ($result['middle_name'] == null) {
                        echo $result['first_name'] . " " . $result['last_name'];
                    } else {
                        echo $result['first_name'] . " " . $result['middle_name'] . " " . $result['last_name'];
                    }?></div>
                    <div>
                        <button class="btn org" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample<?php echo $result['user_id'];?>"
                                aria-expanded="false" aria-controls="collapseExample">
                            View Details
                        </button>
                    </div>

                    <div>
                        <?php if ($result['is_banned'] == 0) { ?>
                            <button class="btn" type="button" style="background-color: red" onclick="window.location.href='./ban_unban.php?id=<?php echo $result['user_id']; ?>&user=2&ad=1';">
                                Ban User
                            </button><?php } ?>
                        <?php if( $result['is_banned'] == 1 ) { ?>
                            <button class="btn" type="button" style="background-color: green; color: white" onclick="window.location.href='./ban_unban.php?id=<?php echo $result['user_id'];?>&user=3&ad=1';">
                                Unban User
                            </button><?php } ?>
                    </div>

                </div>
                <div class="collapse" id="collapseExample<?php echo $result['user_id'];?>">
                    <div class="card card-body">
                        <div>Phone: <?php echo $result['phone'];?></div>
                        <div>Location: <?php echo $result['city'];?></div>
                        <div>Birth Date: <?php echo $result['date_of_birth'];?></div>
                        <div>Participation points: <?php echo $result['participation_points'];?></div>
                        <div>Popularity: <?php echo $result['organizer_popularity'];?></div>
                        <?php if ($result['organization_name'] != null) { ?>
                            <div>Company: <?php echo $result['organization_name'];?></div>
                            <div>IBAN: <?php echo $result['iban'];?></div>
                            <div>Verification date: <?php echo $result['verification_date'];?></div>
                            <div>ID of the verifier: <?php echo $result['admin_id'];?></div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            </div>
        

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
