<?php     
require_once "home.php";
$con = mysqli_connect('localhost', 'root', '', 'eirish_payroll');
$result = mysqli_query($con, "SELECT * FROM archive_attendancee");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payroll</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">

  </head>
<body>
<div>
<div class="container" style="margin-top:50px;">    

<div class="container my-5">
<h3 class="text-center font-weight-bold" style="font-size:25px;">Archive Attendances</h3>
</div>

<form method="post" id="frm">
  <table id="example" class="table table-hover">
    <thead class="thead-light">
      <tr>

      <th>EmpID</th>
          <th>Name</th>
          <th>Date</th>
          <th>Time In</th>
          <th>Time Out</th>
          <th>Total Hours</th>
          <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
      <td class="border-start border-end" style="margin-top:10px;"><?php echo $row['emp_id'] ?></td>
              <td class="border-start border-end" style="margin-top:10px;"><?php echo $row['name'] ?></td>
              <td class="border-start border-end" style="margin-top:10px;"><?php echo $row['date'] ?></td>
              <td class="border-start border-end" style="margin-top:10px;"><?php echo $row['time_in'] ?></td>
              <td class="border-start border-end" style="margin-top:10px;"><?php echo $row['time_out'] ?></td>
              <td class="border-start border-end" style="margin-top:10px;"><?php echo $row['total_hours'] ?></td>

        <td  >
                          <a href="restore_attend.php?id=<?php echo $row['id'] ?>" class="btn btn-outline-success">Restore</a>
                      
                          </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</form>
</div>
      </div>
<?php require_once "scripts.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
         
<?php require_once('footer.php')?>
