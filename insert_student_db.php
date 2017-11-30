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


    $sql= 'SELECT max(RegistrationNumber) as max from persons_db.students'; 
    $row = $mysqli->query($sql)->fetch_array();
    $RegistrationNumber = intval($row['max'])+1 ;
    

    $sql= 'SELECT max(StudentId) as max from persons_db.students'; 
    $row = $mysqli->query($sql)->fetch_array();
    $StudentId =intval( $row['max'])+1;
 
  $FirstName = $_POST['FirstName'];
  $LastName = $_POST['LastName'];
  $FatherFirstName = $_POST['FatherFirstName'];
  $MotherFirstName = $_POST['MotherFirstName'];
  $BirthDate = $_POST['BirthDate'];
  $Telephone1 = $_POST['Telephone1'];
  $LevelName = $_POST['LevelName'];

$stmt = $mysqli->prepare("INSERT INTO students (StudentId, RegistrationNumber,FirstName,LastName,MotherFirstName,FatherFirstName,BirthDate,Telephone1, LevelName)
               VALUES(?,?,?,?,?,?,? ,?,?)");

$stmt->bind_param("iisssssis",$StudentId, $RegistrationNumber,$FirstName, $LastName, $MotherFirstName,  $FatherFirstName , $BirthDate ,$Telephone1, $LevelName);

$stmt->execute();

printf(" Έγινε εισαγωγή %d εγγραφής. Εισήχθη ο μαθητής %s %s.\n", $stmt->affected_rows , $LastName , $FirstName );

/* close statement and connection */
$stmt->close();
$mysqli->close();

?> 