<?php
// Inicia la sesión o reanuda una sesión existente
session_start();

// Destruye toda la información registrada en la sesión (cierra la sesión)
session_destroy();

// Redirige al usuario a la página de inicio de sesión
header("Location: login.php");
?>