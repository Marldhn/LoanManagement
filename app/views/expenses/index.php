<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f5f6fa;
}

.container {
    padding: 20px;
}

/* CARD */
.card {
    background: #fff;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

/* BUTTONS */
button {
    padding: 8px 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.btn-primary { background: #2d89ef; color: white; }
.btn-primary:hover { background: #1b5fbf; }

.btn-success { background: #28a745; color: white; }
.btn-success:hover { background: #1f7a33; }

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
}

th {
    background: #f1f1f1;
}

th, td {
    padding: 12px;
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
    width: 420px;
    padding: 20px;
    border-radius: 10px;
}

input, select {
    width: 100%;
    padding: 8px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}
</style>

<div class="container">

<!-- HEADER CARD -->
<div class="card">
    <h2>Expenses</h2>

    <button class="btn-primary" onclick="openModal()">
        + Add Expense
    </button>
</div>

<!-- TABLE CARD -->
<div class="card">
<table>
    <tr>
        <th>ID</th>
        <th>Account</th>
        <th>Amount</th>
        <th>Description</th>
        <th>Date</th>
    </tr>

    <?php foreach ($expenses as $e): ?>
    <tr>
        <td><?= $e['id'] ?></td>
        <td>#<?= $e['account_id'] ?></td>
        <td>₱<?= number_format($e['amount'],2) ?></td>
        <td><?= $e['description'] ?></td>
        <td><?= $e['created_at'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</div>

</div>

<!-- MODAL -->
<div id="modal" class="modal">
    <div class="modal-content">

        <h3>Add Expense</h3>

        <form method="POST" action="/LoanManagement/public/index.php?url=expense/store">

            <label>Account</label>
            <select name="account_id" required>
                <?php foreach ($accounts as $a): ?>
                    <option value="<?= $a['id'] ?>">
                        <?= $a['account_name'] ?> (₱<?= number_format($a['balance'],2) ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Amount</label>
            <input type="number" name="amount" required>

            <label>Description</label>
            <input type="text" name="description" required>

            <button class="btn-success" type="submit">Save</button>
            <button type="button" onclick="closeModal()">Cancel</button>

        </form>

    </div>
</div>

<script>
function openModal() {
    document.getElementById('modal').classList.add('show');
}

function closeModal() {
    document.getElementById('modal').classList.remove('show');
}
</script>

<?php include __DIR__ . "/../layouts/footer.php"; ?>