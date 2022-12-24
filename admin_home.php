<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style/admin-style.css">
</head>
<body>
<div class="buffer"></div>
<h3>Admin Home</h3>
<div class="box">

    <div class="block">
        <div class="label">Approve Verifications</div>
        <button id="org-btn" type="button" class="btn org" onclick="window.location.href='./admin_approve_verifications.php';">Go</button>
    </div>
    <div class="block">
        <div class="label">Review Users</div>
        <button id="org-btn1" type="button" class="btn org" onclick="window.location.href='./admin_review_users.php';">Go</button>
    </div>

    <div class="block">
        <div class="label">Review Events</div>
        <button id="org-btn2" type="button" class="btn org" onclick="window.location.href='./admin_review_events.php';">Go</button>
    </div>
    <div class="block">
        <div class="label">Create Report</div>
        <button id="org-btn3" type="button" class="btn org" onclick="window.location.href='./admin_reports.php';">Go</button>
    </div>

    <div style="margin: auto">
              <button style="background-color: transparent; border-width: 0;" onclick="window.location.href='./logout.php';">
                  <div class="label">Logout   <img class="image-back" src="icons/logout.png" alt="back"/></div>
              </button>
    </div>
</div>
</body>
</html>
