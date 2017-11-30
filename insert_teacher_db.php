<?php
session_start();
$now = time();
if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
    
    session_unset();
    session_destroy();
   
}

if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn']!=1){
    header('Location: index.php');
    exit();
}
include 'parameters.php';
$mysqli = new mysqli($servername, $username, $password , $dbname);
$mysqli->set_charset('utf8');


/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


  $am = $_POST['am'];
  $afm = $_POST['afm'];
  $FirstName = $_POST['FirstName'];
  $LastName = $_POST['LastName'];
  $FatherFirstName = $_POST['FatherFirstName'];
  $sxesi = $_POST['sxesi'];
  $telephone = $_POST['telephone'];
  $sxesitop = $_POST['sxesitop'];

$stmt = $mysqli->prepare("INSERT INTO teachers (am, afm,FirstName,LastName,FatherFirstName,sxesi_ergasias,sxesi_topothetisis,telephone)
               VALUES(?,?,?,?,?,?,? ,?)");

$stmt->bind_param("iisssssi",$am, $afm,$FirstName, $LastName, $FatherFirstName , $sxesi ,$sxesitop, $telephone);

$stmt->execute();

printf(" Έγινε εισαγωγή %d εγγραφής. Εισήχθη ο εκπαιδευτικός %s %s.\n", $stmt->affected_rows , $LastName , $FirstName );

/* close statement and connection */
$stmt->close();
$mysqli->close();
?> 