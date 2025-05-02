// Main JavaScript file for the Rwanda Tourism website

document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
    // Chatbot toggle
    const chatbotToggle = document.getElementById('chatbot-toggle');
    const chatbotModal = new bootstrap.Modal(document.getElementById('chatbotModal'));
    
    if (chatbotToggle) {
        chatbotToggle.addEventListener('click', function() {
            chatbotModal.show();
        });
    }
    
    // Language switcher (placeholder)
    document.querySelectorAll('[onclick^="changeLanguage"]').forEach(function(el) {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            const lang = this.getAttribute('onclick').match(/'([^']+)'/)[1];
            console.log('Language changed to:', lang);
            // In a real implementation, this would set a cookie or make an AJAX call
        });
    });
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Form validation
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            let valid = true;
            
            // Check required fields
            this.querySelectorAll('[required]').forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            // Check email format
            const emailFields = this.querySelectorAll('input[type="email"]');
            emailFields.forEach(field => {
                if (field.value && !field.validity.valid) {
                    valid = false;
                    field.classList.add('is-invalid');
                }
            });
            
            if (!valid) {
                e.preventDefault();
                
                // Scroll to first invalid field
                const firstInvalid = this.querySelector('.is-invalid');
                if (firstInvalid) {
                    firstInvalid.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    firstInvalid.focus();
                }
            }
        });
    });
    
    // Remove validation classes when user starts typing
    document.querySelectorAll('input, textarea').forEach(field => {
        field.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                this.classList.remove('is-invalid');
            }
        });
    });
});