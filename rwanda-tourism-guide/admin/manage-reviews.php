<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';

// Redirect if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$pageTitle = "Manage Reviews | Rwanda Tourism";

// Handle review deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_review'])) {
    $id = intval($_POST['id']);
    
    $query = "DELETE FROM reviews WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Review deleted successfully!";
        header("Location: manage_reviews.php");
        exit();
    } else {
        $error = "Failed to delete review: " . $conn->error;
    }
}

// Get all reviews with destination and user info
$reviews = $conn->query("
    SELECT r.*, d.name as destination_name, u.username 
    FROM reviews r 
    LEFT JOIN destinations d ON r.destination_id = d.id 
    LEFT JOIN users u ON r.user_id = u.id 
    ORDER BY r.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #212529;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar bg-dark collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <img src="<?php echo BASE_URL; ?>/assets/images/logo-white.png" alt="Rwanda Tourism" height="40">
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_destinations.php">
                                <i class="fas fa-map-marked-alt me-2"></i> Destinations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="manage_reviews.php">
                                <i class="fas fa-star me-2"></i> Reviews
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_events.php">
                                <i class="fas fa-calendar-alt me-2"></i> Events
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_users.php">
                                <i class="fas fa-users me-2"></i> Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_blog.php">
                                <i class="fas fa-blog me-2"></i> Blog Posts
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/index.php" target="_blank">
                                <i class="fas fa-external-link-alt me-2"></i> View Site
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manage Reviews</h1>
                    <button class="btn btn-link d-md-none" type="button" data-bs-toggle="collapse" data-bs-target=".sidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-success"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
                <?php endif; ?>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <!-- Reviews Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Destination</th>
                                        <th>User</th>
                                        <th>Rating</th>
                                        <th>Comment</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($reviews->num_rows > 0): ?>
                                        <?php while($review = $reviews->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($review['destination_name']); ?></td>
                                                <td><?php echo $review['username'] ? htmlspecialchars($review['username']) : 'Anonymous'; ?></td>
                                                <td>
                                                    <span class="text-warning"><?php echo str_repeat('★', $review['rating']); ?></span>
                                                </td>
                                                <td><?php echo substr(htmlspecialchars($review['comment']), 0, 50); ?>...</td>
                                                <td><?php echo date('M j, Y', strtotime($review['created_at'])); ?></td>
                                                <td>
                                                    <form method="POST" style="display: inline;">
                                                        <input type="hidden" name="id" value="<?php echo $review['id']; ?>">
                                                        <button type="submit" name="delete_review" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this review?')">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No reviews found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>