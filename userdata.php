<?php

include 'createdb.php';

session_start();


$email = null;

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    
}

error_log("Log: " . $email);

if (!$email) {
    header("Location: login.html");
}

$conn = createDatabase();

if ($conn) {
    $result_userdata = mysqli_query($conn, "SELECT username, surname, email FROM users WHERE email = '$email';");
    $userdata = mysqli_fetch_assoc($result_userdata);
  
    $conn->close();

    echo json_encode($userdata);
}
?>