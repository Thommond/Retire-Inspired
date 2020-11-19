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
      <p>If you would like to filter the results fill in a field only on field at a time.</p>

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

        <label>Comment:
          <input type="text" name="Comment">
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

        <input type="submit" name="Submit" value="Submit">

      </form>

      <?php

      if (isset($_POST['Submit'])) {
        $date = $_POST['date'];
        $Fname = $_POST['Fname'];
        $Lname = $_POST['Lname'];
        $Comment = $_POST['Comment'];
        $Mmed = $_POST['mmed'];
        $Amed = $_POST['amed'];
        $Nmed = $_POST['nmed'];
        $id = $_SESSION['id'];

        if (empty($date)) {
          $date = '%';
        }
        if (empty($Fname)) {
          $Fname = '%';
        }
        if (empty($Lname)) {
          $Lname = '%';
        }
        if (empty($Comment)) {
          $Comment = '%';
        }
        if (empty($Mmed)) {
          $Mmed = '%';
        }
        if (empty($Amed)) {
          $Amed = '%';
        }
        if (empty($Nmed)) {
          $Nmed = '%';
        }

        $db_link = mysqli_connect("localhost", "root", "", "retire");

        if ($db_link == false) {
          die("ERROR: Could not connect" . mysqli_connect_error());
        }

        $sql = "SELECT  a.day, p.morning_med, p.afternoon_med, p.night_med,
                p.comment, a.patient_id, u.Fname, u.Lname, u.id
                FROM appointments as a JOIN prescriptions as p on (a.patient_id = p.patient_id)
                JOIN users as u ON (a.patient_id=u.id)
                WHERE u.id LIKE '$id' AND day LIKE '$date' AND morning_med LIKE '$Mmed'
                AND afternoon_med LIKE '$Amed' AND night_med LIKE '$Nmed' AND Fname LIKE '$Fname' AND Lname LIKE '$Lname' ";

        $result = mysqli_query($db_link, $sql);

        print_r($result);

      }

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
