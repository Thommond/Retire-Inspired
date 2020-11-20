<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Caregiver Home</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>
  <body>

    <?php
    include ('../../common-functions.php');
    check_session(4);
    ?>

    <form class="exit" action="caregiverHome.php" method="post">
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

      <p>Welcome Home Caregiver!</p>

      <a href="../admin/roster.php">Look at todays Roster</a>

    </section>

    <section class="schedule">

      <form class="manageSchedules" action="caregiverHome.php" method="post">

        <table>
          <tr>
            <th>Name</th>
            <th>Morning Medicine</th>
            <th>Afternoon Medicine</th>
            <th>Night Medicine</th>
            <th>Breakfast</th>
            <th>Lunch</th>
            <th>Dinner</th>
          </tr>
          <tr>

            <?php
            #establish some variables
            $schedule = [];
            $patient_name = '';

            #use the submitted date or default to today
            if (isset($_POST['search'])) {
              $date = $_POST['date'];
            }
            else {
              $date = date('Y-m-d');
            }

            $id = $_SESSION['id'];

            $link = mysqli_connect("localhost", "root", "", "retire");

            if ($link == false) {
              die("ERROR: Could not connect. " . mysqli_connect_error());
            }

            #Check which group the caregiver is assigned to

            #Get all of the patients in that group

            #Display the schedule for each patient

            mysqli_close($link);
            ?>
          </tr>
        </table>
      </form>
    </section>

  </body>
</html>
