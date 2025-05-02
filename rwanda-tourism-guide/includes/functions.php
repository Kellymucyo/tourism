<?php
require_once 'config.php';

/**
 * Get featured destinations
 */
function getFeaturedDestinations($limit = 6) {
    global $conn;
    
    $query = "SELECT d.*, 
              (SELECT image_path FROM destination_images WHERE destination_id = d.id AND is_featured = 1 LIMIT 1) as featured_image
              FROM destinations d 
              ORDER BY RAND() LIMIT ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $destinations = [];
    while($row = $result->fetch_assoc()) {
        $destinations[] = $row;
    }
    
    return $destinations;
}

/**
 * Get upcoming events
 */
function getUpcomingEvents($limit = 3) {
    global $conn;
    
    $query = "SELECT e.*, 
              (SELECT image_path FROM event_images WHERE event_id = e.id LIMIT 1) as event_image
              FROM events e 
              WHERE e.end_date >= CURDATE() 
              ORDER BY e.start_date ASC LIMIT ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $events = [];
    while($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
    
    return $events;
}

/**
 * Get latest blog posts
 */
function getLatestBlogPosts($limit = 3) {
    global $conn;
    
    $query = "SELECT b.*, 
              (SELECT image_path FROM blog_images WHERE blog_id = b.id LIMIT 1) as blog_image
              FROM blog_posts b 
              ORDER BY b.created_at DESC LIMIT ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $blogs = [];
    while($row = $result->fetch_assoc()) {
        $blogs[] = $row;
    }
    
    return $blogs;
}

/**
 * Get star rating for a destination
 */
function getStarRating($destination_id) {
    global $conn;
    
    $query = "SELECT AVG(rating) as avg_rating, COUNT(*) as review_count 
              FROM reviews 
              WHERE destination_id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $destination_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rating = $result->fetch_assoc();
    
    if ($rating['review_count'] == 0) {
        return '<small class="text-muted">No reviews yet</small>';
    }
    
    $fullStars = floor($rating['avg_rating']);
    $halfStar = ($rating['avg_rating'] - $fullStars) >= 0.5 ? 1 : 0;
    $emptyStars = 5 - $fullStars - $halfStar;
    
    $stars = str_repeat('<i class="fas fa-star text-warning"></i>', $fullStars);
    $stars .= $halfStar ? '<i class="fas fa-star-half-alt text-warning"></i>' : '';
    $stars .= str_repeat('<i class="far fa-star text-warning"></i>', $emptyStars);
    
    return $stars . ' <small>(' . $rating['review_count'] . ')</small>';
}

/**
 * Get all destinations with optional filtering
 */
function getAllDestinations($category = null, $province = null, $district = null) {
    global $conn;
    
    $query = "SELECT d.*, 
              (SELECT image_path FROM destination_images WHERE destination_id = d.id LIMIT 1) as destination_image,
              (SELECT AVG(rating) FROM reviews WHERE destination_id = d.id) as avg_rating
              FROM destinations d 
              WHERE 1=1";
    
    $params = [];
    $types = '';
    
    if ($category) {
        $query .= " AND d.category = ?";
        $params[] = $category;
        $types .= 's';
    }
    
    if ($province) {
        $query .= " AND d.province = ?";
        $params[] = $province;
        $types .= 's';
    }
    
    if ($district) {
        $query .= " AND d.district = ?";
        $params[] = $district;
        $types .= 's';
    }
    
    $query .= " ORDER BY d.name ASC";
    
    $stmt = $conn->prepare($query);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $destinations = [];
    while($row = $result->fetch_assoc()) {
        $destinations[] = $row;
    }
    
    return $destinations;
}

/**
 * Get single destination by ID
 */
function getDestinationById($id) {
    global $conn;
    
    $query = "SELECT d.*, 
              (SELECT GROUP_CONCAT(image_path) FROM destination_images WHERE destination_id = d.id) as images
              FROM destinations d 
              WHERE d.id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        return null;
    }
    
    $destination = $result->fetch_assoc();
    
    // Convert comma-separated images to array
    if ($destination['images']) {
        $destination['images'] = explode(',', $destination['images']);
    } else {
        $destination['images'] = [];
    }
    
    return $destination;
}

