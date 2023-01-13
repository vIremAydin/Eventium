<?php 
session_start();
require('connection.php');

$nextMonth = date('Y-m-d', strtotime('+1 month'));
$sql = "SELECT E.event_title, E.event_date FROM event E WHERE E.event_category = '".$_POST['category']."' AND E.event_location = '".$_POST['location']."' AND E.event_date > '".date('Y-m-d', strtotime('+1 month'))."' AND E.event_date < '".date('Y-m-d', strtotime('+2 month'))."'";
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
    <div class="header">Report Results for <?php echo $_POST['category'] ?> in <?php echo $_POST['location'] ?></div>
        <div class="explain">
            List all the events in the <?php echo $_POST['category'] ?> category which will take place in the next month in <?php echo $_POST['location'] ?>
        </div>
    <div class="box-report">
        <?php while( $result = $query->fetch_assoc() ){?>
        <div class="block-report">
            <div>Event Name : <?php echo $result['event_title'] ?></div>
            <div>Event Date : <?php echo $result['event_date'] ?></div>
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
