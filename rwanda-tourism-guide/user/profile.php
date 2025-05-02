<?php
require_once __DIR__ . '/../includes/config.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "/user/login.php");
    exit();
}

// Get user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    
    // Validate and update
    if (!empty($username) && !empty($email)) {
        $update = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $update->bind_param("ssi", $username, $email, $_SESSION['user_id']);
        
        if ($update->execute()) {
            $_SESSION['success'] = $translations['profile_updated'] ?? 'Profile updated successfully!';
            header("Location: " . BASE_URL . "/user/profile.php");
            exit();
        }
    }
}
?>

<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="container mt-5">
    <h2><?= $translations['edit_profile'] ?? 'Edit Profile' ?></h2>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    
    <form method="POST">
        <div class="mb-3">
            <label class="form-label"><?= $translations['username'] ?? 'Username' ?></label>
            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label"><?= $translations['email'] ?? 'Email' ?></label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        
        <button type="submit" class="btn btn-success">
            <?= $translations['save_changes'] ?? 'Save Changes' ?>
        </button>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>