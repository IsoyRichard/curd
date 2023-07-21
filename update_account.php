<?php

include 'createdb.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_SESSION['email'])) {
        header("Location: index.html");
        exit();
    }

    $email    = $_SESSION['email'];
    $newemail = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    $conn = createDatabase();
    if ($conn) {
        $sql = "SELECT * FROM users WHERE email = '$newemail'";

        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            $conn->close();
            echo "<p>El correo ya existe</p><button onclick=\"window.location.href='update_account.html'\">Continuar</button>";
            exit();
        }
    }

    $sql = "UPDATE users SET ";

    if (empty($newemail) && empty($password) && empty($confirm_password)) {
        $conn->close();
        echo "<p>Todos los campos estan vacios</p><button onclick=\"window.location.href='update_account.html'\">Continuar</button>";
        exit();
    } 

    if (!empty($newemail)) {
        $sql = $sql . "email = '$newemail' ";
        if (!empty($password)) {
            $sql = $sql . ", ";
        }
    }

    if (!empty($password)) {
        if ($password !== $confirm_password) {
            $conn->close();
            echo "<p>Las contraseñas no coinciden o no ha llenado el campo confirmar contraseña</p><button onclick=\"window.location.href='update_account.html'\">Continuar</button>";
            exit();
        } else {
            $sql = $sql . "password = '$password' ";
        }
    }

    $sql = $sql . "WHERE email = '$email'";

    error_log($sql);

    if (mysqli_query($conn, $sql)) {
        $conn->close();
        if ($email !== $newemail) {
            $_SESSION['email'] = $newemail;
        }

        if (!empty($confirm_password)) {
            session_destroy();
            header("Location: login.html");
        } else {
            header("Location: profile.html");
        }
        exit();
    } else {
        echo "<p>Error al actualizar los datos " . mysqli_error($conn) . "</p><button onclick=\"window.location.href='index.html'\">Continuar</button>";
        $conn->close();
        
    }
    exit();
}
?>