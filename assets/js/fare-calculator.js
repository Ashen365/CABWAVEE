/**
 * CABWAVE - Fare Calculator JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    initDashboardFareCalculator();
});

/**
 * Initialize fare calculator on the dashboard
 */
function initDashboardFareCalculator() {
    const pickupField = document.getElementById('pickup_location');
    const dropoffField = document.getElementById('dropoff_location');
    const fareEstimateDiv = document.getElementById('fare-estimate');
    
    if (pickupField && dropoffField && fareEstimateDiv) {
        // Function to calculate and display fare estimate
        const calculateFare = () => {
            if (pickupField.value.trim() && dropoffField.value.trim()) {
                // Get pricing data from hidden inputs
                const baseFare = parseFloat(document.getElementById('base_fare').value) || 50;
                const perKmRate = parseFloat(document.getElementById('per_km_rate').value) || 10;
                const perMinuteRate = parseFloat(document.getElementById('per_minute_rate').value) || 2;
                
                // In a real app, we would call an API to get the distance
                // For this demo, generate a random distance
                const distance = (Math.random() * 20 + 1).toFixed(1); // 1-21 km
                const estimatedTime = Math.ceil(distance / 30 * 60); // Assuming 30 km/h avg speed
                
                // Calculate fare components
                const distanceCharge = distance * perKmRate;
                const timeCharge = estimatedTime * perMinuteRate;
                const totalFare = baseFare + distanceCharge + timeCharge;
                
                // Update the fare estimate display
                fareEstimateDiv.innerHTML = `
                    <div class="fare-estimate-content">
                        <h4>Estimated Fare</h4>
                        <div class="estimate-details">
                            <p><strong>Distance:</strong> ~${distance} km</p>
                            <p><strong>Time:</strong> ~${estimatedTime} mins</p>
                            <p><strong>Base Fare:</strong> ₹${baseFare.toFixed(2)}</p>
                            <p><strong>Distance Charge:</strong> ₹${distanceCharge.toFixed(2)}</p>
                            <p><strong>Time Charge:</strong> ₹${timeCharge.toFixed(2)}</p>
                            <p class="total-fare"><strong>Total Estimate:</strong> ₹${totalFare.toFixed(2)}</p>
                        </div>
                        <div class="fare-disclaimer">
                            <small>This is an estimate. Actual fare may vary.</small>
                        </div>
                    </div>
                `;
                fareEstimateDiv.style.display = 'block';
            }
        };
        
        // Calculate when both fields have values and one loses focus
        dropoffField.addEventListener('blur', calculateFare);
        pickupField.addEventListener('blur', function() {
            if (dropoffField.value.trim()) {
                calculateFare();
            }
        });
    }
}