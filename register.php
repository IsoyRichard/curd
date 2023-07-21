<?php

include 'createdb.php';

$conn = createDatabase();

if ($conn) {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST["email"];
    $username = $_POST["username"];
    $surname  = $_POST["surname"];
    $password = $_POST["password"];
  
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
      echo "El correo electrónico ya está registrado.";
    } else {
      $query = "INSERT INTO users (email, username, surname, password) VALUES ('$email', '$username', '$surname', '$password')";
      if (mysqli_query($conn, $query)) {
        echo "El usuario se registró correctamente.";
      header("Location: login.html");
      exit();
      } else {
        echo "Error al registrar el usuario: " . mysqli_error($conn);
      }
    }
  }
  
  mysqli_close($conn);
}

?>