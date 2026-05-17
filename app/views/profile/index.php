<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f5f6fa;
}

.container {
    padding: 20px;
}

/* PROFILE CARD */
.profile-card {
    background: white;
    max-width: 500px;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.profile-card h2 {
    margin-bottom: 20px;
    color: #2c3e50;
}

/* PROFILE ITEM */
.profile-item {
    margin-bottom: 15px;
}

.profile-label {
    font-size: 13px;
    color: #888;
    margin-bottom: 5px;
}

.profile-value {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    background: #f7f7f7;
    padding: 10px;
    border-radius: 8px;
}

/* BADGE */
.role-badge {
    display: inline-block;
    background: #2d89ef;
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: bold;
}
</style>

<div class="container">

    <div class="profile-card">

        <h2>My Profile</h2>

        <?php $user = $_SESSION['user']; ?>

        <div class="profile-item">
            <div class="profile-label">Name</div>

            <div class="profile-value">
                <?= is_array($user) ? ($user['name'] ?? '') : $user ?>
            </div>
        </div>

        <div class="profile-item">
            <div class="profile-label">Role</div>

            <div class="profile-value">
                <span class="role-badge">
                    <?= is_array($user) ? ($user['role'] ?? '') : $_SESSION['role'] ?>
                </span>
            </div>
        </div>

    </div>

</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>