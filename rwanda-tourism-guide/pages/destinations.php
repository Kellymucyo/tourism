<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Get filter parameters
$category = isset($_GET['category']) ? $_GET['category'] : null;
$province = isset($_GET['province']) ? $_GET['province'] : null;
$district = isset($_GET['district']) ? $_GET['district'] : null;

// Get filtered destinations
$destinations = getAllDestinations($category, $province, $district);

// Set page title based on filters
if ($category) {
    $pageTitle = ucfirst($category) . " Destinations in Rwanda";
} elseif ($province) {
    $pageTitle = "Destinations in " . ucfirst($province) . " Province";
} elseif ($district) {
    $pageTitle = "Destinations in " . ucfirst($district) . " District";
} else {
    $pageTitle = "All Tourist Destinations in Rwanda";
}
?>

<?php include '../includes/header.php'; ?>

<!-- Destinations Header -->
<div class="row mb-4">
    <div class="col-md-8">
        <h1><?php echo $pageTitle; ?></h1>
        <p class="lead">Explore Rwanda's incredible tourist attractions</p>
    </div>
    <div class="col-md-4 text-md-end">
        <div class="dropdown d-inline-block me-2">
            <button class="btn btn-outline-success dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                <i class="fas fa-filter"></i> Filter
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><h6 class="dropdown-header">By Category</h6></li>
                <li><a class="dropdown-item" href="?category=park">National Parks</a></li>
                <li><a class="dropdown-item" href="?category=museum">Museums</a></li>
                <li><a class="dropdown-item" href="?category=cultural">Cultural Sites</a></li>
                <li><a class="dropdown-item" href="?category=adventure">Adventure</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><h6 class="dropdown-header">By Province</h6></li>
                <li><a class="dropdown-item" href="?province=kigali">Kigali City</a></li>
                <li><a class="dropdown-item" href="?province=northern">Northern</a></li>
                <li><a class="dropdown-item" href="?province=southern">Southern</a></li>
                <li><a class="dropdown-item" href="?province=eastern">Eastern</a></li>
                <li><a class="dropdown-item" href="?province=western">Western</a></li>
            </ul>
        </div>
        <a href="<?php echo BASE_URL; ?>/pages/destinations.php" class="btn btn-success">Reset Filters</a>
    </div>
</div>

<!-- Destinations Grid -->
<div class="row">
    <?php if (empty($destinations)): ?>
        <div class="col-12">
            <div class="alert alert-info">No destinations found matching your criteria.</div>
        </div>
    <?php else: ?>
        <?php foreach($destinations as $destination): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <!-- Placeholder for destination image - Replace with your image -->
                <img src="<?php echo BASE_URL; ?>/assets/images/destinations/<?php echo $destination['id']; ?>.jpg" class="card-img-top" alt="<?php echo htmlspecialchars($destination['name']); ?>" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($destination['name']); ?></h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-info"><?php echo ucfirst($destination['category']); ?></span>
                        <span class="text-success fw-bold">$<?php echo number_format($destination['entry_fee'], 2); ?></span>
                    </div>
                    <p class="card-text"><?php echo substr(htmlspecialchars($destination['description']), 0, 100); ?>...</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted"><i class="fas fa-map-marker-alt"></i> <?php echo ucfirst($destination['district']); ?></span>
                        <?php if ($destination['avg_rating']): ?>
                            <span class="text-warning">
                                <?php echo str_repeat('★', round($destination['avg_rating'])); ?>
                                (<?php echo number_format($destination['avg_rating'], 1); ?>)
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <a href="<?php echo BASE_URL; ?>/pages/single_destination.php?id=<?php echo $destination['id']; ?>" class="btn btn-success btn-sm">Explore</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>