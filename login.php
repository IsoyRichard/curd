<?php

include 'createdb.php';

session_start();

if (isset($_SESSION['email'])) {
  header("Location: profile.html");
} else if ($_SERVER["REQUEST_METHOD"] != "POST") {
  header("Location: login.html");
}

$email    = $_POST["email"];
$password = $_POST["password"];

$conn = createDatabase();

if ($conn) {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);
  
    if ($result->num_rows == 1) {
      $_SESSION['email'] = "$email";

      header("Location: profile.html");
      exit();
    } else {
      echo "Correo electronico o contrase&ntilde;a incorrectos.";
    }
  }
  
  $conn->close();
}
?>