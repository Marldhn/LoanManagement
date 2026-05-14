<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<h2>Account List</h2>

<!-- OPEN CREATE MODAL -->
<button onclick="openCreateModal()">
    Add Account
</button>

<a href="/LoanManagement/public/index.php?url=account/transferForm">
    Transfer Funds
</a>

<br><br>

<table border="1" cellpadding="10">

    <tr>
        <th>Account Name</th>
        <th>Balance</th>
        <th>Description</th>
        <th>Action</th>
    </tr>

    <?php if (!empty($accounts)): ?>
        <?php foreach ($accounts as $account): ?>
        <tr>
            <td><?= $account['account_name'] ?></td>
            <td><?= $account['balance'] ?></td>
            <td><?= $account['description'] ?></td>

            <td>

                <!-- EDIT -->
                <button onclick="openEditModal(
                    <?= $account['id'] ?>,
                    '<?= addslashes($account['account_name']) ?>',
                    '<?= $account['balance'] ?>',
                    '<?= addslashes($account['description']) ?>'
                )">
                    Edit
                </button>

                |

                <!-- DELETE -->
                <a href="/LoanManagement/public/index.php?url=account/delete/<?= $account['id'] ?>"
                   onclick="return confirm('Delete this account?')">
                    Delete
                </a>

            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">No accounts found</td>
        </tr>
    <?php endif; ?>

</table>





<!-- EDIT MODAL -->
<div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
background:rgba(0,0,0,0.5);">

    <div style="background:white; width:400px; margin:10% auto; padding:20px; border-radius:8px;">

        <h3>Edit Account</h3>

        <form method="POST" action="/LoanManagement/public/index.php?url=account/update">

            <input type="hidden" name="id" id="edit_id">

            <label>Name</label><br>
            <input type="text" name="account_name" id="edit_name" required><br><br>

            <label>Balance</label><br>
            <input type="number" name="balance" id="edit_balance" required><br><br>

            <label>Description</label><br>
            <input type="text" name="description" id="edit_description" required><br><br>

            <button type="submit">Update</button>
            <button type="button" onclick="closeEditModal()">Cancel</button>

        </form>

    </div>
</div>


<!-- CREATE MODAL -->
<div id="createModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
background:rgba(0,0,0,0.5);">

    <div style="background:white; width:400px; margin:10% auto; padding:20px; border-radius:8px;">

        <h3>Add Account</h3>

        <form method="POST" action="/LoanManagement/public/index.php?url=account/store">

            <label>Account Name</label><br>
            <input type="text" name="account_name" required><br><br>

            <label>Balance</label><br>
            <input type="number" name="balance" required><br><br>

            <label>Description</label><br>
            <input type="text" name="description" required><br><br>

            <button type="submit">Save</button>
            <button type="button" onclick="closeCreateModal()">Cancel</button>

        </form>

    </div>
</div>


<script>

function openEditModal(id, name, balance, description) {

    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_balance').value = balance;
    document.getElementById('edit_description').value = description;

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