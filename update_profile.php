<?php
require('connection.php');
session_start();
$id = $_SESSION['user_id'];
$sql1 = "SELECT * FROM non_admin NATURAL JOIN participant NATURAL JOIN user WHERE user_id = '$id'";
$query1 = $connection->query($sql1);
$result1 = $query1->fetch_assoc();



$connection->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Profile</title>
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

    <div class="col-2 mt-3 disable">
        Your Information
    </div>

    <div class="col-2 mt-2">
        <button id="reg-btn" type="button" class="btn btn-light" onclick="window.location.href='./organizer_home.php';">Organize Event</button>
    </div>

    <div class="col-1 mt-3">
        <a href="./logout.php"><img class="image-back" src="icons/arrow-right-circle.svg" alt="back"/></a>

    </div>
</div>

<form method="post" action="./update.php">
    <div class="container">
        <div class="mb-3 row bottom-line">
            <div class="col-sm-4 align-self-center">
                <label for="mail" class="col-4 col-form-label">Change Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="<?php echo $result1['email']; ?>">
            </div>

            <div class="col-sm-4 align-self-center">
                <label for="password" class="col-6 col-form-label">Change Password</label>
                <input type="password" placeholder="New Password" class="form-control" id="password1" name="password1">
            </div>
            <div class="col-sm-4 align-self-center">
                <label for="password2" class="col-6 col-form-label">Confirm Password</label>
                <input type="password" placeholder="Confirm Password" class="form-control" id="password2" name="password2">
            </div>
        </div>
        <div class="name">Change Information</div>
        <div class="mb-3 row">

            <div class="col-sm-4 align-self-center">
                <label for="first_name" class="col-sm-4 col-form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="<?php echo $result1['first_name']; ?>">
            </div>
            <div class="col-sm-4 align-self-center">
                <label for="middle_name" class="col-sm-4 col-form-label">Middle Name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="<?php echo $result1['middle_name']; ?>">
            </div>

            <div class="col-sm-4 align-self-center">
                <label for="last_name" class="col-sm-4 col-form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="<?php echo $result1['last_name']; ?>">
            </div>

        </div>


        <div class="mb-3 row">

            <div class="col-sm-4 align-self-center">
                <label for="city" class="col-sm-4 col-form-label">City</label>
                <select class="form-control" name="city" id="city">
                    <option value="" disabled selected><?php echo $result1['city']; ?></option>
                    <option value="Istanbul">İstanbul</option>
                    <option value="Ankara">Ankara</option>
                    <option value="Izmir">İzmir</option>
                    <option value="Adana">Adana</option>
                    <option value="Antalya">Antalya</option>
                </select>
            </div>
            <div class="col-sm-4 align-self-center">
                <label for="province" class="col-sm-4 col-form-label">Province</label>
                <input type="text" class="form-control" id="province" name="province" placeholder="<?php echo $result1['province']; ?>">
            </div>

            <div class="col-sm-4 align-self-center">
                <label for="street" class="col-sm-4 col-form-label">Street</label>
                <input type="text" class="form-control" id="street" name="street" placeholder="<?php echo $result1['street']; ?>">
            </div>

        </div>


        <div class="mb-3 row">
            <div class="col-sm-4 align-self-center">
                <label for="postal_code" class="col-sm-4 col-form-label">Postal Code</label>
                <input type="number" class="form-control" id="postal_code" name="postal_code" placeholder="<?php echo $result1['postal_code']; ?>" min="01000" maxlength="5">
            </div>
            <div class="col-sm-4 align-self-center">
                <label for="phone" class="col-sm-4 col-form-label">Phone</label>
                <input type="number" class="form-control" id="phone" name="phone" placeholder="<?php echo $result1['phone']; ?>" maxlength="11">
            </div>

            <div class="col-sm-4 align-self-center">
                <label for="bdate" class="col-sm-4 col-form-label">Birth Date</label>
                <input type="date" class="form-control" id="bdate" name="bdate" placeholder="Birth Date" min="1920-01-01" max="2020-01-01">
            </div>

        </div>


    </div>


    <div class="row">
        <div class="col-5">
        </div>
        <div class="col-6">
            <button id="update-btn" type="submit" class="btn org" value="Update">Update</button>

        </div>
    </div>
</form>

<div class="go-back">
    <button style="background-color: transparent; border-width: 0;" onclick="window.location.href='./participant_home.php';">
        <img class="image-back" src="icons/icons8-back-arrow-32.png" alt="back"/>
        <span>Go back to the home page</span>
    </button>
</div>

<script>
  document.querySelectorAll('input[type="number"]').forEach(input => {
    input.oninput = () =>{
      if(input.value.length > input.maxLength) input.value = input.value.slice(0, input.maxLength);
    }
  });
</script>

</body>
</html>
