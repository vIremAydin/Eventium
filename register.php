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
                    <input type="number" class="form-control" name="postal-code" id="postal-code" placeholder="Postal Code" required="required">
                </div>
                <div class="col-sm-4 align-self-center">
                    <label for="phone" class="col-sm-4 col-form-label">Phone</label>
                    <input type="number" class="form-control" name="phone" id="phone" placeholder="Phone" required="required">
                </div>

                <div class="col-sm-4 align-self-center">
                    <label for="bdate" class="col-sm-4 col-form-label">Birth Date</label>
                    <input  type="date" class="form-control" name="bdate" id="bdate" placeholder="Birth Date" required="required">
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

</body>
</html>

<?php
    require('connection.php');    
    session_start();

    echo "<script type='text/javascript'>alert('bok öncesi');</script>";
    if( isset($_POST['email']) && isset($_POST['password']) && isset($_POST['first-name']) && isset($_POST['last-name']) && isset($_POST['city']) && isset($_POST['province']) && isset($_POST['street']) && isset($_POST['postal-code']) && isset($_POST['phone']) && isset($_POST['bdate']) ) {
        echo "<script type='text/javascript'>alert('bok');</script>";
        if( $statement = $connection->prepare( "INSERT INTO user VALUES (NULL, ?, ?) ") ){
            $statement->bind_param( "ss", $_POST['password'], $_POST['email']);
            echo "<script type='text/javascript'>alert('bind 1st query');</script>";
            if ($statement->execute()) {
                echo "<script type='text/javascript'>alert('execute 1st query');</script>";
                $mail = $_POST['email'];
                $statement = $connection->query("SELECT user_id FROM user WHERE email = '$mail'");
                $userID = ($statement->fetch_assoc())['user_id'];
                if($statement = $connection->prepare( "INSERT INTO non_admin VALUES ('$userID', ?, ?, ?, ?, ?, ?, ?, ?, ?) " )){
                    echo "<script type='text/javascript'>alert('prepare 2nd query');</script>";
                    $statement->bind_param( "ssssssiss", $_POST['first-name'], $_POST['middle-name'], $_POST['last-name'], $_POST['street'], $_POST['province'], $_POST['city'], $_POST['postal-code'], $_POST['bdate'], $_POST['phone'] );
                    echo "<script type='text/javascript'>alert('bind 2nd query');</script>";
                    if ($statement->execute()) {
                        echo "<script type='text/javascript'>alert('You have now registered!');</script>";
                        echo("<script>window.location = 'login.php';</script>");
                    } else {
                        echo "<script type='text/javascript'>alert('second query did not execute!');</script>";
                    }
                }

            } else {
                echo "<script type='text/javascript'>alert('This email is already in use!');</script>";
            }
        }
  
        $statement->close();
  
    }

?>