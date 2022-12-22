<?php 
session_start();
require('connection.php');
$uid = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verified Organizer Add Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style/participant.css">
    <link rel="stylesheet" href="style/add-event.css">

</head>
<body>
<form method="post">
<div class="container">
    <div class="title-v">Create An Event</div>
    <div class="box-v">
        <div class="box-item">
            <label for="title" class="col-sm-4 col-form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Title">
        </div>
        <div class="box-item">
            <label class="col-sm-4 col-form-label" for="description">Details</label>
            <textarea class="form-control" placeholder="Please explain details of the event..." id="description" name="description"
                      style="height: 100px"></textarea>
        </div>
        <div class="box-item">
            <label for="location" class="col-sm-4 col-form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="Location">
        </div>

        <div class="box-item">
            <label for="date" class="col-sm-4 col-form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" placeholder="date">
        </div>

        <div class="box-item">
            <label class="col-sm-4 col-form-label" for="category">Choose A Category</label>

            <select class="form-select" id="category" name="category" aria-label="Floating label select example">
                <option selected disabled>Categories</option>
                <option value="Music">Music</option>
                <option value="Gathering">Gathering</option>
                <option value="Sports">Sports</option>
                <option value="Business">Business</option>
                <option value="Food&Drink">Food&Drink</option>
                <option value="Visual Arts">Visual Arts</option>
            </select>
        </div>

        <div class="box-item">
            <label for="quota" class="col-sm-4 col-form-label">Enter A Quota</label>
            <input type="number" class="form-control" id="quota" name="quota" placeholder="Quota">
        </div>

        <div class="box-item">
            <label class="col-sm-4 col-form-label" for="age_restriction">Choose An Age Restriction</label>

            <select class="form-select" id="age_restriction" name="age_restriction" aria-label="Floating label select example">
                <option value="0"selected>None</option>
                <option value="7">+7</option>
                <option value="18">+18</option>
                <option value="21">+21</option>
            </select>
        </div>
        <script>

            let index = 0;

            function add() {
                index++;

                document.getElementById("all-ticket").innerHTML += "            <div id='" + index + "' class=\"box-item\">\n" +
                    "                <label class=\"col-sm-4 col-form-label\" for=\"ticket" + index + "\">" + "Ticket Category " + index + "</label>\n" +
                    "                <input type=\"number\" class=\"form-control\" id=\"ticket" + index + "\" name=\"ticket" + index + "\" placeholder=\" Enter Price\">\n" +
                    "            </div>";
            }

            Element.prototype.remove = function () {
                this.parentElement.removeChild(this);
            }
            NodeList.prototype.remove = HTMLCollection.prototype.remove = function () {
                for (var i = 0; i < this.length; i--) {
                    if (this[i] && this[i].parentElement) {
                        this[i].parentElement.removeChild(this[i]);
                    }
                }
            }

            function deleteLast() {

                document.getElementById(index).remove();
                index--;
            }

            function deleteAll() {
                document.getElementById("all-ticket").innerHTML = "<div>Enter ticket prices for categories:</div>\n";
                index = 0;
            }

        </script>

        <script>

            function h() {
               if(document.getElementById("btnradio2").checked){
                    document.getElementById("ticket-box").style.visibility = 'hidden';
                    console.log("jhgjh");
                }else

                   document.getElementById("ticket-box").style.visibility = 'visible';

            }

        </script>
        <div class="btn-group box-item" role="group" aria-label="Basic radio toggle button group">

                <input  onclick="h()" type="radio" class="btn-check" name="btnradio" id="btnradio1" value="paid" autocomplete="off" checked>
                <label style="margin: 20px;" class="btn btn-outline-light" for="btnradio1">Paid Event</label>

                <input  onclick="h()" type="radio" class="btn-check" name="btnradio" id="btnradio2" value="free" autocomplete="off">
                <label  style="margin: 20px;" class="btn btn-outline-light" for="btnradio2">Free Event</label>

        </div>

        <div id="ticket-box">
            <div class="box-item">
                <label for="max_ticket" class="col-sm-4 col-form-label">Maximum tickets bought by one person: </label>
                <input type="number" class="form-control" id="max_ticket" name="max_ticket" placeholder="Max">
            </div>
            <div class="box-item">
                <label class="col-sm-4 col-form-label">Add Ticket Category</label>
                <button class="btn btn-light" onclick="add()" style="margin-left: 10px;" type="button" >Add Category</button>
                <button class="btn cancel" onclick="deleteLast()" style="margin-left: 10px;" type="button">Delete Last</button>
                <button class="btn cancel" onclick="deleteAll()" style="margin-left: 10px;" type="button">Delete All</button>
            </div>
            <div class="box-v" id="all-ticket">
                <div>Enter ticket prices for categories:</div>
            </div>
        </div>



    </div>
</div>
<div class="evt-btn-container">
    <button type="submit" class="btn pink">Create!</button>
</div>
</form>


<button style="background-color: transparent; border-width: 0;" onclick="window.location.href='./verifiedOrganizer_home.php';">
    <img class="image-back" src="icons/icons8-back-arrow-32.png" alt="back"/>
    <span>Go back to the home page</span>
</button>

</body>
</html>

<?php 

if(  $_POST['btnradio'] == "free" ){
    if( isset($_POST['title']) && isset($_POST['description']) && isset($_POST['location']) && isset($_POST['date']) && isset($_POST['category']) && isset($_POST['quota'])) {
        if( $statement = $connection->prepare( "INSERT INTO event (`event_id`, `user_id`, `event_location`, `event_date`, `event_category`, `event_title`, `event_description`, `event_quota`, `age_restriction`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?)") ){
            $statement->bind_param( "isssssii", $uid, $_POST['location'], $_POST['date'], $_POST['category'], $_POST['title'], $_POST['description'], $_POST['quota'], $_POST['age_restriction'] );
            if ($statement->execute()) {
                echo "<script type='text/javascript'>alert('Event is added!');</script>";
            } else {
                echo "<script type='text/javascript'>alert('Event creation is failed!!');</script>";
            }
        }
    }
} else if(  $_POST['btnradio'] == "paid" ){

    if( isset($_POST['title']) && isset($_POST['description']) && isset($_POST['location']) && isset($_POST['date']) && isset($_POST['category']) && isset($_POST['quota'])) {
        if( $statement = $connection->prepare( "INSERT INTO event (`event_id`, `user_id`, `event_location`, `event_date`, `event_category`, `event_title`, `event_description`, `event_quota`, `age_restriction`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?)") ){
            $statement->bind_param( "isssssii", $uid, $_POST['location'], $_POST['date'], $_POST['category'], $_POST['title'], $_POST['description'], $_POST['quota'], $_POST['age_restriction'] );
            if ($statement->execute()) {

                $sql = "SELECT event_id FROM event WHERE user_id = '$uid' ORDER BY event_id DESC LIMIT 1";
                $eventID = (($connection->query($sql))->fetch_assoc())['event_id'];
                $connection->query("INSERT INTO paid_event VALUES ('$eventID', '".(int)$_POST['max_ticket']."', '$uid')");

                $i = 1;
                while (isset($_POST['ticket' . $i . ''])) {
                    $connection->query("INSERT INTO price VALUES ('$eventID', '".(int)$_POST['ticket' . $i . '']."')");
                    $i++;
                }

                echo "<script type='text/javascript'>alert('Event is added!');</script>";
            } else {
                echo "<script type='text/javascript'>alert('Event creation is failed!!');</script>";
            }
        }
    }
    
}

?>