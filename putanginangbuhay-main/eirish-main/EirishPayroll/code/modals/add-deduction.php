<!-- add deduction modal -->
<div class="modal fade" id="deductionModal<?= $id ?>" tabhome="-1" aria-labelledby="deductionModalLabel" aria-hidden="true">
    <form method="POST">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deductionModalLabel">Add Deduction</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="id" value="<?= $id ?>">

                    <label for="deduction">Deduction</label>
                    <input type="text" name="deduction" id="" class="form-control mb-2">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                    <button name="add" type="submit" class="btn btn-outline-success">Add</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- edit deduction modal -->
<div class="modal fade" id="editDeductionModal<?= $id ?>" tabhome="-1" aria-labelledby="editDeductionModalLabel" aria-hidden="true">
    <form method="POST">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editDeductionModalLabel">Edit Deduction</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="id" value="<?= $id ?>">

                    <label for="edit-deduction">Edit Deduction</label>
                    <?php
                    $select_query = mysqli_query($GLOBALS['con'], "SELECT cash_advance FROM employee WHERE emp_id = '$id'");
                    while ($rows = mysqli_fetch_assoc($select_query)) {
                        $value = $rows['cash_advance'];
                    };
                    ?>

                    <input type="text" name="edit-deduction" id="" class="form-control mb-2" value="<?= $value ?>">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                    <button name="edit" type="submit" class="btn btn-outline-success">Edit</button>
                </div>
            </div>
        </div>
    </form>
</div>