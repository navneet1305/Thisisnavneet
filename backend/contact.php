<?php
// Initialize variables
$name = $email = $message = "";
$errors = [];
$success = "";

// Process form when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize inputs
    $name = trim(htmlspecialchars($_POST["name"]));
    $email = trim(filter_var($_POST["email"], FILTER_SANITIZE_EMAIL));
    $message = trim(htmlspecialchars($_POST["message"]));

    // Validate name
    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }

    // Validate message
    if (empty($message)) {
        $errors[] = "Message cannot be empty.";
    }

    // If no errors, send email
    if (empty($errors)) {

        $to = "your@email.com"; // CHANGE THIS
        $subject = "New Contact Form Message";

        // Prevent header injection
        if (preg_match("/[\r\n]/", $name) || preg_match("/[\r\n]/", $email)) {
            die("Invalid input detected.");
        }

        $body = "Name: $name\n";
        $body .= "Email: $email\n\n";
        $body .= "Message:\n$message\n";

        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";

        if (mail($to, $subject, $body, $headers)) {
            $success = "Message sent successfully!";
            $name = $email = $message = "";
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
    <style>
        body { font-family: Arial; max-width: 500px; margin: 50px auto; }
        input, textarea { width: 100%; padding: 10px; margin: 8px 0; }
        button { padding: 10px 15px; background: #007BFF; color: white; border: none; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>

<h2>Contact Us</h2>

<?php
if (!empty($errors)) {
    echo '<div class="error"><ul>';
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo '</ul></div>';
}

if (!empty($success)) {
    echo "<div class='success'>$success</div>";
}
?>

<form method="POST" action="">
    <input type="text" name="name" placeholder="Your Name" value="<?php echo $name; ?>" required>
    <input type="email" name="email" placeholder="Your Email" value="<?php echo $email; ?>" required>
    <textarea name="message" rows="5" placeholder="Your Message" required><?php echo $message; ?></textarea>
    <button type="submit">Send Message</button>
</form>

</body>
</html>