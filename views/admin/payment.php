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

        if (isset($_POST['ok'])) {
          

        }

        if (isset($_POST['cancel'])) {


        }

        if (isset($_POST['update'])) {


        }

       ?>

    </section>

  </body>

</html>
