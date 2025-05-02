<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

$pageTitle = "Contact Us | Rwanda Tourism";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);
    
    // Basic validation
    $errors = [];
    if (empty($name)) $errors[] = "Name is required";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
    if (empty($subject)) $errors[] = "Subject is required";
    if (empty($message)) $errors[] = "Message is required";
    
    if (empty($errors)) {
        if (submitContactForm($name, $email, $subject, $message)) {
            $_SESSION['contact_success'] = "Thank you for your message! We'll get back to you soon.";
            header("Location: " . BASE_URL . "/pages/contact.php");
            exit();
        } else {
            $error = "Failed to send message. Please try again.";
        }
    }
}

// Pre-fill subject if coming from a destination/event
$prefill_subject = '';
if (isset($_GET['destination'])) {
    $prefill_subject = "Inquiry about " . $_GET['destination'];
} elseif (isset($_GET['event'])) {
    $prefill_subject = "Inquiry about " . $_GET['event'];
} elseif (isset($_GET['subject'])) {
    $prefill_subject = $_GET['subject'];
}
?>

<?php include '../includes/header.php'; ?>

<!-- Contact Header -->
<div class="row mb-4">
    <div class="col-12">
        <h1>Contact Us</h1>
        <p class="lead">Have questions or need more information? Get in touch!</p>
    </div>
</div>

<!-- Contact Content -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="card-title">Send Us a Message</h2>
                
                <?php if (isset($_SESSION['contact_success'])): ?>
                    <div class="alert alert-success"><?php echo $_SESSION['contact_success']; unset($_SESSION['contact_success']); ?></div>
                <?php endif; ?>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $err): ?>
                                <li><?php echo $err; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" required value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" required value="<?php echo isset($subject) ? htmlspecialchars($subject) : $prefill_subject; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Your Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Send Message</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="card-title">Contact Information</h2>
                
                <div class="contact-info">
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <i class="fas fa-map-marker-alt fa-2x text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5>Address</h5>
                            <p>Rwanda Development Board<br>
                            Tourism Department<br>
                            KG 9 Avenue, Kigali<br>
                            Rwanda</p>
                        </div>
                    </div>
                    
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <i class="fas fa-phone-alt fa-2x text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5>Phone</h5>
                            <p>+250 787 123 456<br>
                            Mon-Fri: 8:00 AM - 5:00 PM</p>
                        </div>
                    </div>
                    
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <i class="fas fa-envelope fa-2x text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5>Email</h5>
                            <p>tourism@rdb.rw<br>
                            info@visitrwanda.com</p>
                        </div>
                    </div>
                    
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock fa-2x text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5>Office Hours</h5>
                            <p>Monday - Friday: 8:00 AM - 5:00 PM<br>
                            Saturday: 9:00 AM - 1:00 PM<br>
                            Sunday: Closed</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Map Section -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Our Location</h2>
                <div id="contactMap" style="height: 400px; border-radius: 4px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Map Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize map (RDB headquarters coordinates)
    const map = L.map('contactMap').setView([-1.9576, 30.1124], 15);
    
    // Add tile layer (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    // Add marker
    L.marker([-1.9576, 30.1124]).addTo(map)
        .bindPopup('Rwanda Development Board<br>Tourism Department')
        .openPopup();
});
</script>

<?php include '../includes/footer.php'; ?>