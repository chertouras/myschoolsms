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
 
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
include 'parameters.php';
// DB table to use
$table = 'students';
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'RegistrationNumber',  'dt' => 1 ),
    array( 'db' => 'FirstName',   'dt' => 2 ),
    array( 'db' => 'LastName',   'dt' => 3 ),
    array( 'db' => 'FatherFirstName',   'dt' => 4 ),
    array( 'db' => 'BirthDate',   'dt' => 5 ),
    array( 'db' => 'Telephone1',   'dt' => 6 ),
    array( 'db' => 'LevelName',     'dt' => 7 ),
   
);
 
// SQL server connection information
$sql_details = array(
    'user' => $username,
    'pass' => $password,
    'db'   => $dbname,
    'host' => $servername
 );
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);
?>