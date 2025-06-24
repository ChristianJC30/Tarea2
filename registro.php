<?php
// Incluye el archivo de conexión a la base de datos
require 'conexion.php';

//Metadato
$meta_description = "Christian Ricardo Garcia Chavez";

// Verifica si la solicitud fue hecha mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los datos del formulario: correo, usuario y contraseña
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    
    // Encripta la contraseña usando el algoritmo por defecto (actualmente bcrypt)
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    // Prepara la consulta SQL para insertar un nuevo usuario en la base de datos
    $stmt = $conn->prepare("INSERT INTO usuarios (correo, usuario, contrasena) VALUES (?, ?, ?)");
    
    // Asocia los valores del formulario a los parámetros de la consulta
    $stmt->bind_param("sss", $correo, $usuario, $contrasena);

    // Ejecuta la consulta y verifica si fue exitosa
    if ($stmt->execute()) {
        // Si el registro fue exitoso, muestra un mensaje y un enlace para iniciar sesión
        echo "Registro exitoso.";
    } else {
        // Si hubo un error, lo muestra
        echo "Error: " . $stmt->error;
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
    <link rel="stylesheet" href="estilos_registro.css">
    <meta name="description" content="<?php echo $meta_description; ?>">
    <title> Registro</title>
</head>
<body>

    <h1>Palomitas y Opiniones</h1>

    <form method="POST" action="">
        <h2>Registro</h2>
        Correo: <input type="email" name="correo" required><br>
        Usuario: <input type="text" name="usuario" required><br>
        Contraseña: <input type="password" name="contrasena" required><br>
        <button type="submit">Registrar</button>
        <p style="text-align:center; margin-top: 15px;">
                regresar al <a href="login.php">login</a>
        </p>
    </form>
</body>
</html>
