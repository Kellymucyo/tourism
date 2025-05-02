<?php
require_once __DIR__ . '/../includes/config.php';

// Redirect logged-in users
if (isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL);
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate inputs
    if (!empty($username) && !empty($password)) {
        // Check credentials
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Regenerate session ID for security
                session_regenerate_id(true);
                
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                
                // Redirect to home or intended page
                $redirect = $_SESSION['redirect_after_login'] ?? BASE_URL;
                unset($_SESSION['redirect_after_login']);
                header("Location: " . $redirect);
                exit();
            }
        }
        
        // If we get here, credentials were invalid
        $error = $translations['login_error'] ?? 'Invalid username or password';
    } else {
        $error = $translations['login_empty'] ?? 'Please enter both username and password';
    }
}
?>

<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">
                        <?= $translations['login_title'] ?? 'Login' ?>
                    </h2>
                    
                    <?php if (isset($_SESSION['register_success'])): ?>
                        <div class="alert alert-success">
                            <?= $_SESSION['register_success'] ?>
                        </div>
                        <?php unset($_SESSION['register_success']); ?>
                    <?php endif; ?>
                    
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <?= $error ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="<?= BASE_URL ?>/user/login.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">
                                <?= $translations['username'] ?? 'Username' ?>
                            </label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <?= $translations['password'] ?? 'Password' ?>
                            </label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                <?= $translations['login_button'] ?? 'Login' ?>
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-3 text-center">
                        <a href="<?= BASE_URL ?>/user/register.php">
                            <?= $translations['register_link'] ?? 'Create an account' ?>
                        </a>
                        <span class="mx-2">•</span>
                        <a href="<?= BASE_URL ?>/user/forgot_password.php">
                            <?= $translations['forgot_password'] ?? 'Forgot password?' ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>