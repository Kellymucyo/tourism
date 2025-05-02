<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Get all blog posts
$blogPosts = getAllBlogPosts();

$pageTitle = "Rwanda Travel Blog";
?>

<?php include '../includes/header.php'; ?>

<!-- Blog Header -->
<div class="row mb-4">
    <div class="col-md-8">
        <h1>Rwanda Travel Blog</h1>
        <p class="lead">Stories, tips, and guides from locals and travelers</p>
    </div>
    <div class="col-md-4 text-md-end">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="<?php echo BASE_URL; ?>/pages/contact.php?subject=Blog+Submission" class="btn btn-success">Submit a Story</a>
        <?php else: ?>
            <a href="<?php echo BASE_URL; ?>/user/login.php" class="btn btn-success">Log in to Submit</a>
        <?php endif; ?>
    </div>
</div>

<!-- Blog Posts -->
<div class="row">
    <?php if (empty($blogPosts)): ?>
        <div class="col-12">
            <div class="alert alert-info">No blog posts found. Check back later!</div>
        </div>
    <?php else: ?>
        <?php foreach($blogPosts as $post): ?>
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="row g-0">
                    <div class="col-md-4">
                        <!-- Placeholder for blog image - Replace with your image -->
                        <img src="<?php echo BASE_URL; ?>/assets/images/blog/<?php echo $post['id']; ?>.jpg" class="img-fluid rounded-start h-100" alt="<?php echo htmlspecialchars($post['title']); ?>" style="object-fit: cover;">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
                            <p class="card-text"><small class="text-muted">By <?php echo htmlspecialchars($post['author']); ?> on <?php echo date('M j, Y', strtotime($post['created_at'])); ?></small></p>
                            <p class="card-text"><?php echo substr(strip_tags($post['content']), 0, 120); ?>...</p>
                            <a href="<?php echo BASE_URL; ?>/pages/single_blog.php?id=<?php echo $post['id']; ?>" class="btn btn-success btn-sm">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>