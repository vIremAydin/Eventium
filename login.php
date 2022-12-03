<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <title>Login Page</title>
</head>
<body>
<div>
  <div class="mx-auto" style="width: 500px; color:red">
    <h1 class="my-4">Welcome To Eventium</h1>
  </div>
<form method="post">
  <div class="mb-3 row">
    <div class="col-3">
    </div>
    <div class="col-sm-6 align-self-center">
      <label for="login-mail" class="col-sm-2 col-form-label">Email</label>

      <input type="text" class="form-control" name="login-mail" id="login-mail" placeholder="enter your email">
    </div>

  </div>
  <div class="mb-3 row">
    <div class="col-3">
    </div>
    <div class="col-sm-6 align-self-center">
      <label for="login-password" class="col-sm-2 col-form-label">Password</label>
      <input type="password" placeholder="enter your password" class="form-control" name="login-password" id="login-password">
    </div>
  </div>

  <div class="row">
    <div class="col-5">
    </div>
    <div class="col-6">
      <button id="login-btn" type="submit" class="btn btn-primary" value="Submit">Login</button>
      <a href="./register.php">Not registered yet?</a>
    </div>
  </div>
</form>
</div>

</body>
</html>

<?php
    require('connection.php');
    
    session_start();

    if( isset($_POST['login-mail']) && isset($_POST['login-password']) ) {

      if( $statement = $connection->prepare( "SELECT nickname, password FROM user NATURAL JOIN admin WHERE nickname = ? and password = ?")){
        
          $statement->bind_param( "ss", $_POST['login-mail'], $_POST['login-password']);
          
          
          if( $statement->execute()){
            
              if( $statement->fetch()){
                  $_SESSION['login-mail'] = $_POST['login-mail'];
                  $_SESSION['login-password'] = $_POST['login-password'];
                  
                  header( "location: admin_home.php");
              } 
          }
      }

      $statement->close();

  }

    if( isset($_POST['login-mail']) && isset($_POST['login-password']) ) {

        if( $statement = $connection->prepare( "SELECT email, password FROM user WHERE email = ? and password = ?")){
          
            $statement->bind_param( "ss", $_POST['login-mail'], $_POST['login-password']);
            
            
            if( $statement->execute()){
              
                if( $statement->fetch()){
                    $_SESSION['login-mail'] = $_POST['login-mail'];
                    $_SESSION['login-password'] = $_POST['login-password'];
                    
                    header( "location: participant_home.php");
                } else {
                    echo "<script type='text/javascript'>alert('Incorrect information!');</script>";
                }
            }
        }

        $statement->close();

    }
?>
