<?php
session_start();
include '../config/db.php';

// Ensure transport_id is set and sanitize the input
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$transport_id = (int)$_GET['id'];  // Cast to integer to prevent SQL injection

// Fetch the specific transport record
$query = "SELECT * FROM transport WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $transport_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$transport = mysqli_fetch_assoc($result);

// Check if transport record exists
if (!$transport) {
    echo "Transport not found.";
    exit();
}

$latitude = $transport['latitude'];
$longitude = $transport['longitude'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Transport</title>
    <link rel="stylesheet" href="../assets/css/styles.css">

    <!-- Google Maps API Key -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap" async defer></script>
    
    <style>
        #map {
            height: 400px;
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>View Transport</h1>
        <table class="table">
            <tr>
                <th>ID</th>
                <td><?php echo htmlspecialchars($transport['id']); ?></td>
            </tr>
            <tr>
                <th>Transport Name</th>
                <td><?php echo htmlspecialchars($transport['transport_name']); ?></td>
            </tr>
            <tr>
                <th>Tracking Number</th>
                <td><?php echo htmlspecialchars($transport['tracking_number']); ?></td>
            </tr>
            <tr>
                <th>Current Location</th>
                <td>Latitude: <?php echo htmlspecialchars($latitude); ?>, Longitude: <?php echo htmlspecialchars($longitude); ?></td>
            </tr>
        </table>

        <!-- Display Google Map -->
        <div id="map"></div>
    </div>

    <script>
        // Initialize and add the map
        function initMap() {
            // The transport's location
            var transportLocation = { lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?> };
            
            // The map, centered at transport's location
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: transportLocation
            });

            // Add a marker for the transport's location
            var marker = new google.maps.Marker({
                position: transportLocation,
                map: map,
                title: "Transport Location"
            });

            // If geolocation is supported and allowed, get user's current location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    // Display user location on the map
                    var userMarker = new google.maps.Marker({
                        position: userLocation,
                        map: map,
                        title: "Your Location",
                        icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                    });

                    // Center the map to show both transport and user's location
                    map.setCenter(userLocation);

                    // Optionally, draw a line between the transport's location and the user's location
                    var line = new google.maps.Polyline({
                        path: [transportLocation, userLocation],
                        geodesic: true,
                        strokeColor: '#FF0000',
                        strokeOpacity: 1.0,
                        strokeWeight: 2
                    });
                    line.setMap(map);

                }, function() {
                    alert("Geolocation service failed. Please allow location access.");
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }
    </script>
</body>
</html>
