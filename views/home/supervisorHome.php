<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Supervisors Home</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>
  <body>

    <?php
    include ('../../common-functions.php');
    check_session(2);
    include ('../nav.php');
    ?>

    <section class='links'>

      <p>Welcome Home Supervisor!</p>

      <a href="../admin/approve.php">Approve Registrations</a>

      <a href="../admin/newRoster.php">Create New Roster</a>

      <a href="../admin/roster.php">Look at todays Roster</a>

      <a href="../admin/docappt.php">Doctor Appts</a>

      <a href="../patients.php">Look at List of Patients</a>

      <a href="../admin/employee.php">Look at list of Employees</a>

      <a href="../admin/adminReport.php">Missed Activity</a>

    </section>




  </body>
</html>
