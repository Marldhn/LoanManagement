<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<div class="container">
    <h2>My Profile</h2>

    <?php $user = $_SESSION['user']; ?>

    <p><strong>Name:</strong>
        <?= is_array($user) ? ($user['name'] ?? '') : $user ?>
    </p>

    <p><strong>Role:</strong>
        <?= is_array($user) ? ($user['role'] ?? '') : '' ?>
    </p>
</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>