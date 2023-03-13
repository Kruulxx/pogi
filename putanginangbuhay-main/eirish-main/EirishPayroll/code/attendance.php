<?php
require_once('home.php');
include "connection.php";
$conn = mysqli_connect('localhost', 'root', '', 'eirish_payroll');
$result = mysqli_query($con, "select * from attendancee");


if (!empty($_GET['status'])) {
  switch ($_GET['status']) {
    case 'succ':
      $statusType = 'alert-success';
      $statusMsg = 'Employee data has been imported successfully.';
      break;
    case 'err':
      $statusType = 'alert-danger';
      $statusMsg = 'Some problem occurred, please try again.';
      break;
    case 'invalid_file':
      $statusType = 'alert-danger';
      $statusMsg = 'Please upload a valid CSV file.';
      break;
    default:
      $statusType = '';
      $statusMsg = '';
  }
}
?>
<!-- Display status message -->
<?php if (!empty($statusMsg)) { ?>
  <div class="col-xs-12">
    <div class="alert <?php echo $statusType; ?>"><?php echo $statusMsg; ?></div>
  </div>
<?php } ?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Datatable</title>
  <link rel="stylesheet" href="css/footer.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
  <style>
    .btn {
      font-size: 18px;
      padding: 12px 24px;
      border-radius: 4px;
      border-width: 2px;
      border-style: solid;
      text-transform: uppercase;
      transition: all 0.3s ease;

    }

    .btn-outline-danger {
      color: #dc3545;
      background-color: transparent;
      border-color: #dc3545;
    }

    .btn-outline-danger:hover {
      color: #fff;
      background-color: #dc3545;
      border-color: #dc3545;
    }
  </style>
</head>

<body>
  <div class="container" style="margin-top:50px;">
    <center>
      <h3>Attendance
      </h3>
    </center>
    <div class="border-bottom my-3"></div>
    <div class="dropdown my-3">



      <a href="javascript:void(0);" class="btn btn-outline-primary" onclick="formToggle('importFrm');"><i class="plus"></i> Import Attendance</a>

      <!-- CSV file upload form -->
      <div class="col-md-12" id="importFrm" style="display: none;">
        <form action="import.php" method="post" enctype="multipart/form-data">
          <input type="file" name="file" />

          <input type="submit" class="btn btn-outline-primary" name="importSubmit" value="IMPORT">
        </form>
      </div>
      <button class="btn btn-outline-danger" onclick="archive_all()">Archive</button>

    </div>
    <form method="post" id="form">
      <div class="border-bottom my-3"></div>
      <table class="table table-hover">
        <thead>
          <th width="15%"><input type="checkbox" onclick="select_all()" id="archive" /></th>
          <th>EmpID</th>
          <th>Name</th>
          <th>Date</th>
          <th>Time In</th>
          <th>Time Out</th>
          <th>Total Hours</th>

          </tr>

        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
            <tr id="box<?php echo $row['id'] ?>">
              <td><input type="checkbox" id="<?php echo $row['id'] ?>" name="checkbox[]" value="<?php echo $row['id'] ?>" /></td>
              <td class="border-start border-end" style="margin-top:10px;"><?php echo $row['emp_id'] ?></td>
              <td class="border-start border-end" style="margin-top:10px;"><?php echo $row['name'] ?></td>
              <td class="border-start border-end" style="margin-top:10px;"><?php echo $row['date'] ?></td>
              <td class="border-start border-end" style="margin-top:10px;"><?php echo $row['time_in'] ?></td>
              <td class="border-start border-end" style="margin-top:10px;"><?php echo $row['time_out'] ?></td>
              <td class="border-start border-end" style="margin-top:10px;"><?php echo $row['total_hours'] ?></td>

            </tr>


          <?php } ?>

          </thead>

      </table>
    </form>
    <?php require_once('addattendance.php');  ?>

  </div>
  </div>

  <script>
    function count_selected() {
      var checkboxes = jQuery('input[type=checkbox]');
      var checked_checkboxes = checkboxes.filter(':checked');
      return checked_checkboxes.length;
    }

    function select_all() {
      if (jQuery('#archive').prop("checked")) {
        jQuery('input[type=checkbox]').each(function() {
          jQuery(this).prop('checked', true);
        });
      } else {
        jQuery('input[type=checkbox]').each(function() {
          jQuery(this).prop('checked', false);
        });
      }
    }

    function archive_all() {
      var checkboxes = jQuery('input[type=checkbox]');
      var checked_checkboxes = checkboxes.filter(':checked');
      var count = count_selected();

      if (count === 0) {
        alert('Please select at least one item to delete.');
        return;
      }

      var check = confirm("Are you sure you want to Archive " + count + " items?");
      if (check) {
        jQuery.ajax({
          url: 'archive_attendance.php',
          type: 'post',
          data: jQuery('#form').serialize(),
          success: function(result) {
            checked_checkboxes.each(function() {
              jQuery('#box' + this.id).remove();
            });
          }
        });
      }
    }

    // Add event listener to the "select all" checkbox
    jQuery('#delete').on('change', function() {
      select_all();
    });
  </script>
  <br>
  <br>
  <?php require_once('footer.php'); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.table').DataTable();
    });
  </script>
  <!-- Show/hide CSV upload form -->
  <script>
    function formToggle(ID) {
      var element = document.getElementById(ID);
      if (element.style.display === "none") {
        element.style.display = "block";
      } else {
        element.style.display = "none";
      }
    }
  </script>
</body>

</html>