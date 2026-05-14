
<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<h2>Guarantors</h2>

<button onclick="openCreateModal()">Add Guarantor</button>

<br><br>

<table border="1" cellpadding="10">

    <tr>
        <th>Name</th>
        <th>Contact</th>
        <th>Address</th>
        <th>Action</th>
    </tr>

    <?php if (!empty($guarantors)): ?>
        <?php foreach ($guarantors as $g): ?>
        <tr>
            <td><?= $g['fullname'] ?></td>
            <td><?= $g['contact'] ?></td>
            <td><?= $g['address'] ?></td>

            <td>

                <!-- EDIT -->
                <button onclick="openEditModal(
                    <?= $g['id'] ?>,
                    '<?= $g['fullname'] ?>',
                    '<?= $g['contact'] ?>',
                    '<?= $g['address'] ?>'
                )">
                    Edit
                </button>

                |

                <!-- DELETE -->
                <a href="/LoanManagement/public/index.php?url=guarantor/delete/<?= $g['id'] ?>"
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




<!-- CREATE MODAL -->
<div id="createModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
background:rgba(0,0,0,0.5);">

    <div style="background:white; width:400px; margin:10% auto; padding:20px;">

        <h3>Add Guarantor</h3>

        <form method="POST" action="/LoanManagement/public/index.php?url=guarantor/store">

            <input type="text" name="fullname" placeholder="Full Name" required><br><br>
            <input type="text" name="contact" placeholder="Contact" required><br><br>
            <input type="text" name="address" placeholder="Address" required><br><br>

            <button type="submit">Save</button>
            <button type="button" onclick="closeCreateModal()">Cancel</button>

        </form>

    </div>
</div>



<!-- EDIT MODAL -->
<div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
background:rgba(0,0,0,0.5);">

    <div style="background:white; width:400px; margin:10% auto; padding:20px;">

        <h3>Edit Guarantor</h3>

        <form method="POST" action="/LoanManagement/public/index.php?url=guarantor/update">

            <input type="hidden" name="id" id="edit_id">

            <input type="text" name="fullname" id="edit_name" required><br><br>
            <input type="text" name="contact" id="edit_contact" required><br><br>
            <input type="text" name="address" id="edit_address" required><br><br>

            <button type="submit">Update</button>
            <button type="button" onclick="closeEditModal()">Cancel</button>

        </form>

    </div>
</div>





<script>

function openCreateModal() {
    document.getElementById('createModal').style.display = 'block';
}

function closeCreateModal() {
    document.getElementById('createModal').style.display = 'none';
}

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

</script>





<?php include __DIR__ . "/../layouts/footer.php"; ?>