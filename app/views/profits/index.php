<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<div class="container">

<h2>Profit Management</h2>

<h3>Total Profit: ₱<?= number_format($totalProfit,2) ?></h3>

<button onclick="document.getElementById('modal').style.display='block'">
    + Add Profit
</button>

<table>
    <tr>
        <th>Source</th>
        <th>Type</th>
        <th>Amount</th>
        <th>Date</th>
    </tr>

    <?php foreach ($profits as $p): ?>
    <tr>
        <td><?= $p['source'] ?></td>
        <td><?= $p['type'] ?></td>
        <td>₱<?= number_format($p['amount'],2) ?></td>
        <td><?= $p['created_at'] ?></td>
    </tr>
    <?php endforeach; ?>

</table>

</div>

<!-- MODAL -->
<div id="modal" style="display:none;">
    <form method="POST" action="/LoanManagement/public/index.php?url=profit/store">

        <input type="text" name="source" placeholder="Source (e.g. Shop, Business)" required>
        <input type="number" name="amount" placeholder="Amount" required>

        <button type="submit">Save</button>
        <button type="button" onclick="this.parentElement.parentElement.style.display='none'">
            Cancel
        </button>

    </form>
</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>