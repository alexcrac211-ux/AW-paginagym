<?php
// Configuración de ejemplo para la base de datos
// Renombra este archivo a config.php y completa los campos con tu configuración local.

$host = '127.0.0.1';
$db   = 'tu_base_de_datos';
$user = 'tu_usuario';
$pass = 'tu_contraseña'; 
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new Exception("Error de conexión: " . $e->getMessage());
}
?>
