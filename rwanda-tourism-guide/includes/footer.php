</div> <!-- Close container from header -->
    
    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>About Rwanda Tourism</h5>
                    <p>Discover the land of a thousand hills - its breathtaking landscapes, vibrant culture, and incredible wildlife.</p>
                    <img src="<?php echo BASE_URL; ?>/assets/images/footer-logo.png" alt="Rwanda Tourism Logo" class="img-fluid mb-3" width="150">
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo BASE_URL; ?>/index.php" class="text-white">Home</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/pages/destinations.php" class="text-white">Destinations</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/pages/events.php" class="text-white">Events & Festivals</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/pages/blog.php" class="text-white">Travel Blog</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/pages/contact.php" class="text-white">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Information</h5>
                    <address>
                        <strong>Rwanda Development Board</strong><br>
                        KG 9 Avenue, Kigali<br>
                        Rwanda<br>
                        <i class="fas fa-phone"></i> +250 787 123 456<br>
                        <i class="fas fa-envelope"></i> tourism@rdb.rw
                    </address>
                    <div class="social-icons">
                        <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr class="bg-light">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> Rwanda Tourism Guide. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-white me-3">Privacy Policy</a>
                    <a href="#" class="text-white me-3">Terms of Service</a>
                    <a href="#" class="text-white">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Chatbot Button -->
    <button id="chatbot-toggle" class="btn btn-success rounded-circle p-3 position-fixed" style="bottom: 30px; right: 30px;">
        <i class="fas fa-robot fa-2x"></i>
    </button>

    <!-- Chatbot Modal -->
    <div class="modal fade" id="chatbotModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Tourism Assistant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="chatbot-messages" class="mb-3" style="height: 300px; overflow-y: auto;"></div>
                    <div class="input-group">
                        <input type="text" id="chatbot-input" class="form-control" placeholder="Ask about Rwanda tourism...">
                        <button id="chatbot-send" class="btn btn-success"><i class="fas fa-paper-plane"></i></button>
                        <button id="chatbot-voice" class="btn btn-outline-success"><i class="fas fa-microphone"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Leaflet JS (for maps) -->
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    
    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GMAPS_API_KEY; ?>&libraries=places"></script>
    
    <!-- Custom JS -->
    <script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/map.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/chatbot.js"></script>
    
    <script>
        // Language switcher function
        function changeLanguage(lang) {
            // In a real implementation, this would set a cookie or session variable
            // and reload the page with translations
            alert('Language changed to ' + lang + '. This would reload the page with translations in a full implementation.');
        }
    </script>
</body>
</html>