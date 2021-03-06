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

    include ('../nav.php');
    ?>

    <h2>Employees</h2>


    <div class="employees">

      <?php if ($_SESSION['Role_id'] == 1): ?>

        <section class="salary">

          <form class="salary" action="employee.php" method="post">

            <h3>Update Employee's Salary</h3>

            <label>Employee ID:
              <input type="text" name="id">
            </label>

            <label>New Salary:
              <input type="number" name="salary">
            </label>

            <input type="submit" name="update_salary" value="Update">

          </form>


          <?php

          if (isset($_POST['update_salary'])) {

            #Retrieve the salary form data
            $id = $_POST['id'];
            $salary = $_POST['salary'];

            #Establish the database connection
            $link = mysqli_connect("localhost", "root", "", "retire");

            if ($link == false) {
              die("ERROR: Could not connect. " . mysqli_connect_error());
            }

            #Fetch the user for the inputted id
            $sql = "SELECT Role_id FROM users
                    WHERE id = '$id'";

            $result = mysqli_query($link, $sql);

            if ($result) {

              $row = $result->fetch_assoc();

              #Check if the id matched
              if ($row) {
                #Check if the role is an employee (5+ are patients and family members)
                if ($row['Role_id'] <= 4) {

                  #Attempt to update the targeted user's salary
                  $sql = "UPDATE users
                          SET salary = '$salary'
                          WHERE id = '$id'";

                  $result = mysqli_query($link, $sql);

                  if ($result == false) {
                    echo "<p class='error'>Update Failed</p>";
                  }

                }
                else {
                  echo "<p class='error'>Employee not found</p>";
                }
              }
              else {
                echo "<p class='error'>Employee not found</p>";
              }
            }
            else {
              echo "<p class='error'>Employee not found</p>";
            }

            mysqli_close($link);
          }
          ?>
        </section>

      <?php endif; ?>

      <section class="employees">

        <form class="employees" action="employee.php" method="post">

          <div>

            <label class="vertical">Attribute:
              <select name="attribute">
                <option value="not_selected">-Select an Attribute-</option>
                <option value="id">ID</option>
                <option value="name">Name</option>
                <option value="role">Role</option>
                <option value="salary">Salary</option>
              </select>
            </label>

            <label class="vertical">Value:
              <input type="text" name="value">
            </label>

        </div>

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
            if ($_POST['attribute'] == 'id') $attribute = 'u.id';

            elseif ($_POST['attribute'] == 'name') $attribute = 'Fname';

            elseif ($_POST['attribute'] == 'role') $attribute = 'role_name';

            elseif ($_POST['attribute'] == 'salary') $attribute = 'salary';

            $value = $_POST['value'] . '%';

          }

          #Establish the database connection
          $link = mysqli_connect("localhost", "root", "", "retire");

          if ($link == false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
          }

          #Retrieve all of the users who are an employee (no patient or family member roles)
          $sql = "SELECT u.id, Fname, Lname, role_name, salary
                  FROM  users u JOIN roles r ON Role_id = r.id
                  WHERE Role_id <= 4";

          if ($attribute != '' && $value != '%') {

            #If the user searches for salaries of null, provide a unique query
            if ($attribute == 'salary' && strtolower($value) == 'null%') {

              $sql = $sql . " AND salary IS NULL";

            }
            else {

              $sql = $sql . " AND $attribute LIKE '$value'";

            }
          }


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
              echo "<td>$salary</td>";

              echo "</tr>";
            }
          }
          else {
            echo "<p class='error'>Unable to retrieve data." . mysqli_connect_error() . "</p>";
          }

          mysqli_close($link);
          ?>
        </table>
      </section>
    </div>

  </body>
</html>
