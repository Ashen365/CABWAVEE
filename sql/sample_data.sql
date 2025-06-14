-- Script to insert dummy data for CABWAVE

-- Insert dummy users
INSERT INTO users (username, password, email, phone, role) VALUES
('user1', MD5('password1'), 'user1@example.com', '1234567890', 'user'),
('admin', MD5('adminpassword'), 'admin@example.com', '0987654321', 'admin');

-- Insert dummy drivers
INSERT INTO drivers (name, email, phone, license_number, status) VALUES
('John Doe', 'johndoe@example.com', '1234567890', 'LIC123456', 'available'),
('Jane Smith', 'janesmith@example.com', '0987654321', 'LIC654321', 'busy');

-- Insert dummy bookings
INSERT INTO bookings (user_id, driver_id, pickup_location, dropoff_location, status) VALUES
(1, 1, '123 Main St', '456 Elm St', 'completed'),
(1, 2, '789 Pine St', '321 Oak St', 'pending');

-- Insert dummy pricing
INSERT INTO pricing (base_fare, per_km_rate, per_minute_rate) VALUES
(50.00, 10.00, 2.00);

-- Insert dummy feedback
INSERT INTO feedback (user_id, driver_id, booking_id, rating, comments) VALUES
(1, 1, 1, 5, 'Great ride! Very professional driver.'),
(1, 2, 2, 4, 'Good experience but arrived late.');