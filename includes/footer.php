    </main>
    <footer>
        <?php
        // Determine if we're in a subdirectory
        $isInSubdir = strpos($_SERVER['SCRIPT_NAME'], '/admin/') !== false;
        $basePath = $isInSubdir ? '../' : '';
        ?>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3><?php echo SITE_NAME; ?></h3>
                    <p>Your reliable transportation solution for all your travel needs.</p>
                </div>
                
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="<?php echo $basePath; ?>index.php">Home</a></li>
                        <li><a href="<?php echo $basePath; ?>services.php">Services</a></li>
                        <li><a href="<?php echo $basePath; ?>fare-calculator.php">Fare Calculator</a></li>
                        <li><a href="<?php echo $basePath; ?>pricing.php">Pricing</a></li>
                        <li><a href="<?php echo $basePath; ?>contact.php">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <p>Email: info@cabwave.com</p>
                    <p>Phone: +1 (555) 123-4567</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/magic-ui/dist/magic-ui.min.js"></script>
    <script src="<?php echo $basePath; ?>assets/js/main.js"></script>
    <script src="<?php echo $basePath; ?>assets/js/header.js"></script>
</body>
</html>