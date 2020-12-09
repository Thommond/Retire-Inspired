<!DOCTYPE html>
<html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <title>New Roster</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>

  <body>

    <?php
    include ('../../common-functions.php');
    check_session(1);
    ?>

    <section>

      <h2>Payment</h2>

      <a href="adminHome.php">Back</a>

      <h4>Update button, updates all patients from previous update to todays date.</h4>

      <form  action="payment.php" method="post">

        <label>Patient ID:
          <input type="text" name="patient_id">
        </label>

        <label>Total Due:
          <input type="text" name="total">
        </label>

        <label>New Payment:
          <input type="text" name="new_payment">
        </label>

        <input type="submit" name="ok" value="Ok">

        <input type="submit" id='cancel' name="cancel" value="Cancel">

        <!--Semantic seperation-->
        <hr width='250px'>

        <input type="submit" name="update" value="Update">

      </form>

      <?php

        $day = date('Y-m-d');

        $db_link = mysqli_connect("localhost", "root", "", "retire");

        if ($db_link == false) {
          die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        if (isset($_POST['ok'])) {


        }

        if (isset($_POST['cancel'])) {


        }

        if (isset($_POST['update'])) {


          // Get all patients
          $sql = "SELECT u.id, FROM users as u
                  WHERE Role_id = 5"

          $patient_result = mysqli_query($db_link, $sql);

          // For each patient get
          while ($row = $patient_result->fetch_assoc()) {

            $patent_id = $row['id'];

            $update_sql = "SELECT recent_update FROM payments
                            WHERE user_id = '$patient_id'";

            $update_result = mysqli_fetch_row(mysqli_query($db_link, $payment_sql));

            if ($update_result) {
              $recent_update = $update_result[0];
            }

            else {

              // If they don't have a previous update make one their admission.
              $admission_sql = "SELECT admission_date FROM patients_info
                              WHERE user_id = '$patient_id'";

              $admission_result = mysqli_fetch_row(mysqli_query($db_link, $admission_sql));

              $recent_update = $admission_result[0];

            }

            // number of appointments since last update. ($50)
            $appt_sql = "SELECT day FROM appointments
                         WHERE "

            // number of prescriptions since last update. ($5)
            $med_sql = "";

            // Days since last update. ($10)
            $payment_sql = "";


          }


        }

        mysqli_close($db_link);

       ?>

    </section>

  </body>

</html>
