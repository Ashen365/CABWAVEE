<?php
// Check if we're in admin directory and adjust paths
$isAdminDir = true;
$basePath = '../';
require_once $basePath . 'config/config.php';
require_once $basePath . 'includes/db.php';

// Check if user is admin
if (!isAdmin()) {
    redirect($basePath . 'login.php');
}

$error = '';
$success = '';

// Process form submission for updating pricing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_pricing') {
    $base_fare = (float)$_POST['base_fare'];
    $per_km_rate = (float)$_POST['per_km_rate'];
    $per_minute_rate = (float)$_POST['per_minute_rate'];
    
    // Validate inputs
    if ($base_fare < 0 || $per_km_rate < 0 || $per_minute_rate < 0) {
        $error = "Rates cannot be negative";
    } else {
        // Update pricing in database
        $stmt = $conn->prepare("UPDATE pricing SET base_fare = ?, per_km_rate = ?, per_minute_rate = ? WHERE pricing_id = 1");
        $stmt->bind_param("ddd", $base_fare, $per_km_rate, $per_minute_rate);
        
        if ($stmt->execute()) {
            $success = "Pricing updated successfully";
        } else {
            $error = "Failed to update pricing: " . $conn->error;
        }
    }
}

// Get current pricing
$pricing = null;
$result = $conn->query("SELECT * FROM pricing ORDER BY pricing_id LIMIT 1");
if ($result->num_rows === 1) {
    $pricing = $result->fetch_assoc();
}

// Include header
include $basePath . 'includes/header.php';
?>

<h2>Settings</h2>

<?php if ($error): ?>
    <?php echo showError($error); ?>
<?php endif; ?>

<?php if ($success): ?>
    <?php echo showSuccess($success); ?>
<?php endif; ?>

<div class="settings-container">
    <div class="pricing-settings">
        <h3>Pricing Settings</h3>
        <?php if ($pricing): ?>
            <form method="POST" action="">
                <input type="hidden" name="action" value="update_pricing">
                
                <div class="form-group">
                    <label for="base_fare">Base Fare (₹)</label>
                    <input type="number" id="base_fare" name="base_fare" step="0.01" min="0" value="<?php echo $pricing['base_fare']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="per_km_rate">Per Kilometer Rate (₹)</label>
                    <input type="number" id="per_km_rate" name="per_km_rate" step="0.01" min="0" value="<?php echo $pricing['per_km_rate']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="per_minute_rate">Per Minute Rate (₹)</label>
                    <input type="number" id="per_minute_rate" name="per_minute_rate" step="0.01" min="0" value="<?php echo $pricing['per_minute_rate']; ?>" required>
                </div>
                
                <button type="submit" class="btn">Update Pricing</button>
            </form>
        <?php else: ?>
            <p>No pricing information found. Please check the database.</p>
        <?php endif; ?>
    </div>
    
    <div class="system-settings">
        <h3>System Settings</h3>
        <p>These settings will be implemented in future updates.</p>
    </div>
</div>

<style>
.settings-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.pricing-settings, .system-settings {
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 20px;
}
</style>

<?php include $basePath . 'includes/footer.php'; ?>