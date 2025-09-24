<?php
// Include Composer autoloader
require_once 'vendor/autoload.php';

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Database configuration (adjust these settings for your setup)
$host = 'localhost';
$dbname = 'taskapp_db';
$username = 'root';
$password = '123456'; // Use the password you set for MariaDB

// Function to validate email address
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Function to send welcome email
function sendWelcomeEmail($userEmail, $userName) {
    $mail = new PHPMailer(true);

    try {
        // Server settings for Gmail (you can change this)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'eeshahsabirkhan144@gmail.com';  
        $mail->Password   = 'xhkfk4jrnffjijfn';     
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('eeshahsabirkhan144@gmail.com', 'ICS 2.2 System Admin');
        $mail->addAddress($userEmail, $userName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to ICS 2.2! Account Verification';
        
        // Email body with personalized greeting
        $mail->Body = "
        <html>
        <body>
            <h2>Welcome to ICS 2.2 Account Verification</h2>
            <p>Hello $userName,</p>
            <p>You requested an account on ICS 2.2</p>
            <p>In order to use this account you need to <a href='#' style='color: blue;'>Click Here</a> to complete the registration process.</p>
            <br>
            <p>Regards,</p>
            <p>Systems Admin<br>ICS 2.2</p>
        </body>
        </html>
        ";

        $mail->AltBody = "Hello $userName,\n\nYou requested an account on ICS 2.2\n\nIn order to use this account you need to Click Here to complete the registration process.\n\nRegards,\nSystems Admin\nICS 2.2";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

// Process form submission
if ($_POST) {
    $email = trim($_POST['email'] ?? '');
    $name = trim($_POST['name'] ?? '');
    
    // Validate email
    if (!validateEmail($email)) {
        $error = "Invalid email address format.";
    } else {
        // Connect to SQLite database
        try {
            $pdo = new PDO("sqlite:$database_file");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Create table if it doesn't exist
            $pdo->exec("CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT UNIQUE NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )");
            
            // Insert user into database
            $stmt = $pdo->prepare("INSERT INTO users (name, email, created_at) VALUES (?, ?, datetime('now'))");
            $stmt->execute([$name, $email]);
            
            // Send welcome email
            if (sendWelcomeEmail($email, $name)) {
                $success = "Account created successfully! Welcome email sent to $email";
            } else {
                $success = "Account created but email could not be sent.";
            }
            
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}
?>