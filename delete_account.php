<?php

include 'createdb.php';

session_start();

if (isset($_SESSION['email'])) {
    $conn = createDatabase();
    $email = $_SESSION['email'];

    if ($conn) {
        $sql = "DELETE FROM usuarios WHERE email = '$email'";

        $result = mysqli_query($conn, $sql);
        
        $conn->close();

        session_destroy();
        if ($result) {
            echo "El usuario ha sido eliminado exitosamente.";
            echo "<button onclick=\"window.location.href='index.html'\">Continuar</button>";
        } else {
            echo "Error al eliminar el usuario";
            echo "<button onclick=\"window.location.href='profile.html'\">Continuar</button>";
        }
    }
} else {
    header("Location: index.html");
}

?>