<?php 
session_start();
require('connection.php');

$sql = "SELECT UNIQUE O.user_id, CONCAT( N.first_name, ' ', N.last_name) as full_name, O.organizer_popularity FROM organizer O, event E, non_admin N
            WHERE O.organizer_popularity > " . $_POST['pop'] . " AND E.event_location = '" . $_POST['location'] . "' AND O.user_id = E.user_id AND N.user_id = O.user_id";
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




<div class="report" id="invoice">
    <div class="header">Report Results for Ankara</div>
    <div class="box-report">
        <?php while( $result = $query->fetch_assoc() ){ ?>
        <div class="block-report">
            <div>Organizer Name: <?php echo $result['full_name'] ?></div>
            <div>Popularity: <?php echo $result['organizer_popularity'] ?></div>
        </div>
        <?php } ?>
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
