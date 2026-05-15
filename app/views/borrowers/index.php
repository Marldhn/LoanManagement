<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f5f6fa;
}

h2 {
    margin-bottom: 15px;
}

.container {
    padding: 20px;
}

/* BUTTONS */
button, a.btn {
    padding: 8px 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    margin-right: 5px;
    font-size: 14px;
}

.btn-primary { background: #2d89ef; color: white; }
.btn-primary:hover { background: #1b5fbf; }

.btn-success { background: #28a745; color: white; }
.btn-success:hover { background: #1f7a33; }

.btn-danger { background: #dc3545; color: white; }
.btn-danger:hover { background: #a71d2a; }

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    background: white;
    border-radius: 8px;
    overflow: hidden;
}

th {
    background: #f1f1f1;
}

th, td {
    padding: 12px;
    border: 1px solid #ddd;
}

/* MODAL BACKDROP */
.modal {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
    justify-content: center;
    align-items: center;
}

/* MODAL BOX */
.modal-content {
    background: white;
    width: 420px;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.modal-content h3 {
    margin-bottom: 15px;
}

input, select {
    width: 100%;
    padding: 8px;
    margin: 6px 0 12px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
</style>

<div class="container">

<h2>Borrowers</h2>

<button class="btn-primary" onclick="openCreateModal()">
    + Add Borrower
</button>

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

                <button class="btn-warning"
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
            <td colspan="5">No borrowers found</td>
        </tr>
    <?php endif; ?>
</table>

</div>

<!-- ================= EDIT MODAL ================= -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <h3>Edit Borrower</h3>

        <form method="POST" action="/LoanManagement/public/index.php?url=borrower/update">

            <input type="hidden" id="edit_id" name="id">

            <label>Full Name</label>
            <input type="text" id="edit_name" name="fullname" required>

            <label>Contact</label>
            <input type="text" id="edit_contact" name="contact" required>

            <label>Address</label>
            <input type="text" id="edit_address" name="address" required>

            <button class="btn-primary" type="submit">Update</button>
            <button type="button" onclick="closeEditModal()">Cancel</button>

        </form>
    </div>
</div>

<!-- ================= CREATE MODAL ================= -->
<div id="createModal" class="modal">
    <div class="modal-content">
        <h3>Add Borrower</h3>

        <form method="POST" action="/LoanManagement/public/index.php?url=borrower/store">

            <label>Full Name</label>
            <input type="text" name="fullname" required>

            <label>Contact</label>
            <input type="text" name="contact" required>

            <label>Address</label>
            <input type="text" name="address" required>

            <button class="btn-primary" type="submit">Save</button>
            <button type="button" onclick="closeCreateModal()">Cancel</button>

        </form>
    </div>
</div>

<script>

function openCreateModal() {
    document.getElementById('createModal').classList.add('show');
}

function closeCreateModal() {
    document.getElementById('createModal').classList.remove('show');
}

function openEditModal(id, name, contact, address) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_contact').value = contact;
    document.getElementById('edit_address').value = address;

    document.getElementById('editModal').classList.add('show');
}

function closeEditModal() {
    document.getElementById('editModal').classList.remove('show');
}

</script>

<?php include __DIR__ . "/../layouts/footer.php"; ?>