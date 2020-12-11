<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

    <meta charset="utf-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="../../static/style.css">

  </head>

  <body>

    <?php
    include ('../../common-functions.php');
    check_session(2);

    include ('../nav.php');
    ?>


    <section>

      <h2>Registration Approval</h2>
      <p>Note: All registrations that are selected no will be Permanently deleted.</p>
      <form action="approve.php" method="post">
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
                WHERE approved LIKE 0
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
                WHERE approved LIKE 0
                ORDER BY Fname ASC";

        $result = mysqli_query($db_link, $sql);

        while($row = $result->fetch_assoc()) {

          if($_POST[$row['id']] == 'yes') {

            $id = $row['id'];

            $sql2 = "UPDATE users
                     SET approved = 1
                     WHERE id LIKE $id";

            $result = mysqli_query($db_link, $sql2);
          }

          else if ($_POST[$row['id']] == 'no') {

            $id = $row['id'];

            $sql2 = "DELETE FROM users
                     WHERE id LIKE $id";

            $result = mysqli_query($db_link, $sql2);


          }

        }

      }

      ?>

    </section>



  </body>
</html>