/**
 * Get reviews for a destination
 */
function getDestinationReviews($destination_id) {
    global $conn;
    
    $query = "SELECT r.*, u.username 
              FROM reviews r 
              LEFT JOIN users u ON r.user_id = u.id 
              WHERE r.destination_id = ? 
              ORDER BY r.created_at DESC";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $destination_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $reviews = [];
    while($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
    
    return $reviews;
}

/**
 * Add a new review
 */
function addReview($destination_id, $user_id, $rating, $comment) {
    global $conn;
    
    $query = "INSERT INTO reviews (destination_id, user_id, rating, comment) 
              VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiis", $destination_id, $user_id, $rating, $comment);
    
    return $stmt->execute();
}

/**
 * Get all events
 */
function getAllEvents() {
    global $conn;
    
    $query = "SELECT e.*, 
              (SELECT image_path FROM event_images WHERE event_id = e.id LIMIT 1) as event_image
              FROM events e 
              ORDER BY e.start_date ASC";
    
    $result = $conn->query($query);
    
    $events = [];
    while($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
    
    return $events;
}

/**
 * Get single event by ID
 */
function getEventById($id) {
    global $conn;
    
    $query = "SELECT e.*, 
              (SELECT GROUP_CONCAT(image_path) FROM event_images WHERE event_id = e.id) as images
              FROM events e 
              WHERE e.id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        return null;
    }
    
    $event = $result->fetch_assoc();
    
    // Convert comma-separated images to array
    if ($event['images']) {
        $event['images'] = explode(',', $event['images']);
    } else {
        $event['images'] = [];
    }
    
    return $event;
}

/**
 * Get all blog posts
 */
function getAllBlogPosts() {
    global $conn;
    
    $query = "SELECT b.*, 
              (SELECT image_path FROM blog_images WHERE blog_id = b.id LIMIT 1) as blog_image
              FROM blog_posts b 
              ORDER BY b.created_at DESC";
    
    $result = $conn->query($query);
    
    $blogs = [];
    while($row = $result->fetch_assoc()) {
        $blogs[] = $row;
    }
    
    return $blogs;
}

/**
 * Get single blog post by ID
 */
function getBlogPostById($id) {
    global $conn;
    
    $query = "SELECT b.*, 
              (SELECT GROUP_CONCAT(image_path) FROM blog_images WHERE blog_id = b.id) as images
              FROM blog_posts b 
              WHERE b.id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        return null;
    }
    
    $blog = $result->fetch_assoc();
    
    // Convert comma-separated images to array
    if ($blog['images']) {
        $blog['images'] = explode(',', $blog['images']);
    } else {
        $blog['images'] = [];
    }
    
    return $blog;
}

/**
 * User registration
 */
function registerUser($username, $email, $password) {
    global $conn;
    
    // Check if username or email already exists
    $query = "SELECT id FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return false; // User already exists
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user
    $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    
    return $stmt->execute();
}

/**
 * User login
 */
function loginUser($username, $password) {
    global $conn;
    
    $query = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        return false; // User not found
    }
    
    $user = $result->fetch_assoc();
    
    // Verify password
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return true;
    }
    
    return false; // Invalid password
}

/**
 * Get user by ID
 */
function getUserById($id) {
    global $conn;
    
    $query = "SELECT id, username, email, created_at FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        return null;
    }
    
    return $result->fetch_assoc();
}

/**
 * Submit contact form
 */
function submitContactForm($name, $email, $subject, $message) {
    global $conn;
    
    $query = "INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        error_log("Error preparing statement: " . $conn->error);
        return false;
    }
    
    $stmt->bind_param("ssss", $name, $email, $subject, $message);
    if (!$stmt->execute()) {
        error_log("Error executing statement: " . $stmt->error);
        return false;
    }
    
    return true;
}