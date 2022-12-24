<?php 
session_start();
require('connection.php');

$sql = "SELECT N.city, CONCAT(N.first_name, ' ', N.last_name, ' ( ' , MAX(O.organizer_popularity), ' ) ' ) as maxPerson, CONCAT(N.first_name, ' ' ,N.last_name, ' ( ' , MIN(O.organizer_popularity), ' ) '  ) as minPerson
        FROM organizer O NATURAL JOIN non_admin N
        WHERE 5 <= (SELECT COUNT(*)
                    FROM event E
                    WHERE O.user_id = E.user_id AND 2 <= (SELECT COUNT( DISTINCT Ev.event_location)
                                                        FROM event Ev NATURAL JOIN organizer Org
                                                        WHERE Org.user_id = Ev.user_id AND E.user_id = Org.user_id
                                                        GROUP BY Org.user_id)  
                    )
        GROUP BY N.city ";

$query = $connection->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Results</title>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>




    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style/admin-style.css">



    <!-- html2pdf CDN link -->
    <script
            src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
            integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
    ></script>
    <link rel="stylesheet" href="style/admin-style.css">


</head>
<body>


<script>


    function generatePDF() {
        // Choose the element that your content will be rendered to.
        const element = document.getElementById('invoice');
        // Choose the element and save the PDF for your user.
        html2pdf().from(element).save();
    }


</script>




<div class="report" id="invoice" style="font-size: 15px">
    <div class="header">Report Results</div>

    <div class="explain">The most popular and unpopular organizers which created at least 5 events in at least two different cities for all cities</div>
    <div class="box-report">
        <table class="p-container table table-striped">
            <thead>
            <tr>
                <th scope="col">City</th>
                <th scope="col">The Most Popular Organizer (Popularity)</th>
                <th scope="col">The Least Popular Organizer (Popularity)</th>
            </tr>
            </thead>
            <tbody>
            <?php while( $result = $query->fetch_assoc() ){ ?>
            <tr>
                <th scope="row"><?php echo $result['city']; ?></th>
                <td><?php echo $result['maxPerson']; ?></td>
                <td><?php echo $result['minPerson']; ?></td>

            </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>

</div>

<div class="go-back">
    <button class="btn org" id="download-button" onclick="generatePDF()">Download as PDF</button>

</div>

<div class="go-back">
    <button style="background-color: transparent; border-width: 0;" onclick="window.location.href='./admin_reports.php';">
        <img class="image-back" src="icons/icons8-back-arrow-32.png" alt="back"/>
        <span>Go back to the list</span>
    </button>
</div>


</body>
</html>
