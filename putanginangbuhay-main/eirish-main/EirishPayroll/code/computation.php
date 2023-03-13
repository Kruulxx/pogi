<?php
require_once('home.php');
include "connection.php";
$conn = mysqli_connect('localhost', 'root', '', 'eirish_payroll');
$result = mysqli_query($conn, "SELECT * FROM attendancee");

// Get data from the form
$time_in = $_POST['time_in'];
$time_out = $_POST['time_out'];

$time1_str = $time_in;
$time2_str = $time_out;

// Create DateTime objects for each time
$time1 = DateTime::createFromFormat('H:i:s', $time1_str);
$time2 = DateTime::createFromFormat('H:i:s', $time2_str);

// Calculate the time difference between the two times
$diff = $time2->diff($time1);

// Output the difference as hours:minutes:seconds
echo $diff->format('%H:%I:%S');
?>
