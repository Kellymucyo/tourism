<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if destination ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: " . BASE_URL . "/pages/destinations.php");
    exit();
}

$destination_id = intval($_GET['id']);
$destination = getDestinationById($destination_id);

// If destination not found, redirect
if (!$destination) {
    header("Location: " . BASE_URL . "/pages/destinations.php");
    exit();
}

// Get reviews for this destination
$reviews = getDestinationReviews($destination_id);

// Calculate average rating
$avg_rating = 0;
if (!empty($reviews)) {
    $total_ratings = 0;
    foreach ($reviews as $review) {
        $total_ratings += $review['rating'];
    }
    $avg_rating = $total_ratings / count($reviews);
}

// Set page title
$pageTitle = $destination['name'] . " | Rwanda Tourism";

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $rating = intval($_POST['rating']);
        $comment = trim($_POST['comment']);
        
        if ($rating >= 1 && $rating <= 5 && !empty($comment)) {
            if (addReview($destination_id, $user_id, $rating, $comment)) {
                $_SESSION['review_success'] = "Thank you for your review!";
                header("Location: " . BASE_URL . "/pages/single_destination.php?id=$destination_id");
                exit();
            } else {
                $review_error = "Failed to submit review. Please try again.";
            }
        } else {
            $review_error = "Please provide both a rating and a comment.";
        }
    } else {
        $review_error = "You need to be logged in to submit a review.";
    }
}
?>

<?php include '../includes/header.php'; ?>

<!-- Destination Header -->
<div class="row mb-4">
    <div class="col-md-8">
        <h1><?php echo htmlspecialchars($destination['name']); ?></h1>
        <div class="d-flex align-items-center mb-2">
            <span class="badge bg-info me-2"><?php echo ucfirst($destination['category']); ?></span>
            <span class="text-muted"><i class="fas fa-map-marker-alt me-1"></i> <?php echo ucfirst($destination['district']); ?>, <?php echo ucfirst($destination['province']); ?> Province</span>
        </div>
        <?php if ($avg_rating > 0): ?>
            <div class="star-rating mb-2">
                <?php echo str_repeat('★', round($avg_rating)); ?>
                <span class="ms-1"><?php echo number_format($avg_rating, 1); ?> (<?php echo count($reviews); ?> reviews)</span>
            </div>
        <?php else: ?>
            <div class="text-muted mb-2">No reviews yet</div>
        <?php endif; ?>
    </div>
    <div class="col-md-4 text-md-end">
        <div class="d-inline-block me-2">
            <span class="fw-bold text-success fs-4">$<?php echo number_format($destination['entry_fee'], 2); ?></span>
            <span class="d-block text-muted">Entry Fee</span>
        </div>
        <a href="<?php echo BASE_URL; ?>/pages/contact.php?destination=<?php echo urlencode($destination['name']); ?>" class="btn btn-success btn-lg">Book a Visit</a>
    </div>
</div>

