<?php
// Directory where uploaded files will be saved (ensure the 'uploads/' directory exists and is writable)
$upload_dir = 'uploads/';  

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $uid = $_POST['uid'];
    $ign = $_POST['ign'];

    // Check if a file was uploaded without errors
    if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] == 0) {
        // Validate file type (only allow images)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = $_FILES['screenshot']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            // Generate a unique file name to avoid overwriting
            $file_name = uniqid() . '-' . basename($_FILES['screenshot']['name']);
            $target_file = $upload_dir . $file_name;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $target_file)) {
                // File upload successful
                echo "Payment processed and file uploaded successfully!";

                // Optionally: Save additional form data and screenshot path in a database
                // Uncomment below if using a database
                /*
                $servername = "localhost";
                $username = "your_db_user";
                $password = "your_db_password";
                $dbname = "your_db_name";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Insert data into your database
                $sql = "INSERT INTO tournament_entries (name, email, phone, uid, ign, payment_screenshot) 
                        VALUES ('$name', '$email', '$phone', '$uid', '$ign', '$file_name')";

                if ($conn->query($sql) === TRUE) {
                    echo "Entry saved successfully!";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                $conn->close();
                */
            } else {
                echo "Error moving the uploaded file.";
            }
        } else {
            echo "Invalid file type. Only JPG, PNG, and GIF files are allowed.";
        }
    } else {
        echo "No file uploaded or there was an upload error.";
    }
} else {
    echo "Invalid request method.";
}
?>
