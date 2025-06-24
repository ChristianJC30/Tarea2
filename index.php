<?php
// Inicia la sesión o reanuda una sesión existente
session_start();

// Verifica si la variable de sesión 'usuario' NO está definida (es decir, el usuario no ha iniciado sesión)
if (!isset($_SESSION['user_id'])) {
    // Redirige al usuario a la página de login
    header("Location: login.php");
    // Detiene la ejecución del script para evitar que se cargue contenido protegido
    exit();
}

//Insertar publicacion
if ($_SERVER[REQUEST_METHOD]=="POST" && isset($_POST["new_post"])){
    $title = $_POST["title"];
    $content = $_POST["content"];
    $stmt = $pdo->prepare("INSERT INTO posts (title, content, user_id) VALUES (?,?,?");
    $stmt->execute([$title, $content, $_SESSION["usuario"]]);
}

// Insertar comentarios
if ($_SERVER[REQUEST_METHOD]=="POST" && isset($_POST["new_comment"])){
    $title = $_POST["post_id"];
    $content = $_POST["comment"];
    $stmt = $pdo->prepare("INSERT INTO posts (post_id, comment, user_id) VALUES (?,?,?");
    $stmt->execute([$title, $content, $_SESSION["user_id"]]);
}

//Obtener publicaciones
$posts = $pdo->query("
SELECT posts.*, usuarios.usuarios
FROM posts
Join usuarios On posts.usuarios = usuarios
ORDER BY posts.created_at DESC
")->fetchAll(PDO::fetch_assoc);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palomitas y Opiniones</title>
</head>
<body>
    <h2>PALOMITAS Y OPINIONES</h2>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
