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

    include ('../nav.php');
    ?>

    <section>


      <h2>New Roster</h2>


      <form  action="newRoster.php" method="post">

        <label for="day">Date:

        <input type="date" name="day">

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
              echo "<option value=" .  $row['id'] . ">" . $row['Fname'] . ' ' . $row['Lname'] . "</option>";

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
              echo "<option value=" .  $row['id'] . ">" . $row['Fname'] . ' ' . $row['Lname'] . "</option>";

            }
            ?>
          </select>

        </label>

        <label for="care2">Caregiver 2:

          <select name="care2">

            <?php
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

            $result = mysqli_query($db_link, $sql);

            while ($row = $result->fetch_assoc()) {
              echo "<option value=" .  $row['id']  .  ">" . $row['Fname'] . ' ' . $row['Lname'] . "</option>";

            }
            ?>

          </select>

        </label>

        <label for="care4">Caregiver 4:

          <select name="care4">

            <?php

            $result = mysqli_query($db_link, $sql);

            while ($row = $result->fetch_assoc()) {
              echo "<option value=" .  $row['id'] . ">" . $row['Fname'] . ' ' . $row['Lname'] . "</option>";

            }
            ?>

          </select>

        </label>

        <input type="submit" name="newRoster" value="Submit">

      </form>

      <?php

      if(isset($_POST['newRoster'])) {

        $day = $_POST['day'];
        $supervisor = $_POST['supervisors'];
        $doctor = $_POST['doctors'];
        $caregiver1 = $_POST['care1'];
        $caregiver2 = $_POST['care2'];
        $caregiver3 = $_POST['care3'];
        $caregiver4 = $_POST['care4'];

        if ($caregiver4 !== $caregiver3 or $caregiver2 or $caregiver1 and $caregiver3 == $caregiver2 or $caregiver1 and $caregiver2 == $caregiver1  ) {

          $sql2 = "INSERT INTO rosters (day, supervisor, doctor, caretaker_1, caretaker_2, caretaker_3, caretaker_4)
                  VALUES ('$day', '$supervisor', '$doctor', '$caregiver1', '$caregiver2', '$caregiver3', '$caregiver4')";

          if (mysqli_query($db_link, $sql2)) echo "<p class='success'>Roster added successfully!</p>";

          else echo "<p class='error'>Could not add roster check values!</p> " . mysqli_error($db_link);

        }

        else echo "<p class='error'>No duplicate values with caregiver!</p>";

      }

      mysqli_close($db_link);

       ?>

    </section>

  </body>

</html>
