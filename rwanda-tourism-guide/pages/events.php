<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Get all upcoming events
$events = getAllEvents();

// Separate upcoming and past events
$upcomingEvents = [];
$pastEvents = [];

foreach ($events as $event) {
    if (strtotime($event['end_date']) >= time()) {
        $upcomingEvents[] = $event;
    } else {
        $pastEvents[] = $event;
    }
}

$pageTitle = "Events & Festivals in Rwanda";
?>

<?php include '../includes/header.php'; ?>

<!-- Events Header -->
<div class="row mb-4">
    <div class="col-md-8">
        <h1>Events & Festivals</h1>
        <p class="lead">Experience Rwanda's vibrant cultural scene</p>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="<?php echo BASE_URL; ?>/pages/contact.php" class="btn btn-success">Submit Your Event</a>
    </div>
</div>

<!-- Upcoming Events -->
<section class="upcoming-events mb-5">
    <h2 class="mb-4">Upcoming Events</h2>
    
    <?php if (empty($upcomingEvents)): ?>
        <div class="alert alert-info">No upcoming events scheduled. Check back later!</div>
    <?php else: ?>
        <div class="row">
            <?php foreach($upcomingEvents as $event): ?>
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <!-- Placeholder for event image - Replace with your image -->
                            <img src="<?php echo BASE_URL; ?>/assets/images/events/<?php echo $event['id']; ?>.jpg" class="img-fluid rounded-start h-100" alt="<?php echo htmlspecialchars($event['title']); ?>" style="object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                                <p class="card-text"><i class="fas fa-calendar-alt me-2"></i>
                                    <?php echo date('M j, Y', strtotime($event['start_date'])); ?>
                                    <?php if($event['end_date'] != $event['start_date']): ?>
                                        - <?php echo date('M j, Y', strtotime($event['end_date'])); ?>
                                    <?php endif; ?>
                                </p>
                                <p class="card-text"><i class="fas fa-map-marker-alt me-2"></i><?php echo htmlspecialchars($event['location']); ?></p>
                                <p class="card-text"><?php echo substr(htmlspecialchars($event['description']), 0, 100); ?>...</p>
                                <a href="<?php echo BASE_URL; ?>/pages/events.php#event-<?php echo $event['id']; ?>" class="btn btn-success btn-sm">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<!-- Event Details (for anchor links) -->
<?php if (!empty($upcomingEvents)): ?>
    <section class="event-details mb-5">
        <h2 class="mb-4">Event Details</h2>
        <div class="accordion" id="eventsAccordion">
            <?php foreach($upcomingEvents as $index => $event): ?>
            <div class="accordion-item" id="event-<?php echo $event['id']; ?>">
                <h3 class="accordion-header">
                    <button class="accordion-button <?php echo $index > 0 ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $event['id']; ?>">
                        <?php echo htmlspecialchars($event['title']); ?>
                    </button>
                </h3>
                <div id="collapse<?php echo $event['id']; ?>" class="accordion-collapse collapse <?php echo $index === 0 ? 'show' : ''; ?>" data-bs-parent="#eventsAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <!-- Placeholder for event image - Replace with your image -->
                                <img src="<?php echo BASE_URL; ?>/assets/images/events/<?php echo $event['id']; ?>.jpg" class="img-fluid rounded" alt="<?php echo htmlspecialchars($event['title']); ?>">
                            </div>
                            <div class="col-md-8">
                                <h4>Event Information</h4>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item">
                                        <strong>Date:</strong> <?php echo date('l, F j, Y', strtotime($event['start_date'])); ?>
                                        <?php if($event['end_date'] != $event['start_date']): ?>
                                            to <?php echo date('l, F j, Y', strtotime($event['end_date'])); ?>
                                        <?php endif; ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></li>
                                    <li class="list-group-item">
                                        <strong>Category:</strong> Cultural Festival</li>
                                </ul>
                                
                                <h4>Description</h4>
                                <p><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="<?php echo BASE_URL; ?>/pages/contact.php?event=<?php echo urlencode($event['title']); ?>" class="btn btn-success">Get Tickets</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>

<!-- Past Events -->
<?php if (!empty($pastEvents)): ?>
    <section class="past-events">
        <h2 class="mb-4">Past Events</h2>
        <div class="row">
            <?php foreach($pastEvents as $event): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <!-- Placeholder for event image - Replace with your image -->
                    <img src="<?php echo BASE_URL; ?>/assets/images/events/<?php echo $event['id']; ?>.jpg" class="card-img-top" alt="<?php echo htmlspecialchars($event['title']); ?>" style="height: 180px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                        <p class="card-text"><i class="fas fa-calendar-alt me-2"></i><?php echo date('M j, Y', strtotime($event['start_date'])); ?></p>
                        <p class="card-text"><i class="fas fa-map-marker-alt me-2"></i><?php echo htmlspecialchars($event['location']); ?></p>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="<?php echo BASE_URL; ?>/pages/events.php#event-<?php echo $event['id']; ?>" class="btn btn-outline-success btn-sm">Details</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>