<!-- Destination Gallery -->
<div class="row mb-4">
    <div class="col-12">
        <div class="destination-gallery">
            <div class="main-image mb-3">
                <!-- Placeholder for main destination image - Replace with your image -->
                <img src="<?php echo BASE_URL; ?>/assets/images/destinations/<?php echo $destination['id']; ?>-1.jpg" class="img-fluid rounded" alt="<?php echo htmlspecialchars($destination['name']); ?>">
            </div>
            <?php if (!empty($destination['images'])): ?>
                <div class="thumbnail-row d-flex flex-wrap gap-2">
                    <?php foreach ($destination['images'] as $index => $image): ?>
                        <!-- Placeholder for thumbnail images - Replace with your images -->
                        <a href="<?php echo BASE_URL; ?>/assets/images/destinations/<?php echo $destination['id']; ?>-<?php echo $index + 1; ?>.jpg" data-lightbox="destination-gallery">
                            <img src="<?php echo BASE_URL; ?>/assets/images/destinations/<?php echo $destination['id']; ?>-<?php echo $index + 1; ?>.jpg" class="img-thumbnail" width="100" alt="<?php echo htmlspecialchars($destination['name']); ?>">
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Destination Content -->
<div class="row mb-5">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="card-title">About</h3>
                <p class="card-text"><?php echo nl2br(htmlspecialchars($destination['description'])); ?></p>
            </div>
        </div>
        
        <!-- Map Section -->
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="card-title">Location</h3>
                <div id="destinationMap" style="height: 400px; border-radius: 4px;"></div>
                <div class="mt-3">
                    <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo $destination['latitude']; ?>,<?php echo $destination['longitude']; ?>" target="_blank" class="btn btn-outline-success">
                        <i class="fas fa-directions me-1"></i> Get Directions
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Reviews Section -->
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Reviews</h3>
                
                <?php if (isset($_SESSION['review_success'])): ?>
                    <div class="alert alert-success"><?php echo $_SESSION['review_success']; unset($_SESSION['review_success']); ?></div>
                <?php endif; ?>
                
                <?php if (isset($review_error)): ?>
                    <div class="alert alert-danger"><?php echo $review_error; ?></div>
                <?php endif; ?>
                
                <!-- Review Form -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="review-form mb-4">
                        <h5>Write a Review</h5>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Your Rating</label>
                                <div class="rating-stars">
                                    <?php for ($i = 5; $i >= 1; $i--): ?>
                                        <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" <?php if ($i == 5) echo 'checked'; ?>>
                                        <label for="star<?php echo $i; ?>"><i class="fas fa-star"></i></label>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="comment" class="form-label">Your Review</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                            </div>
                            <button type="submit" name="submit_review" class="btn btn-success">Submit Review</button>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <a href="<?php echo BASE_URL; ?>/user/login.php" class="alert-link">Log in</a> to leave a review.
                    </div>
                <?php endif; ?>
                
                <!-- Reviews List -->
                <div class="reviews-list">
                    <?php if (empty($reviews)): ?>
                        <div class="alert alert-info">No reviews yet. Be the first to review!</div>
                    <?php else: ?>
                        <?php foreach ($reviews as $review): ?>
                            <div class="review-item mb-3 pb-3 border-bottom">
                                <div class="d-flex justify-content-between mb-2">
                                    <strong><?php echo $review['username'] ? htmlspecialchars($review['username']) : 'Anonymous'; ?></strong>
                                    <span class="text-warning"><?php echo str_repeat('★', $review['rating']); ?></span>
                                </div>
                                <p class="mb-1"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
                                <small class="text-muted"><?php echo date('M j, Y', strtotime($review['created_at'])); ?></small>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Quick Facts -->
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="card-title">Quick Facts</h3>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-tag me-2 text-success"></i> Category</span>
                        <span><?php echo ucfirst($destination['category']); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-map-marker-alt me-2 text-success"></i> Location</span>
                        <span><?php echo ucfirst($destination['district']); ?>, <?php echo ucfirst($destination['province']); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-money-bill-wave me-2 text-success"></i> Entry Fee</span>
                        <span>$<?php echo number_format($destination['entry_fee'], 2); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-star me-2 text-success"></i> Average Rating</span>
                        <span><?php echo $avg_rating > 0 ? number_format($avg_rating, 1) . ' (' . count($reviews) . ' reviews)' : 'No reviews yet'; ?></span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Nearby Attractions -->
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="card-title">Nearby Attractions</h3>
                <?php
                $nearby = getAllDestinations(null, $destination['province'], null);
                $nearby = array_filter($nearby, function($item) use ($destination) {
                    return $item['id'] != $destination['id'];
                });
                $nearby = array_slice($nearby, 0, 3);
                ?>
                
                <?php if (empty($nearby)): ?>
                    <div class="alert alert-info">No nearby attractions found.</div>
                <?php else: ?>
                    <div class="list-group">
                        <?php foreach ($nearby as $attraction): ?>
                            <a href="<?php echo BASE_URL; ?>/pages/single_destination.php?id=<?php echo $attraction['id']; ?>" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><?php echo htmlspecialchars($attraction['name']); ?></h6>
                                    <small><?php echo number_format($attraction['distance'], 1); ?> km</small>
                                </div>
                                <small class="text-muted"><?php echo ucfirst($attraction['category']); ?></small>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Contact Card -->
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Plan Your Visit</h3>
                <p>Need more information or want to book a guided tour?</p>
                <a href="<?php echo BASE_URL; ?>/pages/contact.php?destination=<?php echo urlencode($destination['name']); ?>" class="btn btn-success w-100 mb-2">
                    <i class="fas fa-envelope me-1"></i> Contact Us
                </a>
                <a href="<?php echo BASE_URL; ?>/pages/travel_tips.php" class="btn btn-outline-success w-100">
                    <i class="fas fa-info-circle me-1"></i> Travel Tips
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Map Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize map
    const map = L.map('destinationMap').setView([<?php echo $destination['latitude']; ?>, <?php echo $destination['longitude']; ?>], 13);
    
    // Add tile layer (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    // Add marker
    L.marker([<?php echo $destination['latitude']; ?>, <?php echo $destination['longitude']; ?>]).addTo(map)
        .bindPopup('<?php echo addslashes($destination['name']); ?>')
        .openPopup();
});
</script>

<!-- Lightbox CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<!-- Lightbox JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<style>
.rating-stars {
    direction: rtl;
    unicode-bidi: bidi-override;
}
.rating-stars input {
    display: none;
}
.rating-stars label {
    color: #ccc;
    font-size: 1.5rem;
    padding: 0 2px;
    cursor: pointer;
}
.rating-stars input:checked ~ label {
    color: #ffc107;
}
.rating-stars label:hover,
.rating-stars label:hover ~ label {
    color: #ffc107;
}
</style>

<?php include '../includes/footer.php'; ?>