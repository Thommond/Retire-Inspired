<!DOCTYPE html>
<html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <title>New Roster</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>

  <body>

    <section>


      <?php
      include ('../../common-functions.php');
      check_session(6);
      ?>

      <table>
        <tr>
          <th>Date</th>
          <th>Supervisor</th>
          <th>Doctor</th>
          <th>Caregiver1</th>
          <th>Caregiver2</th>
          <th>Caregiver3</th>
          <th>Caregiver4</th>
        </tr>

        <?php
        $db_link = mysqli_connect("localhost", "root", "", "retire");

        if ($db_link == false) {
          die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        $date = date('Y-m-d');

        $sql = "SELECT * FROM rosters
                WHERE the_date = '$date'";

        if(mysqli_query($db_link, $sql)) {


          $result = mysqli_query($db_link, $sql);

          $row = $result->fetch_assoc();

          $ids = [$row['supervisor'],
                  $row['doctor'],
                  $row['caretaker_1'],
                  $row['caretaker_2'],
                  $row['caretaker_3'],
                  $row['caretaker_4']
                ];

          $display = [$row['the_date']];

          foreach ($ids as $id) {

            $sql = "SELECT Fname, Lname FROM users
                    WHERE id LIKE $id";

            $result = mysqli_query($db_link, $sql);
            $row = $result->fetch_assoc();
            $query = $row['Fname'] . ' ' . $row['Lname'];
            array_push($display, $query);

          }

          echo '<tr>';

          foreach($display as $row) {

            echo '<td>' . $row . '</td>';
          }

          echo '</tr>';


          }

        else echo "<p class='error'>No Roster for today yet!</p>";

        mysqli_close($db_link);

        ?>

        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td>Group 1</td>
          <td>Group 2</td>
          <td>Group 3</td>
          <td>Group 4</td>
        </tr>

      </table>

    </section>

  </body>

</html>
