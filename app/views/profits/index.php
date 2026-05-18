<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<style>
body {
    font-family: Arial;
    background: #f5f6fa;
}

.container { padding: 20px; }

button {
    padding: 8px 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.btn-primary { background: #2d89ef; color: white; }
.btn-success { background: #28a745; color: white; }

/* TABLE */
table {
    width: 100%;
    background: white;
    border-collapse: collapse;
    margin-top: 15px;
}

th, td {
    padding: 10px;
    border: 1px solid #ddd;
}

/* MODAL */
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

.modal.show {
    display: flex;
}

.modal-content {
    background: white;
    padding: 20px;
    width: 400px;
    border-radius: 10px;
}

input, select {
    width: 100%;
    padding: 8px;
    margin: 8px 0;
}
</style>

<div class="container">

<h2>Profit Records</h2>

<button class="btn-primary" onclick="openCreateModal()">
    + Add Profit
</button>

<table>
<tr>
    <th>ID</th>
    <th>Source</th>
    <th>Amount</th>
    <th>Type</th>
</tr>

<?php foreach ($profits as $p): ?>
<tr>
    <td><?= $p['id'] ?></td>
    <td><?= $p['source'] ?></td>
    <td>₱<?= number_format($p['amount'],2) ?></td>
    <td><?= $p['type'] ?></td>
</tr>
<?php endforeach; ?>

</table>

</div>

<!-- MODAL -->
<div id="createModal" class="modal">
<div class="modal-content">

<h3>Add Profit</h3>

<form method="POST" action="/LoanManagement/public/index.php?url=profit/storeProfit">

    <label>Account</label>
    <select name="account_id" required>
        <option value="">Select Account</option>
        <?php foreach ($accounts as $a): ?>
            <option value="<?= $a['id'] ?>">
                <?= $a['account_name'] ?> (₱<?= number_format($a['balance'],2) ?>)
            </option>
        <?php endforeach; ?>
    </select>

    <label>Amount</label>
    <input type="number" name="amount" required>

    <label>Description</label>
    <input type="text" name="source" required>

    <button class="btn-success" type="submit">Save</button>
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
</script>

<?php include __DIR__ . "/../layouts/footer.php"; ?>