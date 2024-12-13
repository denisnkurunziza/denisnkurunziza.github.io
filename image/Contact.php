<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'portofolio'; // Corrected database name

// Establishing connection to the database
$mysqli = new mysqli($host, $username, $password, $database);

// Checking if the connection was successful
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$name = "";
$email = "";
$message = "";
$errorMessage = "";
$successMessage = "";

// Handling form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Validating form data
    if (empty($name) || empty($email) || empty($message)) {
        $errorMessage = 'Required fields are missing.';
    } else {
        // Inserting data into the database using prepared statement
        $stmt = $mysqli->prepare("INSERT INTO users (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message); // Corrected parameter types

        if ($stmt->execute()) {
            $successMessage = "Message Sent Successfully";
            // Redirecting to index.php after successful submission
            header("Location: index.html");
            exit(); // Terminating script execution after redirection
        } else {
            $errorMessage = "Error Sending Message: " . $mysqli->error;
        }
        $stmt->close();
    }
}
$mysqli->close();
?>
