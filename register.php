<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <title>Register Page</title>
</head>
<body>

<div>
    <div class="mx-auto" style="width: 500px; color:red">
        <h1 class="my-4">Register To Eventium</h1>
    </div>
    <form method="post">
        <div class="container">

            <div class="mb-3 row">
                <div class="col-sm-6 align-self-center">
                    <label for="mail" class="col-sm-2 col-form-label">Email</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Email" required="required">
                </div>

                <div class="col-sm-6 align-self-center">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <input type="password" placeholder="Password" class="form-control" name="password" id="password" required="required">
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-sm-4 align-self-center">
                    <label for="first-name" class="col-sm-4 col-form-label">First Name</label>
                    <input type="text" class="form-control" name="first-name" id="first-name" placeholder="First Name" required="required">
                </div>
                <div class="col-sm-4 align-self-center">
                    <label for="middle-name" class="col-sm-4 col-form-label">Middle Name</label>
                    <input type="text" class="form-control" name="middle-name" id="middle-name" placeholder="Middle Name">
                </div>

                <div class="col-sm-4 align-self-center">
                    <label for="last-name" class="col-sm-4 col-form-label">Last Name</label>
                    <input  type="text" class="form-control" name="last-name" id="last-name" placeholder="Last Name" required="required">
                </div>

            </div>





            <div class="mb-3 row">
                <div class="col-sm-4 align-self-center">
                    <label for="city" class="col-sm-4 col-form-label">City</label>
                    <input type="text" class="form-control" name="city" id="city" placeholder="City" required="required">
                </div>
                <div class="col-sm-4 align-self-center">
                    <label for="province" class="col-sm-4 col-form-label">Province</label>
                    <input type="text" class="form-control" name="province" id="province" placeholder="province" required="required">
                </div>

                <div class="col-sm-4 align-self-center">
                    <label for="street" class="col-sm-4 col-form-label">Street</label>
                    <input  type="text" class="form-control" name="street" id="street" placeholder="Street" required="required">
                </div>

            </div>




            <div class="mb-3 row">
                <div class="col-sm-4 align-self-center">
                    <label for="postal-code" class="col-sm-4 col-form-label">Postal Code</label>
                    <input type="number" class="form-control" name="postal-code" id="postal-code" placeholder="Postal Code" required="required" min="01000" maxlength="5">
                </div>
                <div class="col-sm-4 align-self-center">
                    <label for="phone" class="col-sm-4 col-form-label">Phone</label>
                    <input type="number" class="form-control" name="phone" id="phone" placeholder="Phone" required="required" maxlength="11">
                </div>

                <div class="col-sm-4 align-self-center">
                    <label for="bdate" class="col-sm-4 col-form-label">Birth Date</label>
                    <input  type="date" class="form-control" name="bdate" id="bdate" placeholder="Birth Date" required="required" min="1920-01-01" max="2020-01-01">
                </div>

            </div>
            <div class="row">
                <!--
                <div class="col-5">
                </div>-->
                <div class="col-6">
                    <button id="reg-btn" type="submit" class="btn btn-primary" value="Submit">Register</button>
                </div>
            </div>
        </div>
    </form>




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

<?php
    require('connection.php');
    session_start();

    if( isset($_POST['email']) && isset($_POST['password']) && isset($_POST['first-name']) && isset($_POST['last-name']) && isset($_POST['city']) && isset($_POST['province']) && isset($_POST['street']) && isset($_POST['postal-code']) && isset($_POST['phone']) && isset($_POST['bdate']) ) {
        if( $statement = $connection->prepare( "INSERT INTO user VALUES (NULL, ?, ?) ") ){
            $statement->bind_param( "ss", $_POST['password'], $_POST['email']);
            if ($statement->execute()) {
                $mail = $_POST['email'];
                $statement = $connection->query("SELECT user_id FROM user WHERE email = '$mail'");
                $userID = ($statement->fetch_assoc())['user_id'];
                if($statement = $connection->prepare( "INSERT INTO non_admin VALUES ('$userID', ?, ?, ?, ?, ?, ?, ?, ?, ?, 0) " )){
                    $statement->bind_param( "ssssssiss", ucfirst(strtolower($_POST['first-name'])), ucfirst(strtolower($_POST['middle-name'])), ucfirst(strtolower($_POST['last-name'])), $_POST['street'], $_POST['province'], ucfirst(strtolower($_POST['city'])), $_POST['postal-code'], $_POST['bdate'], $_POST['phone'] );
                    if ($statement->execute()) {
                        if($stmt = $connection->prepare( "INSERT INTO participant VALUES ('$userID', 0) " ) ){
                          if ($stmt->execute()) {
                            if($stmt2 = $connection->prepare( "INSERT INTO organizer VALUES ('$userID', 0) " ) ){
                              if ($stmt2->execute()) {
                                echo "<script type='text/javascript'>alert('Registration is successful!');</script>";
                              }
                            }
                          }
                        }
                        echo("<script>window.location = 'login.php';</script>");
                    } else {
                        echo "<script type='text/javascript'>alert('This phone number is in use!');</script>";
                        if($stmt3 = $connection->prepare( "DELETE FROM user WHERE user_id = '$userID' " ) ){
                          if ($stmt3->execute()) {
                            echo "<script type='text/javascript'>alert('Deleting!');</script>";
                          }
                        }
                    }
                }

            } else {
                echo "<script type='text/javascript'>alert('This email is already in use!');</script>";
            }
        }

        $statement->close();

    }

?>
