<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>

    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="../../static/style.css">
    <script defer src="../../static/register.js"></script>
  </head>
  <body>

    <?php include('nav.php'); ?>

    <section>

      <h2>Register</h2>

      <form class="register" action="register.php" method="post">

        <label>Role
          <select name="role">

            <?php
            $link = mysqli_connect("localhost", "root", "", "retire");

            if ($link == false) {
              die("ERROR: Could not connect. " . mysqli_connect_error());
            }

            $result = mysqli_query($link, "SELECT DISTINCT access_level, role_name FROM roles");
            while ($row = $result->fetch_assoc()) {
              echo "<option value=" . $row['access_level'] . ">" . $row['role_name'] . "</option>";
            }

            mysqli_close($link);
            ?>
          </select>
        </label>

        <label>First Name
          <input type="text" name="f_name">
        </label>

        <label>Last Name
          <input type="text" name="l_name">
        </label>

        <label>Email
          <input type="text" name="email">
        </label>

        <label>Phone Number
          <input type="text" name="phone">
        </label>

        <label>Password
          <input type="text" name="password">
        </label>

        <label>Date of Birth
          <input type="date" name="birth_date">
        </label>

        <section class="patient">

          <label>Family Code
            <input type="text" name="code">
          </label>

          <label>Emergency Contact
            <input type="text" name="contact">
          </label>

          <label>Relation to Contact
            <input type="text" name="relation">
          </label>
        </section>

        <input type="submit" name="register" value="Submit Registration">

      </form>

      <p>Already registered? <a href="http://localhost/Retire-Inspired/views/auth/login.php">Log In here</a></p>

    </section>
    <?php

    if (isset($_POST['register'])) {
      $role = $_POST['role'];
      $f_name = $_POST['f_name'];
      $l_name = $_POST['l_name'];
      $phone = $_POST['phone'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $bday = $_POST['birth_date'];

      $code = $_POST['code'];
      $contact = $_POST['contact'];
      $relation = $_POST['relation'];

      if (empty($role) || empty($f_name) || empty($l_name) || empty($phone) || empty($email) || empty($password) || empty($bday) || ($role == 5 && (empty($code) || empty($contact) || empty($relation)))){
        echo "<p class='error'>Please fill in all fields.</p>";
      }
      else {

        $link = mysqli_connect("localhost", "root", "", "retire");

        if ($link == false) {
          die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        $sql = "INSERT INTO users (Fname, Lname, Role_id, email, phone, Birth_date, password, approved)
        VALUES ('$f_name', '$l_name', '$role', '$email', '$phone', '$bday', '$password', False)";

        if (mysqli_query($link, $sql)) {
          echo "Registration Submitted Successfully";
          if ($role != 5){
            header("Location:login.php");
          }
        } else {
          echo "ERROR: Registration failed" . mysqli_error($link);
        }

        if ($role == 5) {

          $sql = "SELECT id FROM users WHERE email = '$email'";

          $result = mysqli_query($link, $sql);
          $row = $result->fetch_assoc();
          $id = $row['id'];

          $sql = "INSERT INTO patients_info (user_id, family_code, emergency_contact, Relation_Contact, admission_date, patient_group, balance_due)
          VALUES ('$id', '$code', '$contact', '$relation', CURRENT_DATE(), FLOOR(1 + (RAND() * 3)), 0)";

          if (mysqli_query($link, $sql)) {
            echo "Patient Information Submitted Successfully";
            header("Location:login.php");
          } else {
            echo "ERROR: Registration failed" . mysqli_error($link);
          }

        }

        mysqli_close($link);
      }

    }
    ?>
  </body>
</html>
