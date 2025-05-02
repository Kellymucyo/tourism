<?php
require_once __DIR__ . '/includes/config.php';

// Get featured content
$featuredDestinationsQuery = "SELECT * FROM destinations WHERE is_featured = 1 LIMIT 6";
$featuredDestinations = $conn->query($featuredDestinationsQuery);
if (!$featuredDestinations) {
    die("Query failed: " . $conn->error);
}

$upcomingEventsQuery = "SELECT * FROM events WHERE start_date >= CURDATE() ORDER BY start_date LIMIT 3";
$upcomingEvents = $conn->query($upcomingEventsQuery);
if (!$upcomingEvents) {
    die("Query failed: " . $conn->error);
}
?>

<?php require_once __DIR__ . '/includes/header.php'; ?>

<main class="container">
    <!-- Hero Section -->
    <section class="hero-section text-center py-5 mb-5">
        <h1 class="display-4"><?= $translations['welcome_title'] ?? 'Discover Rwanda' ?></h1>
        <p class="lead"><?= $translations['welcome_subtitle'] ?? 'Land of a Thousand Hills' ?></p>
        <a href="<?= BASE_URL ?>/pages/destinations.php" class="btn btn-success btn-lg mt-3">
            <?= $translations['explore_button'] ?? 'Explore Now' ?>
        </a>
    </section>

    <!-- Featured Destinations -->
    <section class="mb-5">
        <h2 class="mb-4"><?= $translations['featured_destinations'] ?? 'Featured Destinations' ?></h2>
        <div class="row">
            <?php while ($destination = $featuredDestinations->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="<?= BASE_URL ?>/assets/images/destinations/<?= $destination['id'] ?>.jpg" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($destination['name']) ?>">
                        <div class="card-body">
                            <h3><?= htmlspecialchars($destination['name']) ?></h3>
                            <p><?= htmlspecialchars(substr($destination['description'], 0, 100)) ?>...</p>
                            <a href="<?= BASE_URL ?>/pages/single_destination.php?id=<?= $destination['id'] ?>" 
                               class="btn btn-sm btn-success">
                                <?= $translations['view_details'] ?? 'View Details' ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
