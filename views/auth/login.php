<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

    <meta charset="utf-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="../../static/style.css">

  </head>

  <body>

    <section>

      <h1>Login</h1>

      <form class="" action="login.php" method="post">

        <label>Email
          <input type="text" name="email" >
        </label>

        <label>Password
          <input type="text" name="pass" >
        </label>

        <input type="submit" name="Login" value="Login">

        <input type="submit" name="cancel" value="Cancel">

      </form>

      <p>Need to create an account? <a href="http://localhost/Retire-Inspired/views/auth/register.php">Register here</a></p>

    </section>


    <?php

    if (isset($_POST['Login'])) {

      $email = $_POST['email'];
      $password = $_POST['pass'];

      // TODO: Change password of database for security
      $db_link = mysqli_connect("localhost", "root", '', "retire");

      if ($db_link == false) {

        die("ERROR: Could not login must be incorrect email or passowrd" . mysqli_connect_error());
      }

      $sql = "SELECT Role_id, Fname, Lname, id, approved
              FROM users
              WHERE email = '$email' AND password = '$password'";


      if (mysqli_query($db_link, $sql)) {

          $result = mysqli_fetch_row(mysqli_query($db_link, $sql));

          session_id();
          session_start();

          $_SESSION['email'] = $email;
          $_SESSION['pass'] = $password;
          $_SESSION['Role_id'] = $result[0];
          $_SESSION['first_name'] = $result[1];
          $_SESSION['last_name'] = $result[2];
          $_SESSION['id'] = $result[3];
          $_SESSION['approved'] = $result[4];

          // TODO: Make so checks database to see if email or password exists then if one does
          // but the other does not throw email password error.

          if ($_SESSION['approved'] == 0) {
            header("Location: http://localhost/Retire-Inspired/views/errors/notYetApproved.php");
          }

          else {

              switch ($result[0]) {
                case '1':
                  header('Location: http://localhost/Retire-Inspired/views/admin/adminHome.php ');
                  break;

                case '2':
                  header('Location: http://localhost/Retire-Inspired/views/home/supervisorHome.php');
                  break;

                case '3':
                  header('Location: http://localhost/Retire-Inspired/views/home/doctorHome.php ');
                  break;

                case '4':
                  header('Location: http://localhost/Retire-Inspired/views/home/caregiverHome.php ');
                  break;

                case '5':
                  header('Location: http://localhost/Retire-Inspired/views/home/patientHome.php ');
                  break;

                case '6':
                  header('Location: http://localhost/Retire-Inspired/views/home/familyMemberHome.php ');
                  break;
              }

            }

          }

      else echo "Wrong Email or Password";

      mysqli_close($db_link);

    }

    if(isset($_POST['cancel'])) {

      header('Location: http://localhost/Retire-Inspired/views/landing.php');
    }

    ?>

  </body>
</html>
