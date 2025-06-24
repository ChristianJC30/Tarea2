<?php
// Inicia la sesión para poder utilizar variables de sesión
session_start();

// Incluye el archivo de conexión a la base de datos
require 'conexion.php';

// Verifica si la solicitud fue hecha mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los valores enviados desde el formulario (puede ser correo o nombre de usuario)
    $login = $_POST['login'];
    $contrasena = $_POST['contrasena'];

    // Prepara una consulta SQL para buscar al usuario por correo o nombre de usuario
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE correo = ? OR usuario = ?");
    // Asocia los parámetros ingresados al statement (doble uso de $login porque puede ser correo o usuario)
    $stmt->bind_param("ss", $login, $login);
    // Ejecuta la consulta
    $stmt->execute();
    // Obtiene los resultados de la consulta
    $resultado = $stmt->get_result();

    // Verifica si se encontró un solo usuario con ese correo o nombre de usuario
    if ($resultado->num_rows === 1) {
        // Obtiene los datos del usuario como un arreglo asociativo
        $usuario = $resultado->fetch_assoc();
        // Verifica que la contraseña ingresada coincida con la contraseña en la base de datos (usando hash)
        if (password_verify($contrasena, $usuario['contrasena'])) {
            // Guarda el nombre de usuario en la sesión para mantenerlo autenticado
            $_SESSION['usuario'] = $usuario['usuario'];
            // Redirige al usuario a la página principal
            header("Location: index.php");
            exit();
        } else {
            // Mensaje de error si la contraseña no coincide
            echo "Contraseña incorrecta.";
        }
    } else {
        // Mensaje de error si no se encuentra ningún usuario con ese correo o nombre
        echo "Correo o usuario no encontrado.";
    }
    // Cierra el statement para liberar recursos
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos_login.css">
    <title>Login</title>
</head>
<body>

    <h1>Palomitas y Opiniones</h1>

    <form method="POST" action="">
        <h2>Iniciar Sesión</h2>
        Correo o Usuario: <input type="text" name="login" required><br>
        Contraseña: <input type="password" name="contrasena" required><br>
        <button type="submit">Ingresar</button>
        <p style="text-align:center; margin-top: 15px;">
            <a href="registro.php">Regístrate aquí</a>
        </p>
    </form>
</body>
</html>
