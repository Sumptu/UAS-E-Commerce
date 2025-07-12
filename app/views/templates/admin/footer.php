        </div>
    </main>

    <!-- Footer -->
    <footer class="footer py-3 mt-auto">
        <div class="container">
            <div class="text-center">
                <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?> Admin Panel. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Auto-hide alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });

        // Add active class to current nav item
        const currentLocation = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(function(link) {
            if (link.getAttribute('href') === currentLocation) {
                link.classList.add('active');
            }
        });
    });
    </script>
</body>
</html> 