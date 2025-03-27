<?php
// Get latitude and longitude from URL parameters (if available)
$lat = isset($_GET['lat']) ? htmlspecialchars($_GET['lat']) : '';
$lng = isset($_GET['lng']) ? htmlspecialchars($_GET['lng']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Court</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body class="bg-gray-100">

<header class="bg-gray-900 text-white p-4 flex justify-between items-center">
        <div class="flex items-center">
            <img src="/venue_locator/images/logo.png" alt="Primo Venues Logo" class="mr-2" width="40" height="40" />
            <span class="text-xl font-bold">primovenues</span>
        </div>
        <nav class="flex items-center space-x-4">
                <a href="#" class="hover:underline">Submit Venue</a>
                <div class="relative group">
                    <a href="#" class="hover:underline flex items-center">Explore <i class="fas fa-chevron-down ml-1"></i></a>
                    <div class="absolute left-0 mt-2 w-48 bg-white text-black shadow-lg rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                    <a href="index.php" class="block px-4 py-2 hover:bg-gray-200">Home</a>
                    <a href="list_venues.php" class="block px-4 py-2 hover:bg-gray-200">List Venues</a>
                    <a  href="manage_bookings.php" class="block px-4 py-2 hover:bg-gray-200">Bookings</a>
                    <a href="find.php" class="block px-4 py-2 hover:bg-gray-200">Find Venues</a>
                    </div>
                </div>
                <a href="#" class="hover:underline">Help</a>
                <a href="signin.php" class="hover:underline">Sign In</a>
            </nav>
    </header>
  
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-3xl">
        <h1 class="text-2xl font-bold mb-4">Add New Court</h1>
        <form action="submit_court.php" method="POST" enctype="multipart/form-data">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="court-name" class="block text-sm font-medium text-gray-700">Court Name</label>
                    <input type="text" id="court-name" name="name" required class="mt-1 block w-full border rounded-md py-2 px-3">
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" required class="mt-1 block w-full border rounded-md py-2 px-3"></textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" id="price" name="price" step="0.01" required class="mt-1 block w-full border rounded-md py-2 px-3">
                </div>
                <div>
                    <label for="capacity" class="block text-sm font-medium text-gray-700">Capacity</label>
                    <input type="number" id="capacity" name="capacity" required class="mt-1 block w-full border rounded-md py-2 px-3">
                </div>
                <div>
                    <label for="lat" class="block text-sm font-medium text-gray-700">Latitude</label>
                    <input type="text" id="lat" name="lat" value="<?= $lat ?>" readonly class="mt-1 block w-full border rounded-md py-2 px-3">
                </div>
                <div>
                    <label for="lng" class="block text-sm font-medium text-gray-700">Longitude</label>
                    <input type="text" id="lng" name="lng" value="<?= $lng ?>" readonly class="mt-1 block w-full border rounded-md py-2 px-3">
                </div>
            </div>

            <div id="map" class="mt-4"></div>

            <div class="flex justify-center mt-6">
                <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-md hover:bg-orange-600">
                    Save Court
                </button>
            </div>
        </form>
    </div>

    <script>
        var map = L.map('map').setView([<?= $lat ?: 14.4545 ?>, <?= $lng ?: 120.9405 ?>], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker([<?= $lat ?: 14.4545 ?>, <?= $lng ?: 120.9405 ?>], { draggable: true }).addTo(map);

        marker.on('dragend', function (e) {
            document.getElementById('lat').value = marker.getLatLng().lat.toFixed(6);
            document.getElementById('lng').value = marker.getLatLng().lng.toFixed(6);
        });

        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            document.getElementById('lat').value = e.latlng.lat.toFixed(6);
            document.getElementById('lng').value = e.latlng.lng.toFixed(6);
        });
    </script>
</body>
</html>
