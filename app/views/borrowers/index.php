<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<h2>Borrowers</h2>

<button onclick="openCreateModal()">
    Add Borrower
</button>

<br><br>

<table border="1" cellpadding="10">

    <tr>
        <th>Name</th>
        <th>Contact</th>
        <th>Address</th>
        <th>Action</th>
    </tr>

    <?php if (!empty($borrowers)): ?>
        <?php foreach ($borrowers as $b): ?>
        <tr>
            <td><?= $b['fullname'] ?></td>
            <td><?= $b['contact'] ?></td>
            <td><?= $b['address'] ?></td>

            <td>
                <button 
    onclick="openEditModal(
        <?= $b['id'] ?>,
        '<?= $b['fullname'] ?>',
        '<?= $b['contact'] ?>',
        '<?= $b['address'] ?>'
    )">
    Edit
</button>

                |

                <!-- DELETE -->
                <a href="/LoanManagement/public/index.php?url=borrower/delete/<?= $b['id'] ?>"
                   onclick="return confirm('Are you sure you want to delete this borrower?')">
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


<!-- EDIT MODAL -->
<div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
background:rgba(0,0,0,0.5);">

    <div style="background:white; width:400px; margin:10% auto; padding:20px; border-radius:8px;">

        <h3>Edit Borrower</h3>

        <form method="POST" action="/LoanManagement/public/index.php?url=borrower/update">

            <input type="hidden" name="id" id="edit_id">

            <label>Name</label><br>
            <input type="text" name="fullname" id="edit_name" required><br><br>

            <label>Contact</label><br>
            <input type="text" name="contact" id="edit_contact" required><br><br>

            <label>Address</label><br>
            <input type="text" name="address" id="edit_address" required><br><br>

            <button type="submit">Update</button>
            <button type="button" onclick="closeEditModal()">Cancel</button>

        </form>

    </div>
</div>


<!-- CREATE MODAL -->
<div id="createModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
background:rgba(0,0,0,0.5);">

    <div style="background:white; width:400px; margin:10% auto; padding:20px; border-radius:8px;">

        <h3>Add Borrower</h3>

        <form method="POST" action="/LoanManagement/public/index.php?url=borrower/store">

            <label>Name</label><br>
            <input type="text" name="fullname" required><br><br>

            <label>Contact</label><br>
            <input type="text" name="contact" required><br><br>

            <label>Address</label><br>
            <input type="text" name="address" required><br><br>

            <button type="submit">Save</button>
            <button type="button" onclick="closeCreateModal()">Cancel</button>

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