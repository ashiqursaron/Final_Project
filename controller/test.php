
<?php
$hashedPassword = '$2y$10$VJi9.H6Xf5yZhSNmp4jUq.vU0iXGDCpS2oY6y2iuVp9jhxxy5Bqzm'; // Replace with the actual hashed password from the database
$enteredPassword = 'zenin123'; // Replace with the entered password

if (password_verify($enteredPassword, $hashedPassword)) {
    echo "Password verified successfully!";
} else {
    echo "Password verification failed!";
}
?>