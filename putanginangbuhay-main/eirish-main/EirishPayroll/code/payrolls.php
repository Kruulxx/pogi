<?php
// Load the database configuration file
include_once 'connection.php';
require_once('home.php');
include 'function/deduction.php';
include 'function/attendance.php';
// Get status message$result=mysqli_query($con,"select * from employee");



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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <div class="container-fluid">

        <div class="row my-5 mx-3">

            <h3 class="text-center">Payroll</h3>

            <div class="border-bottom my-3 hide"></div>
            <div class="dropdown my-3">

                <!-- <a href="javascript:void(0);" class="btn btn-outline-success" onclick="formToggle('importFrm');"><i class="plus"></i> Generate Payroll</a> -->

                <button type="button" class="btn btn-outline-secondary hide" onclick="window.print()">Print</button>

                <!-- CSV file upload form -->
                <div class="col-md-12" id="importFrm" style="display: none;">
                    <form action="importpayroll.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="file" />
                        <input type="submit" class="btn btn-outline-primary" name="Import" value="IMPORT">
                    </form>
                </div>

                <div style="padding-top: 10px;" class="dropdown-menu">
                    <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown">
                        Add Attendance </button>
                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#add-attendance">
                        Add Time In
                    </button>
                    <button data-toggle="modal" data-target="#modal-add-attendance-out" class="dropdown-item">Add Time
                        Out</button>
                </div>

            </div>
            <div class="border-bottom my-3 hide"></div>

            <div class="overflow-auto">
                <table class="table table-hover">
                    <thead>

                        <tr>
                            <th>EmpID</th>
                            <th>Name</th>
                            <th>Hours</th>
                            <th>Rate Per Hours</th>
                            <th>Overtime</th>
                            <th>Gross Salary</th>
                            <th>Cash Advance</th>
                            <th>Net Salary</th>
                            <th class="hide">Actions</th>
                        </tr>

                    </thead>
                    <tbody>
                        <?php
                        $con = mysqli_connect('localhost', 'root', '', 'eirish_payroll');

                        // selecting all employee
                        $result = mysqli_query($con, "SELECT * FROM employee WHERE isdeploy = 1 AND isarchive != 1");
                        while ($rows = mysqli_fetch_assoc($result)) {
                            $id = $rows['emp_id'];
                            $name = $rows['name'];
                            $rate = $rows['rate'];
                            $cash_advance = $rows['cash_advance'];

                            attendance($id, $rate);

                        ?>

                        <tr>
                            <td><?= $id ?></td>
                            <td><?= $name ?></td>
                            <td><?= $hours - $total_over . ' Hours ' . (isset($excesstime) ? $excesstime : ' 0') . ' Minutes' ?>
                            </td>
                            <td><?= $rate ?></td>
                            <td><?= $total_over . ' Hours ' . (isset($overtimemins) ? $overtimemins : ' 0') . ' Minutes' ?>
                            </td>
                            <td><?= $salary ?></td>
                            <td><?= $cash_advance == NULL ? '0' : $cash_advance ?></td>
                            <td><?= $salary - $cash_advance ?></td>
                            <td class="hide">
                                <?php if ($cash_advance == 0) : ?>
                                <button type="button" class="btn btn-outline-warning"
                                    data-bs-target="#deductionModal<?= $id ?>" data-bs-toggle="modal"><i
                                        class="plus"></i> Add Deduction</button>
                                <?php
                                    else : ?>
                                <button type="button" class="btn btn-outline-primary"
                                    data-bs-target="#editDeductionModal<?= $id ?>" data-bs-toggle="modal"><i
                                        class="plus"></i> Edit Deduction</button>

                                <?php
                                    endif ?>
                                <?php include 'modals/add-deduction.php' ?>
                            </td>

                        </tr>

                        <?php } ?>

                    </tbody>

                </table>
            </div>

            <br>
            <br>
            <br>
        </div>

    </div>

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