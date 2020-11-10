<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>

    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="../static/style.css">
  </head>
  <body>

    <h1>Register</h1>

    <form class="register" action="register.php" method="post">

      <label>Role
        <select name="role">

          <?php
          $link = mysqli_connect("localhost", "root", "", "retire");

          if ($link == false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
          }

          $result = mysqli_query($link, "SELECT * FROM roles");
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

      <input type="submit" name="register" value="Submit Registration">

    </form>

    <p>Already registered? <a href="http://localhost:8080/Retire-Inspired/views/login.php">Log In here</a>.</p>

    <?php

    if (isset($_POST['register'])) {
      $role = $_POST['role'];
      $f_name = $_POST['f_name'];
      $l_name = $_POST['l_name'];
      $phone = $_POST['phone'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $bday = $_POST['birth_date'];

      if (empty($role) || empty($f_name) || empty($l_name) || empty($phone) || empty($email) || empty($password) || empty($bday)){
        echo "<p class='error'>Please fill in all fields.</p>";
      }
      else {

        $link = mysqli_connect("localhost", "root", "", "retire");

        if ($link == false) {
          die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        $sql = "INSERT INTO users (Fname, Lname, Role_id, email, phone, Birth_date, password)
        VALUES ('$f_name', '$l_name', '$role', '$email', '$phone', '$bday', '$password')";

        if (mysqli_query($link, $sql)) {
          echo "Registration Submitted Successfully";
          header("Location:login.php");
        } else {
          echo "ERROR: Registration failed" . mysqli_error($link);
        }

        mysqli_close($link);
      }

    }
    ?>
  </body>
</html>
