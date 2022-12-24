<?php
session_start();
require('connection.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/participant.css">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style/wallet-style.css">
    <link rel="stylesheet" href="style/admin-style.css">



</head>
<body>
<div class="buffer"></div>
<h3>Admin Create Reports</h3>
<div class="box-report">
    <div class="block-report">
        <div class="in-block">
            <div class="label">Popular Organizer</div>
            <button id="org-btn" data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn org">
                Report Create
            </button>
        </div>
        <div class="in-block">
            <div class="label">Maximum Participants</div>
            <button id="org-btn4" data-bs-toggle="modal" data-bs-target="#exampleModal2" type="button" class="btn org">
                Report Create
            </button>
        </div>


    </div>
    <div class="block-report">
        <div class="in-block">
            <div class="label">Participants of a Category</div>
            <button id="org-btn2" data-bs-toggle="modal" data-bs-target="#exampleModal3" type="button" class="btn org">
                Report Create
            </button>
        </div>

        <div class="in-block">
            <div class="label">Events in Next Month</div>
            <button id="org-btn3" data-bs-toggle="modal" data-bs-target="#exampleModal4" type="button" class="btn org">
                Report Create
            </button>
        </div>


    </div>
    <div class="block-report">
        <div class="in-block">
            <div class="label">Average Number</div>
            <button id="org-btn5" type="button" class="btn org" data-bs-toggle="tooltip" data-bs-placement="top" onclick="window.location.href='./report5.php';" data-bs-html="true" title="Find the average number of participants of events for each category" >Report Create</button>
        </div>
        <div class="in-block">
            <div class="label" style="font-size: 17px">Popular and Unpopular Organizer</div>
                <button id="org-btn6" type="button" class="btn org" data-bs-toggle="tooltip" data-bs-placement="top" onclick="window.location.href='./report6.php';" data-bs-html="true" title="The most popular and unpopular organizers which created at least 5 events in at least two different cities for all cities">
                    Report Create
                </button>
        </div>


    </div>

</div>
<!-- modal 1-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="post" action="./report1.php">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Popular Organizers </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>Organizers in selected location popularity higher than selected number</div>
                <div class="card-container">
                    <div class="card">
                        <label for="mail" class="col-sm-4 col-form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" placeholder="Location">
                    </div>
                    <div class="card">
                        <label for="pop" class="col-sm-4 col-form-label">Popularity</label>
                        <input type="number" class="form-control" id="pop" name="pop" placeholder="popularity number">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create Report</button>
            </div>
        </form>
    </div>
</div>


<!-- modal 2-->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="post" action="./report2.php">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel2">Maximum Participants</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>Retrieve the free event which has the maximum number of participants for each category located in
                    selected location
                </div>
                <div class="card-container">
                    <div class="card">
                        <label for="location" class="col-sm-4 col-form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" placeholder="Location">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create Report</button>
            </div>
        </form>
    </div>
</div>


<!-- modal 3-->
<div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="post" action="./report3.php">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel3">Participants of A Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>Retrieve the participants who attended the selected category events last year</div>
                <div class="card-container">
                    <div class="card">
                        <div>
                            <select class="form-select" id="floatingSelect" name="category" aria-label="Floating label select example">
                                <option selected>Choose a Category</option>
                                <option value="Music">Music</option>
                                <option value="Gathering">Gathering</option>
                                <option value="Sports">Sports</option>
                                <option value="Business">Business</option>
                                <option value="Food&Drink">Food&Drink</option>
                                <option value="Visual Arts">Visual Arts</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create Report</button>
            </div>
        </form>
    </div>
</div>


<!-- modal 4-->
<div class="modal fade" id="exampleModal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="post" action="./report4.php">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel4">Events in Next Month</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>List all the events in the selected category which will take place in the next month in the
                    selected location
                </div>
                <div class="card-container">
                    <div class="card">
                        <div style="display: flex; justify-content: space-around;">
                            <label style="margin-right: 30px;">Category</label>
                            <select class="form-select" id="floatingSelect2" name="category" aria-label="Floating label select example">
                                <option selected>Choose a Category</option>
                                <option value="Music">Music</option>
                                <option value="Gathering">Gathering</option>
                                <option value="Sports">Sports</option>
                                <option value="Business">Business</option>
                                <option value="Food&Drink">Food&Drink</option>
                                <option value="Visual Arts">Visual Arts</option>
                            </select>
                        </div>
                    </div>
                    <div class="card">
                        <label for="location" class="col-sm-4 col-form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" placeholder="Location">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create Report</button>
            </div>
        </form>
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
