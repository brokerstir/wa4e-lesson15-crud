<?php
//require_once "pdo.php";
require_once "pdo_db_live.php";
session_start();

if ( isset($_POST['delete']) && isset($_POST['auto_id']) ) {
    $sql = "DELETE FROM autos WHERE auto_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['auto_id']));
    $_SESSION['success'] = 'Record Deleted';
    header( 'Location: view.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['auto_id']) ) {
  $_SESSION['error'] = "Missing Parameter";
  header('Location: view.php');
  return;
}

$stmt = $pdo->prepare("SELECT auto_id, make FROM autos where auto_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['auto_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Record Not Found';
    header( 'Location: view.php' ) ;
    return;
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Robert Risk | Tracking Autos</title>
<?php

require_once "bootstrap.php";

?>
</head>
<body>
<div class="container">

<p>Confirm: Deleting <?= htmlentities($row['make']) ?></p>

<form method="post">
<input type="hidden" name="auto_id" value="<?= $row['auto_id'] ?>">
<input type="submit" value="Delete" name="delete">
<a href="view.php">Cancel</a>
</form>

</div>
