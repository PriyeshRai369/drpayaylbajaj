<?php
// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

// Ensure the request is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Sanitize and validate form inputs
    $first_name = strip_tags(trim($_POST["name"]));
    $first_name = str_replace(array("\r", "\n"), array(" ", " "), $first_name);
    
    $last_name = strip_tags(trim($_POST["lname"]));
    $last_name = str_replace(array("\r", "\n"), array(" ", " "), $last_name);
    
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST["phone"]));
    $message = strip_tags(trim($_POST["message"]));

    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($phone) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(["message" => "Please complete the form and provide a valid email address."]);
        exit;
    }

    // Set the recipient email address
    $recipient = "drpayalbajaj@gmail.com";
    $subject = "New Message from $first_name $last_name";

    // Build the email content
    $email_content = "First Name: $first_name\n";
    $email_content .= "Last Name: $last_name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone: $phone\n\n";
    $email_content .= "Message:\n$message\n";

    // Build the email headers
    $email_headers = "From: $first_name $last_name <$email>";

    // Attempt to send the email
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo json_encode(["message" => "Thank You! Your message has been sent."]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Oops! Something went wrong and we couldn't send your message."]);
    }
    
} else {
    // Return 403 Forbidden if the request method is not POST
    http_response_code(403);
    echo json_encode(["message" => "There was a problem with your submission, please try again."]);
}
?>
