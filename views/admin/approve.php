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
      if ($_SESSION['Role_id'] == 2) echo '<a href=' . "../home/supervisorHome.php" . '>' . 'Back' . '</a>';
      ?>

      <h1>Registration Approval</h1>
      <form class="" action="approve.php" method="post">
        <table>
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Role</th>
            <th>Approve?</th>
          </tr>

        <?php
        $db_link = mysqli_connect("localhost", "root", "", "retire");

        if ($db_link == false) {
          die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        $sql = "SELECT Fname, Lname, Role_id, id FROM users
                WHERE approved LIKE 1
                ORDER BY Fname ASC";

        $result = mysqli_query($db_link, $sql);

        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row['Fname'] . '</td>';
          echo "<td>" . $row['Lname'] . '</td>';
          echo "<td>" . $row['Role_id'] . '</td>';
          echo "<td>";
          echo "<select " . "name=" . $row['id'] . ">";
          echo "<option value='yes'>Yes</option>";
          echo "<option value='no'>No</option>";
          echo "</select>";
          echo "</td>";
          echo "</tr>";
        }
        ?>
        </table>

        <input type="submit" name="Reg_submit" value="Okay">
        <input type="submit" name="cancel" value="Cancel">

      </form>

      <?php

      if (isset($_POST['Reg_submit'])) {


        $sql = "SELECT id FROM users
                WHERE approved LIKE 1
                ORDER BY Fname ASC";

        $result = mysqli_query($db_link, $sql);

        while($row = $result->fetch_assoc()) {

          if($_POST[$row['id']] == 'yes') {

          }

          else if ($_POST[$row['id']] == 'no') {



          }

        }





       // Get list of inputs which are "yes"
        // loop through
          // updating to status "2" on each row (accepted)

       // Get list of inputs which are "no"
        // loop through
          // updating to status "3" on each row (deletion)

       // All labeled status "3" loop though
        // deleting each row

      }

      ?>

    </section>



  </body>
</html>
