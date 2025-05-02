<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';

// Redirect if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$pageTitle = "Admin Dashboard | Rwanda Tourism";

// Get counts for dashboard
$destinations_count = $conn->query("SELECT COUNT(*) FROM destinations")->fetch_row()[0];
$reviews_count = $conn->query("SELECT COUNT(*) FROM reviews")->fetch_row()[0];
$events_count = $conn->query("SELECT COUNT(*) FROM events")->fetch_row()[0];
$users_count = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
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
        .stat-card {
            border-left: 4px solid #198754;
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
                            <a class="nav-link active" href="dashboard.php">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_destinations.php">
                                <i class="fas fa-map-marked-alt me-2"></i> Destinations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_reviews.php">
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
                    <h1 class="h2">Dashboard</h1>
                    <button class="btn btn-link d-md-none" type="button" data-bs-toggle="collapse" data-bs-target=".sidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                
                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-muted">Destinations</h6>
                                        <h3><?php echo $destinations_count; ?></h3>
                                    </div>
                                    <div class="icon-circle bg-success text-white">
                                        <i class="fas fa-map-marked-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-muted">Reviews</h6>
                                        <h3><?php echo $reviews_count; ?></h3>
                                    </div>
                                    <div class="icon-circle bg-success text-white">
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-muted">Events</h6>
                                        <h3><?php echo $events_count; ?></h3>
                                    </div>
                                    <div class="icon-circle bg-success text-white">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-muted">Users</h6>
                                        <h3><?php echo $users_count; ?></h3>
                                    </div>
                                    <div class="icon-circle bg-success text-white">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Activity -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Recent Destinations</h5>
                                <?php
                                $recent_destinations = $conn->query("SELECT * FROM destinations ORDER BY created_at DESC LIMIT 5");
                                if ($recent_destinations->num_rows > 0): ?>
                                    <div class="list-group">
                                        <?php while($destination = $recent_destinations->fetch_assoc()): ?>
                                            <a href="manage_destinations.php?action=edit&id=<?php echo $destination['id']; ?>" class="list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h6 class="mb-1"><?php echo htmlspecialchars($destination['name']); ?></h6>
                                                    <small><?php echo date('M j', strtotime($destination['created_at'])); ?></small>
                                                </div>
                                                <small class="text-muted"><?php echo ucfirst($destination['category']); ?></small>
                                            </a>
                                        <?php endwhile; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info">No destinations found.</div>
                                <?php endif; ?>
                                <a href="manage_destinations.php" class="btn btn-sm btn-outline-success mt-3">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Recent Reviews</h5>
                                <?php
                                $recent_reviews = $conn->query("SELECT r.*, d.name as destination_name 
                                                              FROM reviews r 
                                                              JOIN destinations d ON r.destination_id = d.id 
                                                              ORDER BY r.created_at DESC LIMIT 5");
                                if ($recent_reviews->num_rows > 0): ?>
                                    <div class="list-group">
                                        <?php while($review = $recent_reviews->fetch_assoc()): ?>
                                            <div class="list-group-item">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h6 class="mb-1"><?php echo htmlspecialchars($review['destination_name']); ?></h6>
                                                    <span class="text-warning"><?php echo str_repeat('★', $review['rating']); ?></span>
                                                </div>
                                                <p class="mb-1"><?php echo substr(htmlspecialchars($review['comment']), 0, 50); ?>...</p>
                                                <small class="text-muted"><?php echo date('M j', strtotime($review['created_at'])); ?></small>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info">No reviews found.</div>
                                <?php endif; ?>
                                <a href="manage_reviews.php" class="btn btn-sm btn-outline-success mt-3">View All</a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .icon-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</body>
</html>