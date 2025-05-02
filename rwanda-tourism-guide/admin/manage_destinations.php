<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';

// Redirect if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$pageTitle = "Manage Destinations | Rwanda Tourism";

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_destination'])) {
        // Add new destination
        $name = trim($_POST['name']);
        $province = trim($_POST['province']);
        $district = trim($_POST['district']);
        $category = trim($_POST['category']);
        $description = trim($_POST['description']);
        $entry_fee = floatval($_POST['entry_fee']);
        $latitude = floatval($_POST['latitude']);
        $longitude = floatval($_POST['longitude']);
        
        $query = "INSERT INTO destinations (name, province, district, category, description, entry_fee, latitude, longitude) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssdss", $name, $province, $district, $category, $description, $entry_fee, $latitude, $longitude);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Destination added successfully!";
            header("Location: manage_destinations.php");
            exit();
        } else {
            $error = "Failed to add destination: " . $conn->error;
        }
    } elseif (isset($_POST['update_destination'])) {
        // Update existing destination
        $id = intval($_POST['id']);
        $name = trim($_POST['name']);
        $province = trim($_POST['province']);
        $district = trim($_POST['district']);
        $category = trim($_POST['category']);
        $description = trim($_POST['description']);
        $entry_fee = floatval($_POST['entry_fee']);
        $latitude = floatval($_POST['latitude']);
        $longitude = floatval($_POST['longitude']);
        
        $query = "UPDATE destinations SET 
                  name = ?, province = ?, district = ?, category = ?, 
                  description = ?, entry_fee = ?, latitude = ?, longitude = ? 
                  WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssdssi", $name, $province, $district, $category, $description, $entry_fee, $latitude, $longitude, $id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Destination updated successfully!";
            header("Location: manage_destinations.php");
            exit();
        } else {
            $error = "Failed to update destination: " . $conn->error;
        }
    } elseif (isset($_POST['delete_destination'])) {
        // Delete destination
        $id = intval($_POST['id']);
        
        $query = "DELETE FROM destinations WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Destination deleted successfully!";
            header("Location: manage_destinations.php");
            exit();
        } else {
            $error = "Failed to delete destination: " . $conn->error;
        }
    }
}

// Get all destinations
$destinations = $conn->query("SELECT * FROM destinations ORDER BY name ASC");

// Get destination for editing if ID is provided
$editDestination = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM destinations WHERE id = $id");
    if ($result->num_rows > 0) {
        $editDestination = $result->fetch_assoc();
    }
}
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
                            <a class="nav-link active" href="manage_destinations.php">
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
                    <h1 class="h2">Manage Destinations</h1>
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
                
                <!-- Add/Edit Form -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo $editDestination ? 'Edit Destination' : 'Add New Destination'; ?></h3>
                        <form method="POST">
                            <?php if ($editDestination): ?>
                                <input type="hidden" name="id" value="<?php echo $editDestination['id']; ?>">
                            <?php endif; ?>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required 
                                               value="<?php echo $editDestination ? htmlspecialchars($editDestination['name']) : ''; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="province" class="form-label">Province</label>
                                        <select class="form-select" id="province" name="province" required>
                                            <option value="">Select Province</option>
                                            <option value="kigali" <?php echo ($editDestination && $editDestination['province'] === 'kigali') ? 'selected' : ''; ?>>Kigali City</option>
                                            <option value="northern" <?php echo ($editDestination && $editDestination['province'] === 'northern') ? 'selected' : ''; ?>>Northern Province</option>
                                            <option value="southern" <?php echo ($editDestination && $editDestination['province'] === 'southern') ? 'selected' : ''; ?>>Southern Province</option>
                                            <option value="eastern" <?php echo ($editDestination && $editDestination['province'] === 'eastern') ? 'selected' : ''; ?>>Eastern Province</option>
                                            <option value="western" <?php echo ($editDestination && $editDestination['province'] === 'western') ? 'selected' : ''; ?>>Western Province</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="district" class="form-label">District</label>
                                        <input type="text" class="form-control" id="district" name="district" required 
                                               value="<?php echo $editDestination ? htmlspecialchars($editDestination['district']) : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Category</label>
                                        <select class="form-select" id="category" name="category" required>
                                            <option value="">Select Category</option>
                                            <option value="park" <?php echo ($editDestination && $editDestination['category'] === 'park') ? 'selected' : ''; ?>>National Park</option>
                                            <option value="museum" <?php echo ($editDestination && $editDestination['category'] === 'museum') ? 'selected' : ''; ?>>Museum</option>
                                            <option value="cultural" <?php echo ($editDestination && $editDestination['category'] === 'cultural') ? 'selected' : ''; ?>>Cultural Site</option>
                                            <option value="adventure" <?php echo ($editDestination && $editDestination['category'] === 'adventure') ? 'selected' : ''; ?>>Adventure</option>
                                            <option value="other" <?php echo ($editDestination && $editDestination['category'] === 'other') ? 'selected' : ''; ?>>Other</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="entry_fee" class="form-label">Entry Fee (USD)</label>
                                        <input type="number" step="0.01" class="form-control" id="entry_fee" name="entry_fee" required 
                                               value="<?php echo $editDestination ? htmlspecialchars($editDestination['entry_fee']) : '0'; ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $editDestination ? htmlspecialchars($editDestination['description']) : ''; ?></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="latitude" class="form-label">Latitude</label>
                                        <input type="text" class="form-control" id="latitude" name="latitude" required 
                                               value="<?php echo $editDestination ? htmlspecialchars($editDestination['latitude']) : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="longitude" class="form-label">Longitude</label>
                                        <input type="text" class="form-control" id="longitude" name="longitude" required 
                                               value="<?php echo $editDestination ? htmlspecialchars($editDestination['longitude']) : ''; ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <?php if ($editDestination): ?>
                                    <button type="submit" name="update_destination" class="btn btn-success">Update Destination</button>
                                    <a href="manage_destinations.php" class="btn btn-outline-secondary">Cancel</a>
                                <?php else: ?>
                                    <button type="submit" name="add_destination" class="btn btn-success">Add Destination</button>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Destinations Table -->
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">All Destinations</h3>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Location</th>
                                        <th>Category</th>
                                        <th>Entry Fee</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($destinations->num_rows > 0): ?>
                                        <?php while($destination = $destinations->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($destination['name']); ?></td>
                                                <td><?php echo ucfirst($destination['district']); ?>, <?php echo ucfirst($destination['province']); ?></td>
                                                <td><?php echo ucfirst($destination['category']); ?></td>
                                                <td>$<?php echo number_format($destination['entry_fee'], 2); ?></td>
                                                <td>
                                                    <a href="manage_destinations.php?action=edit&id=<?php echo $destination['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form method="POST" style="display: inline;">
                                                        <input type="hidden" name="id" value="<?php echo $destination['id']; ?>">
                                                        <button type="submit" name="delete_destination" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this destination?')">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No destinations found</td>
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