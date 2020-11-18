<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Doctors Home</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>
  <body>

    <?php
    include ('../../common-functions.php');
    check_session(3);
    ?>

    <form class="exit" action="doctorHome.php" method="post">
        <input type="submit" name="logout" value="Logout">
    </form>

    <?php

    if(isset($_POST['logout'])) {
      session_start();
      session_destroy();
      header('Location: http://localhost/Retire-Inspired/views/auth/login.php');
      }

     ?>
    <section class='links'>

      <p>Welcome home <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']?>!</p>

      <a href="../admin/roster.php">Look at todays Roster</a>

    </section>


    <section>
      <p>If you would like to filter the results fill in one or more fields.</p>

      <form  action="doctorHome.php" method="post">

        <label>Date:
          <input type="text" name="date">
        </label>

        <label>First Name:
          <input type="text" name="Fname">
        </label>

        <label>Last Name:
          <input type="text" name="Lname">
        </label>

        <label>Morning Medication:
          <input type="text" name="mmed">
        </label>

        <label>Afternoon Medication
          <input type="text" name="amed">
        </label>

        <label>Night Medication
          <input type="text" name="nmed">
        </label>

      </form>
      
      <?php

      // Get all previous appts from the schedules table
        // display name, date, morning_med, afternoon_med, and night_med
        // Have option from each attribute that user can search data to find
          // specific row.

      // label which has appointments
        // input which date can be entered

      // submit button


      // Once submited
        // then the new appointments will show up until submited date
       ?>




    </section>



  </body>
</html>
