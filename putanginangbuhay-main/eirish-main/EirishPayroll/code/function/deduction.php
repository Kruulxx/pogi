<?php
function add_deduction()
{
    if (isset($_POST['add'])) {
        $id = $_POST['id'];
        $deduction = $_POST['deduction'];

        $update_query = mysqli_query($GLOBALS['con'], "UPDATE employee SET cash_advance = '$deduction' WHERE emp_id = '$id'");
    };
}
add_deduction();

function edit_deduction()
{
    if (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $deduction = $_POST['edit-deduction'];

        $update_query = mysqli_query($GLOBALS['con'], "UPDATE employee SET cash_advance = '$deduction' WHERE emp_id = '$id'");
    };
}
edit_deduction();
