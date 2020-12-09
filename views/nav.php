<!DOCTYPE html>

<nav>

  <?php

  if ($_SESSION['Role_id'] == 1) echo '<a href="http://localhost/Retire-Inspired/views/admin/adminHome.php">Back</a>';
  if ($_SESSION['Role_id'] == 2) echo '<a href="http://localhost/Retire-Inspired/views/home/supervisorHome.php">Back</a>';
  if ($_SESSION['Role_id'] == 3) echo '<a href="http://localhost/Retire-Inspired/views/doctor/doctorHome.php">Back</a>';
  if ($_SESSION['Role_id'] == 4) echo '<a href="http://localhost/Retire-Inspired/views/home/caregiverHome.php">Back</a>';
  if ($_SESSION['Role_id'] == 5) echo '<a href="http://localhost/Retire-Inspired/views/home/patientHome.php">Back</a>';
  if ($_SESSION['Role_id'] == 6) echo '<a href="http://localhost/Retire-Inspired/views/home/familyMemberHome.php">Back</a>';
  ?>
</nav>
