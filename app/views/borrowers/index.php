<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<style>

.borrower-page {
    font-family: Arial, sans-serif;
    color: #2c3e50;
}

h2 {
    margin-bottom: 15px;
}

/* Buttons */
.btn {
    padding: 8px 12px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    font-size: 14px;
    text-decoration: none;
    display: inline-block;
}

.btn-primary { background: #2c3e50; color: white; }
.btn-primary:hover { background: #34495e; }

.btn-warning { background: #f39c12; color: white; }
.btn-danger { background: #e74c3c; color: white; }

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
}

table th {
    background: #2c3e50;
    color: white;
    padding: 12px;
    text-align: left;
}

table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

table tr:hover {
    background: #f8f9fa;
}

/* Responsive */
@media (max-width: 768px) {
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
    z-index: 9999;
}

.modal-content {
    background: #ffffff;
    width: 420px;
    max-width: 90%;
    margin: 8% auto;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    font-family: Arial;
}

.modal-content h3 {
    margin-top: 0;
    color: #2c3e50;
}

.modal-content input {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
}

.modal-content button {
    padding: 8px 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.btn-save {
    background: #2c3e50;
    color: white;
}

.btn-cancel {
    background: #bdc3c7;
}


</style>

<div class="borrower-page">

<h2>Borrowers</h2>

<button class="btn btn-primary" onclick="openCreateModal()">
    Add Borrower
</button>

<br><br>

<table>

    <tr>
        <th>Name</th>
        <th>Contact</th>
        <th>Address</th>
        <th>Total Payable</th>
        <th>Action</th>
    </tr>

    <?php if (!empty($borrowers)): ?>

        <?php foreach ($borrowers as $b): ?>

        <tr>
            <td><?= htmlspecialchars($b['fullname']) ?></td>
            <td><?= htmlspecialchars($b['contact']) ?></td>
            <td><?= htmlspecialchars($b['address']) ?></td>
           <td>
                 ₱<?= number_format(
                     $b['total_loan'] + $b['total_interest'] + $b['total_penalty'],
                        2
                      ) ?>
            </td>
            <td>

                <a class="btn btn-primary"
                   href="/LoanManagement/public/index.php?url=borrower/details/<?= $b['id'] ?>">
                    Details
                </a>

                <button class="btn btn-warning"
                    onclick="openEditModal(
                        '<?= $b['id'] ?>',
                        '<?= htmlspecialchars($b['fullname'], ENT_QUOTES) ?>',
                        '<?= htmlspecialchars($b['contact'], ENT_QUOTES) ?>',
                        '<?= htmlspecialchars($b['address'], ENT_QUOTES) ?>'
                    )">
                    Edit
                </button>

                <a class="btn btn-danger"
                   href="/LoanManagement/public/index.php?url=borrower/delete/<?= $b['id'] ?>"
                   onclick="return confirm('Delete this borrower?')">
                    Delete
                </a>

            </td>
        </tr>

        <?php endforeach; ?>

    <?php else: ?>
        <tr>
            <td colspan="4">No borrowers found</td>
        </tr>
    <?php endif; ?>

</table>

</div>

<!-- ===================== -->
<!-- EDIT MODAL -->
<!-- ===================== -->
<div id="editModal" class="modal">

    <div class="modal-content">

        <h3>Edit Borrower</h3>

        <form method="POST"
        action="/LoanManagement/public/index.php?url=borrower/update">

            <input type="hidden" name="id" id="edit_id">

            <label>Full Name</label>
            <input type="text" name="fullname" id="edit_name" required>

            <label>Contact</label>
            <input type="text" name="contact" id="edit_contact" required>

            <label>Address</label>
            <input type="text" name="address" id="edit_address" required>

            <button type="submit" class="btn-save">Update</button>
            <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>

        </form>

    </div>

</div>

<!-- ===================== -->
<!-- CREATE MODAL -->
<!-- ===================== -->
<div id="createModal" class="modal">

    <div class="modal-content">

        <h3>Add Borrower</h3>

        <form method="POST"
        action="/LoanManagement/public/index.php?url=borrower/store">

            <label>Full Name</label>
            <input type="text" name="fullname" required>

            <label>Contact</label>
            <input type="text" name="contact" required>

            <label>Address</label>
            <input type="text" name="address" required>

            <button type="submit" class="btn-save">Save</button>
            <button type="button" class="btn-cancel" onclick="closeCreateModal()">Cancel</button>

        </form>

    </div>

</div>

<script>

function openEditModal(id, name, contact, address) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_contact').value = contact;
    document.getElementById('edit_address').value = address;

    document.getElementById('editModal').style.display = 'block';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

function openCreateModal() {
    document.getElementById('createModal').style.display = 'block';
}

function closeCreateModal() {
    document.getElementById('createModal').style.display = 'none';
}

</script>

<?php include __DIR__ . "/../layouts/footer.php"; ?>