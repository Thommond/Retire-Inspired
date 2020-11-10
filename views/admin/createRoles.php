<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Create Roles</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>
  <body>

    <?php
    include ('../../common-functions.php');
    check_session(1);
    ?>


    <section>

        <table>
          <tr>
              <th>Access Level</th>
              <th>Role Name</th>
          </tr>

          <?php
          $db_link = mysqli_connect("localhost", "root", "", "retire");

          if ($db_link == false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
          }

          $result = mysqli_query($db_link, "SELECT DISTINCT access_level, role_name FROM roles");

          while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['access_level'] . "</td>";
            echo "<td>" . $row['role_name'] . "</td>";
            echo "</tr>";
          }

          mysqli_close($db_link);

          ?>
          
        <table>
      </ul>
    </section>


    <section>

      <a class='back' href="adminHome.php">Back</a>

      <form  action="createRoles.php" method="post">

        <label for="role">Role Name
          <input type="text" name="role_name">
        </label>

        <label for="access_level">Access Level
          <input type="text" name="access_level">
        </label>

        <input type="submit" name="createRole" value="Submit">

      </form>

      <?php
        if(isset($_POST['createRole'])) {

          $name = $_POST['role_name'];
          $access = $_POST['access_level'];

          $db_link = mysqli_connect("localhost", "root", "", "retire");

          if ($db_link == false) {
            die("ERROR: Could not connect to database" . mysqli_connect_error());
          }

          $sql = "SELECT DISTINCT access_level, role_name
                  FROM roles
                  WHERE role_name = '$name'";

          if (mysqli_query($db_link, $sql)) {

              $result = mysqli_fetch_row(mysqli_query($db_link, $sql));

              if ($result[0]) {
              echo  "<p>Sorry that role has already been created try again!</p>";
              }

              else {

                $sql2 = "INSERT INTO roles (access_level, role_name)
                        VALUES ('$access', '$name')";

                if (mysqli_query($db_link, $sql2)) echo "<p>The $name role has been added with level $access access.</p>";
                else "ERROR: Could not add role to database, check values." . mysqli_error($db_link);


              }
          }

          else "ERROR: Role could not be accessed" . mysqli_error($db_link);

          mysqli_close($db_link);
        }
       ?>

    </section>


  </body>
</html>
