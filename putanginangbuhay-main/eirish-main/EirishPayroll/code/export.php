<?php 
 // Load the database configuration file 
include_once 'connection.php'; 
 
// Fetch records from database 
$query = $con->query("SELECT * FROM employee WHERE isdeploy='1' ORDER BY id ASC"); 
 
if($query->num_rows > 0){ 
    $delimiter = ","; 
    $filename = "deploy_employee_" . date('Y-m-d') . ".csv"; 
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array(); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['emp_id'], $row['name'], $row['position']); 
        fputcsv($f, $lineData, $delimiter, "\t"); 
    } 
     
    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename=' . $filename . ';'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
} 
exit; 

?>