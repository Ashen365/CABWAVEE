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

// Process form submission for adding/editing driver
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        // Get form data
        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $phone = sanitize($_POST['phone']);
        $license_number = sanitize($_POST['license_number']);
        $status = sanitize($_POST['status']);
        
        // Validate inputs
        if (empty($name) || empty($email) || empty($phone) || empty($license_number)) {
            $error = "All fields are required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format";
        } else {
            // Add new driver
            if ($_POST['action'] === 'add') {
                // Check if email or license already exists
                $stmt = $conn->prepare("SELECT driver_id FROM drivers WHERE email = ? OR license_number = ?");
                $stmt->bind_param("ss", $email, $license_number);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $error = "Email or license number already exists";
                } else {
                    // Insert driver into database
                    $stmt = $conn->prepare("INSERT INTO drivers (name, email, phone, license_number, status) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssss", $name, $email, $phone, $license_number, $status);
                    
                    if ($stmt->execute()) {
                        $success = "Driver added successfully";
                    } else {
                        $error = "Failed to add driver: " . $conn->error;
                    }
                }
            } 
            // Edit existing driver
            elseif ($_POST['action'] === 'edit' && isset($_POST['driver_id'])) {
                $driver_id = (int)$_POST['driver_id'];
                
                // Check if email or license already exists for another driver
                $stmt = $conn->prepare("SELECT driver_id FROM drivers WHERE (email = ? OR license_number = ?) AND driver_id != ?");
                $stmt->bind_param("ssi", $email, $license_number, $driver_id);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $error = "Email or license number already exists for another driver";
                } else {
                    // Update driver in database
                    $stmt = $conn->prepare("UPDATE drivers SET name = ?, email = ?, phone = ?, license_number = ?, status = ? WHERE driver_id = ?");
                    $stmt->bind_param("sssssi", $name, $email, $phone, $license_number, $status, $driver_id);
                    
                    if ($stmt->execute()) {
                        $success = "Driver updated successfully";
                    } else {
                        $error = "Failed to update driver: " . $conn->error;
                    }
                }
            }
        }
    }
    // Delete driver
    elseif (isset($_POST['delete']) && isset($_POST['driver_id'])) {
        $driver_id = (int)$_POST['driver_id'];
        
        // Check if driver has any bookings
        $stmt = $conn->prepare("SELECT booking_id FROM bookings WHERE driver_id = ? LIMIT 1");
        $stmt->bind_param("i", $driver_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Cannot delete driver with existing bookings. Please reassign their bookings first.";
        } else {
            // Delete driver from database
            $stmt = $conn->prepare("DELETE FROM drivers WHERE driver_id = ?");
            $stmt->bind_param("i", $driver_id);
            
            if ($stmt->execute()) {
                $success = "Driver deleted successfully";
            } else {
                $error = "Failed to delete driver: " . $conn->error;
            }
        }
    }
}

// Get driver for editing
$driver = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $driver_id = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM drivers WHERE driver_id = ?");
    $stmt->bind_param("i", $driver_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $driver = $result->fetch_assoc();
    }
}

// Get all drivers
$drivers = [];
$result = $conn->query("SELECT * FROM drivers ORDER BY name");
while ($row = $result->fetch_assoc()) {
    $drivers[] = $row;
}

// Include header
include $basePath . 'includes/header.php';
?>

<div class="admin-page">
    <h2><?php echo $driver ? 'Edit Driver' : 'Add New Driver'; ?></h2>

    <?php if ($error): ?>
        <?php echo showError($error); ?>
    <?php endif; ?>

    <?php if ($success): ?>
        <?php echo showSuccess($success); ?>
    <?php endif; ?>

    <div class="admin-form">
        <form method="POST" action="">
            <input type="hidden" name="action" value="<?php echo $driver ? 'edit' : 'add'; ?>">
            <?php if ($driver): ?>
                <input type="hidden" name="driver_id" value="<?php echo $driver['driver_id']; ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo $driver ? htmlspecialchars($driver['name']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $driver ? htmlspecialchars($driver['email']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" value="<?php echo $driver ? htmlspecialchars($driver['phone']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="license_number">License Number</label>
                <input type="text" id="license_number" name="license_number" value="<?php echo $driver ? htmlspecialchars($driver['license_number']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="available" <?php echo ($driver && $driver['status'] === 'available') ? 'selected' : ''; ?>>Available</option>
                    <option value="busy" <?php echo ($driver && $driver['status'] === 'busy') ? 'selected' : ''; ?>>Busy</option>
                    <option value="inactive" <?php echo ($driver && $driver['status'] === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn"><?php echo $driver ? 'Update Driver' : 'Add Driver'; ?></button>
                
                <?php if ($driver): ?>
                    <a href="manage-drivers.php" class="btn btn-secondary">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <h2 class="mt-4">Drivers List</h2>

    <?php if (count($drivers) > 0): ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>License Number</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($drivers as $d): ?>
                        <tr>
                            <td><?php echo $d['driver_id']; ?></td>
                            <td><?php echo htmlspecialchars($d['name']); ?></td>
                            <td><?php echo htmlspecialchars($d['email']); ?></td>
                            <td><?php echo htmlspecialchars($d['phone']); ?></td>
                            <td><?php echo htmlspecialchars($d['license_number']); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo $d['status']; ?>">
                                    <?php echo ucfirst($d['status']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="manage-drivers.php?edit=<?php echo $d['driver_id']; ?>" class="btn btn-sm">Edit</a>
                                    <form method="POST" action="" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this driver? This action cannot be undone.')">
                                        <input type="hidden" name="driver_id" value="<?php echo $d['driver_id']; ?>">
                                        <input type="hidden" name="delete" value="1">
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No drivers found.</p>
    <?php endif; ?>
</div>

<style>
.admin-page {
    margin-bottom: 40px;
}

.admin-form {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.mt-4 {
    margin-top: 25px;
}

.table-responsive {
    overflow-x: auto;
}

.status-badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: bold;
    color: white;
}

.status-available {
    background-color: #28a745;
}

.status-busy {
    background-color: #ffc107;
    color: #212529;
}

.status-inactive {
    background-color: #dc3545;
}

.action-buttons {
    display: flex;
    gap: 5px;
}

.btn-sm {
    padding: 4px 8px;
    font-size: 0.85rem;
}
</style>

<?php include $basePath . 'includes/footer.php'; ?>