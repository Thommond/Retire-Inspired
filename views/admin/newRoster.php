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
    check_session(2);
    ?>

    <section>

      <h1>New Roster</h1>


      <form  action="newRoster.php" method="post">

        <label for="the_date">Date:

        <input type="date" name="the_date">

        </label>

        <label for="supervisors">Supervisor:

        <select name="supervisors">

          <?php
          $db_link = mysqli_connect("localhost", "root", "", "retire");

          if ($db_link == false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
          }

          $sql = "SELECT Fname, Lname, id FROM users
                  WHERE Role_id LIKE 2 ";

          $result = mysqli_query($db_link, $sql);

          while ($row = $result->fetch_assoc()) {
            echo "<option value=" .  $row['id'] .  ">" . $row['Fname'] . ' ' . $row['Lname'] . "</option>";

          }
          ?>

        </select>

        </label>

        <label for="doctors">Doctor:

          <select  name="doctors">

            <?php

            $sql = "SELECT Fname, Lname, id FROM users
                    WHERE Role_id LIKE 3";

            $result = mysqli_query($db_link, $sql);

            while ($row = $result->fetch_assoc()) {
              echo "<option value=" .  $row['id'] .  ">" . $row['Fname'] . ' ' . $row['Lname'] . "</option>";

            }
            ?>

          </select>

        </label>

        <label for="care1">Caregiver 1:

          <select  name="care1">
            <?php
            $sql = "SELECT Fname, Lname, id FROM users
                    WHERE Role_id LIKE 4";

            $result = mysqli_query($db_link, $sql);

            while ($row = $result->fetch_assoc()) {
              echo "<option value=" .  $row['id'] .  ">" . $row['Fname'] . ' ' . $row['Lname'] . "</option>";

            }
            ?>
          </select>

        </label>

        <label for="care2">Caregiver 2:

          <select name="care2">

            <?php
            $sql = "SELECT Fname, Lname, id FROM users
                    WHERE Role_id LIKE 4";

            $result = mysqli_query($db_link, $sql);

            while ($row = $result->fetch_assoc()) {
              echo "<option value=" .  $row['id'] .  ">" . $row['Fname'] . ' ' . $row['Lname'] . "</option>";

            }
            ?>

          </select>

        </label>

        <label for="care3">Caregiver 3:

          <select name="care3">

            <?php
            $sql = "SELECT Fname, Lname, id FROM users
                    WHERE Role_id LIKE 4";

            $result = mysqli_query($db_link, $sql);

            while ($row = $result->fetch_assoc()) {
              echo "<option value=" .  $row['id'] .  ">" . $row['Fname'] . ' ' . $row['Lname'] . "</option>";

            }
            ?>

          </select>

        </label>

        <label for="care4">Caregiver 4:

          <select name="care4">

            <?php

            $sql = "SELECT Fname, Lname, id FROM users
                    WHERE Role_id LIKE 4";

            $result = mysqli_query($db_link, $sql);

            while ($row = $result->fetch_assoc()) {
              echo "<option value=" .  $row['id'] .  ">" . $row['Fname'] . ' ' . $row['Lname'] . "</option>";

            }
            ?>

          </select>

        </label>

        <input type="submit" name="newRoster" value="Submit">

      </form>

    </section>



  </body>

</html>
