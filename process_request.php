<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    $connection = mysqli_connect('localhost', 'root', 'root', 'home');
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Initialize session
    session_start();

    // Check if designer ID is set in the session
    if (isset($_SESSION['designerID'])) {
        // Get designer ID from session
        $designerID = $_SESSION['designerID'];

        // Retrieve form data and perform basic validation
        $ClientID = isset($_SESSION['ClientID']) ? $_SESSION['ClientID'] : '';
        $room_type = validate_input($_POST['roomType']);
        $room_width = validate_input($_POST['roomWidth']);
        $room_length = validate_input($_POST['roomLength']);
        $design_category = validate_input($_POST['designCategory']);
        $color_preferences = validate_input($_POST['colorPreferences']);
        $consultation_date = validate_input($_POST['consultationDate']);

        // Perform further validation as needed
        if (empty($room_type) || empty($room_width) || empty($room_length) || empty($design_category) || empty($color_preferences) || empty($consultation_date)) {
            echo "All fields are required.";
        } else {
            // Insert new consultation request into the database with a pending status
            $status_id = 1; // Pending status
            $query = "INSERT INTO DesignConsultationRequest (clientID, designerID, roomTypeID, designCategoryID, roomWidth, roomLength, colorPreferences, date, statusID) 
                      VALUES ('$ClientID', '$designerID', '$room_type', '$design_category', '$room_width', '$room_length', '$color_preferences', '$consultation_date', '$status_id')";

            if (mysqli_query($connection, $query)) {
                // Consultation request added successfully, redirect to client's homepage
                header("Location: ClientHomepage.html");
                exit();
            } else {
                // Error inserting consultation request
                echo "Error: Unable to add consultation request.";
            }
        }
    } else {
        // Designer ID not found in session
        echo "Designer ID is missing or empty.";
    }

    // Close database connection
    mysqli_close($connection);
} else {
    // If the form was not submitted via POST method, redirect to homepage
    header("Location: index.html");
    exit();
}

// Function to validate input
function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
