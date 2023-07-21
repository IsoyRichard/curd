<?php

function createDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "users";

    $conn = new mysqli($servername, $username, $password);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
        return null;
    }

    $check_db_query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbname'";
    $check_db_result = $conn->query($check_db_query);

    if ($check_db_result->num_rows == 0) {
        $create_db_query = "CREATE DATABASE $dbname";
    
        if ($conn->query($create_db_query) === TRUE) {
            echo "La base de datos '$dbname' ha sido creada exitosamente.\n";
        } else {
            echo "Error al crear la base de datos: " . $conn->error;
            return null;
        }
    }

    $conn->close();
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Conexion fallida: " . mysqli_connect_error());
        return false;
    }

    $result = mysqli_query($conn, "SHOW TABLES LIKE 'users'");

    if (mysqli_num_rows($result) == 1)
    {
        return $conn;
    }

    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL,
        surname VARCHAR(30) NOT NULL,
        email VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL
    )";
    

    if (mysqli_query($conn, $sql)) {
        echo "Tabla 'users' creada exitosamente\n";
        return $conn;
    } else {
        echo "Error al crear la tabla: " . mysqli_error($conn);
        mysqli_close($conn);
    }

    return null;
}

?>