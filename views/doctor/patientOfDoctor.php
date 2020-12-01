<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Patient Of Doctor</title>
    <link rel="stylesheet" href="../../static/style.css">
  </head>
  <body>

    <?php
    include ('../../common-functions.php');
    check_session(3);
    $patient = $_GET['patient_id_num'];

    echo $patient;
    ?>

    <section>
      <p>Hello dumbass</p>
    </section>


  </body>
</html>
