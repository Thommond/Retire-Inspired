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

    include ('../nav.php');
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

          $patient_id = $_POST['patient_id'];
          $total_due = $_POST['total'];
          $new_payment = $_POST['new_payment'];

          // Checking if they have info
          $check_patient_sql = "SELECT user_id FROM payments
                            WHERE user_id = '$patient_id'";

          $checkp_result_1 = mysqli_fetch_row(mysqli_query($db_link, $check_patient_sql));

          if ($checkp_result_1[0]) {

            $update_payment_sql = "UPDATE payments
                                   SET balance_due = '$total_due',
                                       recent_update = '$day'
                                   WHERE user_id = '$patient_id'";

           $update_payment_result = mysqli_query($db_link, $update_payment_sql);

          }

          else {
            $payment_sql = "INSERT INTO payments (user_id, balance_due, recent_update)
                            VALUES ($patient_id, $total_due, '$day')";

            $add_payment_result = mysqli_query($db_link, $payment_sql);
          }

          echo "<p class='success'> Updated patient payment with id, $patient_id successfully!</p>";

        }

        if (isset($_POST['update'])) {


          // Get all patients
          $sql = "SELECT id FROM users
                  WHERE Role_id = 5";

          $patient_result = mysqli_query($db_link, $sql);

          // For each patient get
          while ($row = $patient_result->fetch_assoc()) {

            $patient_id = $row['id'];

            $update_sql = "SELECT recent_update FROM payments
                           WHERE user_id = '$patient_id'";

            $update_result = mysqli_fetch_row(mysqli_query($db_link, $update_sql));

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
                         WHERE patient_id = '$patient_id'";

            $appt_result = mysqli_query($db_link, $appt_sql);

            $count_appt = 0;

            while ($row_2 = $appt_result->fetch_assoc()) {
              $count_appt += 1;
            }

            $appt_cost = $count_appt * 50;

            // number of prescriptions since last update. ($5)
            $med_cost = $count_appt * 5;


            // Days subtracted to get # of days since last update
            $start = date_create("$day");
            $end = date_create("$recent_update");
            $day_diff = date_diff($start, $end);
            $days = intval($day_diff->format('%a'));

            $day_cost = $days * 10;

            // Final balance
            $balance = $appt_cost + $med_cost + $day_cost;

            $check_patient = "SELECT user_id FROM payments
                              WHERE user_id = '$patient_id'";

            $checkp_result_2 = mysqli_fetch_row(mysqli_query($db_link, $check_patient));

            // Update if exists
            if ($checkp_result_2[0]) {

              $update_payment_sql = "UPDATE payments
                                     SET balance_due = '$balance',
                                         recent_update = '$day'
                                     WHERE user_id = '$patient_id'";

             $update_payment_result = mysqli_query($db_link, $update_payment_sql);

            }

            // Insert if not
            else {
              $payment_sql = "INSERT INTO payments (user_id, balance_due, recent_update)
                              VALUES ($patient_id, $balance, '$day')";

              $add_payment_result = mysqli_query($db_link, $payment_sql);
            }

          }

          echo "<p class='success'>Balance update successful!</p>";
        }

        mysqli_close($db_link);

       ?>

    </section>

  </body>

</html>
