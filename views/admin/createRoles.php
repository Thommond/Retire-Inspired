<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Create Roles</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>
  <body>

    <section>

      <form  action="createRole.php" method="post">

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

        }
       ?>

    </section>


  </body>
</html>
