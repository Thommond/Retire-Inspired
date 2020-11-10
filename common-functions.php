<?php

function check_session($role, $role2=False, $private=False) {

  session_start();

  // checking roles and if session exists also different type of access levels 
  if ($_SESSION['id'] == null) {
      header('Location: http://localhost/Retire-Inspired/views/errors/forbidden.php');
  }

  if ($private) {

    if ($role != $_SESSION['Role_id']) {
        header('Location: http://localhost/Retire-Inspired/views/errors/forbidden.php');
    }

  }

  if ($role2) {

    if ($_SESSION['Role_id'] != $role or $role2) {
      header('Location: http://localhost/Retire-Inspired/views/errors/forbidden.php');
    }

  }

  if (!$role2 and !$private) {

      if ($_SESSION['Role_id'] > $role) {
            header('Location: http://localhost/Retire-Inspired/views/errors/forbidden.php');
      }
  }

  $the_id = $_SESSION['id'];

  // Connecting to database
  $db_link = mysqli_connect("localhost", "root", '', "retire");

  if ($db_link == false) {

    die("ERROR: Can not connect to database" . mysqli_connect_error());
  }

  $sql = "SELECT id, email
          FROM users
          WHERE id '$the_id'";

  if (mysqli_query($db_link, $sql)) {

      $result = mysqli_fetch_row(mysqli_query($db_link, $sql));

      // Check if session data matches database
      if ($result[0] != $_SESSION['id'] or $result[1] != $_SESSION['email'])  {
        header('Location: http://localhost/Retire-Inspired/views/errors/forbidden.php');
      }

      echo 'bob is cool';

      mysqli_close($db_link);

    }
}


?>
