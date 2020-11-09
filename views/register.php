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
          <option value="patient">Patient</option>
          <option value="doctor">Doctor</option>
          <option value="caretaker">Caretaker</option>
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
        <input type="text" name="birth_date">
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
    }
    ?>
  </body>
</html>
