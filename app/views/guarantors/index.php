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

input {
    width: 100%;
    padding: 8px;
    margin: 6px 0 12px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* SHOW MODAL */
.show {
    display: flex;
}
</style>

<div class="container">

<h2>Guarantors</h2>

<button class="btn-primary" onclick="openCreateModal()">
    + Add Guarantor
</button>

<table>

    <tr>
        <th>Name</th>
        <th>Contact</th>
        <th>Address</th>
        <th>Action</th>
    </tr>

    <?php if (!empty($guarantors)): ?>
        <?php foreach ($guarantors as $g): ?>
        <tr>
            <td><?= htmlspecialchars($g['fullname']) ?></td>
            <td><?= htmlspecialchars($g['contact']) ?></td>
            <td><?= htmlspecialchars($g['address']) ?></td>

            <td>

                <button class="btn-primary"
                    onclick="openEditModal(
                        '<?= $g['id'] ?>',
                        '<?= htmlspecialchars($g['fullname'], ENT_QUOTES) ?>',
                        '<?= htmlspecialchars($g['contact'], ENT_QUOTES) ?>',
                        '<?= htmlspecialchars($g['address'], ENT_QUOTES) ?>'
                    )">
                    Edit
                </button>

                <a class="btn-danger"
                   href="/LoanManagement/public/index.php?url=guarantor/delete/<?= $g['id'] ?>"
                   onclick="return confirm('Delete this guarantor?')">
                    Delete
                </a>

            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">No guarantors found</td>
        </tr>
    <?php endif; ?>

</table>

</div>

<!-- CREATE MODAL -->
<div id="createModal" class="modal">
    <div class="modal-content">

        <h3>Add Guarantor</h3>

        <form method="POST" action="/LoanManagement/public/index.php?url=guarantor/store">

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

<!-- EDIT MODAL -->
<div id="editModal" class="modal">
    <div class="modal-content">

        <h3>Edit Guarantor</h3>

        <form method="POST" action="/LoanManagement/public/index.php?url=guarantor/update">

            <input type="hidden" name="id" id="edit_id">

            <label>Full Name</label>
            <input type="text" name="fullname" id="edit_name" required>

            <label>Contact</label>
            <input type="text" name="contact" id="edit_contact" required>

            <label>Address</label>
            <input type="text" name="address" id="edit_address" required>

            <button class="btn-primary" type="submit">Update</button>
            <button type="button" onclick="closeEditModal()">Cancel</button>

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