<?php
// 1. Get form data
$name     = $_POST['name'];
$email    = $_POST['email'];
$room     = $_POST['room'];
$checkin  = $_POST['checkin'];
$checkout = $_POST['checkout'];

// 2. Database connection
$conn = new mysqli("localhost", "root", "", "hotel_db");

if ($conn->connect_error) {
    die("Database connection failed");
}

// 3. Insert data into database
$sql = "INSERT INTO bookings (name, email, room, checkin, checkout)
        VALUES ('$name', '$email', '$room', '$checkin', '$checkout')";

$conn->query($sql);

// 4. PHPMailer setup
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    // SMTP settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'luxuryhotel830@gmail.com';   // hotel email
    $mail->Password   = 'naman_manvi7';          // app password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Email details
    $mail->setFrom('luxuryhotel830@gmail.com', 'Luxury Hotel');
    $mail->addAddress($email); // user email

    $mail->isHTML(true);
    $mail->Subject = 'Booking Confirmation';
    $mail->Body    = "
        <h2>Booking Confirmed</h2>
        <p>Dear <b>$name</b>,</p>
        <p>Your room has been successfully booked.</p>
        <p>
            <b>Room:</b> $room <br>
            <b>Check-in:</b> $checkin <br>
            <b>Check-out:</b> $checkout
        </p>
        <p>Thank you for choosing Luxury Hotel.</p>
    ";

    $mail->send();

} catch (Exception $e) {
    // email error ignored (page will still open)
}

// 5. Redirect to confirmation page
header("Location: confirmation.html");
exit();
?>
