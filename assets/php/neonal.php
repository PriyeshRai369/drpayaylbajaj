<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Only process POST requests.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form fields and remove whitespace.
    $first_name = strip_tags(trim($_POST["name"]));
    $first_name = str_replace(array("\r", "\n"), array(" ", " "), $first_name);
    
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $last_name = strip_tags(trim($_POST["lname"]));
    $phone = strip_tags(trim($_POST["phone"]));
    $message = strip_tags(trim($_POST["message"]));

    // Check that data was sent to the mailer.
    if (empty($first_name) || empty($last_name) || empty($phone) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(["message" => "Please complete the form and try again."]);
        exit;
    }

    // Set the recipient email address.
    $recipient = "drpayalbajaj@gmail.com";
    $subject = "New - Mail From $first_name";

    // Build the email content.
    $email_content = "Name: $first_name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Phone: $phone\n\n";
    $email_content .= "Message:\n$message\n";

    // Build the email headers.
    $email_headers = "From: $first_name <$email>";

    // Send the email.
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo json_encode(["message" => "Thank You! Your message has been sent."]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Oops! Something went wrong and we couldn't send your message."]);
    }
} else {
    // Not a POST request, set a 403 (forbidden) response code.
    http_response_code(403);
    echo json_encode(["message" => "There was a problem with your submission, please try again."]);
}
?>
