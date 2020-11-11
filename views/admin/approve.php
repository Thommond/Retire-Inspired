<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

    <meta charset="utf-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="../../static/style.css">

  </head>

  <?php
  include ('../../common-functions.php');
  check_session(2);
  ?>

  <body>

    <section>

      <?php
      if ($_SESSION['Role_id'] == 1) echo '<a href=' . "adminHome.php" . '>' . 'Back' . '</a>';
      if ($_SESSION['Role_id'] == 2) echo '<a href=' . "supervisorHome.php" . '>' . 'Back' . '</a>';
      ?>

      <h1>Registration Approval</h1>

      <table>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Role</th>
        </tr>

      <?php
      $db_link = mysqli_connect("localhost", "root", "", "retire");

      if ($db_link == false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
      }

      $sql = "SELECT Fname, Lname, Role_id FROM users
              WHERE approved LIKE false";

      $result = mysqli_query($db_link, $sql);

      while ($row = $result->fetch_assoc()) {

        echo "<tr>";
        echo "<td>" . $row['Fname'] . '</td>';
        echo "<td>" . $row['Lname'] . '</td>';
        echo "<td>" . $row['Role_id'] . '</td>';
        echo "</tr>";
      }

      mysqli_close($db_link);
      ?>
     </table>

    </section>



  </body>
</html>
