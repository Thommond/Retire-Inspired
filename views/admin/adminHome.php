<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin Home</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>
  <body>

    <?php
    include ('../../common-functions.php');
    check_session(1);

    include ('../nav.php');
    ?>


    <section class='links'>

      <h2>Welcome Home Admin!</h2>

      <a href="createRoles.php">Create Roles</a>

      <a href="approve.php">Approve Registrations</a>

      <a href="newRoster.php">Create a Roster</a>

      <a href="roster.php">Look at todays Roster</a>

      <a href="docappt.php">Doctor Appts</a>

      <a href="../patients.php">Look at List of Patients</a>

      <a href="employee.php">Look at List of Employees</a>

      <a href="adminReport.php">Missed Activity</a>

      <a href="payment.php">Patient Payment</a>

    </section>

  </body>
</html>
