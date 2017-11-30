<?php
if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn']!=1){
    header('Location: index.php');
    exit();
}


$servername="yourservername";
$username="xxx"; // mysql username
$password="xxxxx"; //mysql password
$dbname='persons_db';

?>