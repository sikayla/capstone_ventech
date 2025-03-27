<?php
require 'db_connection.php'; // Ensure database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lat = isset($_POST['lat']) ? floatval($_POST['lat']) : null;
    $lng = isset($_POST['lng']) ? floatval($_POST['lng']) : null;

    if ($lat && $lng) {
        $name = "New Basketball Court"; // Default name
        $price = 400; // Default price
        $capacity = 10; // Default capacity
        $tags = json_encode(["New", "Basketball Court"]); // Default tags
        $image = "/venue_locator/images/default_court.jpg"; // Default image

        $sql = "INSERT INTO properties (title, description, price, type, location_lat, location_lng, image_url, capacity, tags)
                VALUES (?, 'Newly added court', ?, 'Covered Court', ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sdiidss", $name, $price, $lat, $lng, $image, $capacity, $tags);

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Court added successfully!", "id" => $stmt->insert_id]);
            } else {
                echo json_encode(["status" => "error", "message" => "Database error: " . $stmt->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Statement preparation failed."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid coordinates."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
