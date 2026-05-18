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

/* MODAL SHOW */
.show {
    display: flex;
}
</style>

<div class="container">

<h2>Account List</h2>

<!-- ACTION BUTTONS -->
<button class="btn-primary" onclick="openCreateModal()">+ Add Account</button>

<button class="btn-success" onclick="openTransferModal()">
    Transfer Funds
</button>

<table>
    <tr>
        <th>Account Name</th>
        <th>Balance</th>
        <th>Description</th>
        <th>Action</th>
    </tr>

    <?php foreach ($accounts as $account): ?>
    <tr>
        <td><?= $account['account_name'] ?></td>
        <td>₱<?= number_format($account['balance'],2) ?></td>
        <td><?= $account['description'] ?></td>
        <td>
            <button class="btn-primary"
    onclick="openEditModal(
        <?= $account['id'] ?>,
        '<?= addslashes($account['account_name']) ?>',
        '<?= addslashes($account['account_number']) ?>',
        '<?= $account['balance'] ?>',
        '<?= addslashes($account['description']) ?>'
    )">
    Edit
</button>

      <a class="btn btn-danger"
   href="/LoanManagement/public/index.php?url=account/forceDelete/<?= $account['id'] ?>"
   onclick="return confirm('Permanently delete this account?')">
    Delete

</a>

<a class="btn btn-primary"
   href="/LoanManagement/public/index.php?url=account/details/<?= $account['id'] ?>">
   Details
</a>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

</div>

<!-- ===================== CREATE MODAL ===================== -->
<div id="createModal" class="modal">
    <div class="modal-content">
        <h3>Add Account</h3>

        <form method="POST" action="/LoanManagement/public/index.php?url=account/store">

            <label>Account Name</label>
            <input type="text" name="account_name" required>

                <label>Account Number</label>
            <input type="text" name="account_number" required>

            <label>Balance</label>
            <input type="number" name="balance" required>

            <label>Description</label>
            <input type="text" name="description" required>

            <button class="btn-primary" type="submit">Save</button>
            <button type="button" onclick="closeCreateModal()">Cancel</button>

        </form>
    </div>
</div>

<!-- ===================== EDIT MODAL ===================== -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <h3>Edit Account</h3>

        <form method="POST" action="/LoanManagement/public/index.php?url=account/update">

            <input type="hidden" name="id" id="edit_id">

            <label>Name</label>
            <input type="text" name="account_name" id="edit_name" required>

             <label>Account Number</label>
            <input type="text" name="account_number" id="edit_account_number" required>

            <label>Balance</label>
            <input type="number" name="balance" id="edit_balance" required>

            <label>Description</label>
            <input type="text" name="description" id="edit_description" required>

            <button class="btn-primary" type="submit">Update</button>
            <button type="button" onclick="closeEditModal()">Cancel</button>

        </form>
    </div>
</div>

<!-- ===================== TRANSFER MODAL ===================== -->
<div id="transferModal" class="modal">
    <div class="modal-content">
        <h3>Transfer Funds</h3>

        <form method="POST" action="/LoanManagement/public/index.php?url=account/transferStore">

            <label>From Account</label>
            <select name="from_account" required>
                <option value="">Select</option>
                <?php foreach ($accounts as $a): ?>
                    <option value="<?= $a['id'] ?>">
                        <?= $a['account_name'] ?> (₱<?= number_format($a['balance'],2) ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <label>To Account</label>
            <select name="to_account" required>
                <option value="">Select</option>
                <?php foreach ($accounts as $a): ?>
                    <option value="<?= $a['id'] ?>">
                        <?= $a['account_name'] ?> (₱<?= number_format($a['balance'],2) ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Amount</label>
            <input type="number" name="amount" required>

            <button class="btn-success" type="submit">Transfer</button>
            <button type="button" onclick="closeTransferModal()">Cancel</button>

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

function openEditModal(id, name, account_number, balance, description) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_account_number').value = account_number;
    document.getElementById('edit_balance').value = balance;
    document.getElementById('edit_description').value = description;
    document.getElementById('editModal').classList.add('show');
}

function closeEditModal() {
    document.getElementById('editModal').classList.remove('show');
}

function openTransferModal() {
    document.getElementById('transferModal').classList.add('show');
}

function closeTransferModal() {
    document.getElementById('transferModal').classList.remove('show');
}

</script>

<?php include __DIR__ . "/../layouts/footer.php"; ?>