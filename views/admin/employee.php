<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Employee List</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>
  <body>

    <?php
    include ('../../common-functions.php');
    check_session(2);
    ?>

    <h1>Employees</h1>

    <section class="employees">

      <form class="employees" action="employee.php" method="post">

        <select name="attribute">
          <option value="not_selected">-Select an Attribute-</option>
          <option value="id">ID</option>
          <option value="name">Name</option>
          <option value="role">Role</option>
          <option value="salary">Salary</option>
        </select>

        <input type="text" name="value">

        <input type="submit" name="search" value="Search">

      </form>

      <table class="employees">

        <tr>

          <th>ID</th>
          <th>Name</th>
          <th>Role</th>
          <th>Salary</th>
        </tr>


        <?php

        #HANDLE SEARCH FORM AND DISPLAY LIST OF EMPLOYEES

        $attribute = '';
        $value = '';

        if (isset($_POST['search'])) {

          #Save the submitted attribute and value
          if ($_POST['attribute'] = 'id') $attribute = 'u.id';

          elseif ($_POST['attribute'] = 'name') $attribute = 'Fname';

          elseif ($_POST['attribute'] = 'role') $attribute = 'role_name';

          elseif ($_POST['attribute'] = 'salary') $attribute = 'salary';

          $value = $_POST['value'];
        }

        $link = mysqli_connect("localhost", "root", "", "retire");

        if ($link == false) {
          die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        #Retrieve all of the users who are an employee (no patient or family member roles)
        $sql = "SELECT u.id, Fname, Lname, role_name, salary
                FROM  users u JOIN roles r ON Role_id = r.id
                WHERE Role_id <= 4";

        $result = mysqli_query($link, $sql);

        if ($result) {

          while ($row = $result->fetch_assoc()) {
            #Display the fetched information for each employee

            echo "<tr>";

            $id = $row['id'];
            echo "<td>$id</td>";

            $name = $row['Fname'] . ' ' . $row['Lname'];
            echo "<td>$name</td>";

            $role = $row['role_name'];
            echo "<td>$role</td>";

            $salary = $row['salary'];
            if (!$salary) $salary = 0;
            echo "<td>$salary</td>";

            echo "</tr>";
          }
        }
        else {
          echo "<p class='error'>Unable to retrieve data.</p>";
        }

        mysqli_close($link);
        ?>
      </table>
    </section>



  </body>
</html>
