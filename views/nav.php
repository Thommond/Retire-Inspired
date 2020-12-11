<?php


if(isset($_POST['logout'])) {
  session_start();
  session_destroy();
  header('Location: http://localhost/Retire-Inspired/views/auth/login.php');
}

?>

<!DOCTYPE html>

<header>

  <h1>Central Lancaster Mennonite Retirement Home</h1>

  <?php if (session_status() == PHP_SESSION_ACTIVE): ?>

    <div class="header">

      <div class="logout">

        <p><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?></p>

        <form class="exit" action="http://localhost/Retire-Inspired/views/nav.php" method="post">
            <input type="submit" name="logout" value="Log Out">
        </form>

      </div>

      <nav>

        <?php

        if ($_SESSION['Role_id'] == 1) echo '<a href="http://localhost/Retire-Inspired/views/admin/adminHome.php">Home Page</a>';
        elseif ($_SESSION['Role_id'] == 2) echo '<a href="http://localhost/Retire-Inspired/views/home/supervisorHome.php">Home Page</a>';
        elseif ($_SESSION['Role_id'] == 3) echo '<a href="http://localhost/Retire-Inspired/views/doctor/doctorHome.php">Home Page</a>';
        elseif ($_SESSION['Role_id'] == 4) echo '<a href="http://localhost/Retire-Inspired/views/home/caregiverHome.php">Home Page</a>';
        elseif ($_SESSION['Role_id'] == 5) echo '<a href="http://localhost/Retire-Inspired/views/home/patientHome.php">Home Page</a>';
        elseif ($_SESSION['Role_id'] == 6) echo '<a href="http://localhost/Retire-Inspired/views/home/familyMemberHome.php">Home Page</a>';
        ?>

      </nav>
    </div>

  <?php endif; ?>
</header>
