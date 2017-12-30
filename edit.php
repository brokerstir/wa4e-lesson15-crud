<?php
//require_once "pdo.php";
require_once "pdo_db_live.php";
session_start();

if ( isset($_POST['make']) && isset($_POST['model'])
     && isset($_POST['year']) && isset($_POST['mileage']) ) {

    // Data validation should go here (see add.php)
    $sql = "UPDATE autos SET make = :make,
            model = :model, year = :year, mileage = :mileage
            WHERE auto_id = :auto_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage'],
        ':auto_id' => $_POST['auto_id']));
    $_SESSION['success'] = 'Record Updated';
    header( 'Location: view.php' ) ;
    return;
}

/// Guardian: Make sure that user_id is present
if ( ! isset($_GET['auto_id']) ) {
  $_SESSION['error'] = "Missing Parameter";
  header('Location: view.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where auto_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['auto_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Sorry, Something Went Wrong';
    header( 'Location: view.php' ) ;
    return;
}

$n = htmlentities($row['make']);
$e = htmlentities($row['model']);
$p = htmlentities($row['year']);
$m = htmlentities($row['mileage']);
$auto_id = $row['auto_id'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Broker Stir | Tracking Autos</title>
<?php

require_once "bootstrap.php";

?>
</head>
<body>
<p>Edit Auto</p>
<form method="post">
<p>Make:
<input type="text" name="make" value="<?= $n ?>"></p>
<p>Model:
<input type="text" name="model" value="<?= $e ?>"></p>
<p>Year:
<input type="text" name="year" value="<?= $p ?>"></p>
<p>Mileage:
<input type="text" name="mileage" value="<?= $m ?>"></p>
<input type="hidden" name="auto_id" value="<?= $auto_id ?>">
<p><input type="submit" value="Update"/>
<a href="view.php">Cancel</a></p>
</form>

</body>
</html>
