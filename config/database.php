<?php
class Database {
    public static function conectar() {
        $env = parse_ini_file(__DIR__ . '/../.env');

        if (!$env) {
            die("Error: No se ha encontrado el archivo .env. ");
        }

        $host = $env['DB_HOST'];
        $dbname = $env['DB_NAME'];
        $user = $env['DB_USER'];
        $pass = $env['DB_PASS'];

        try {
            $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC 
            ]);
            
            return $conexion;
            
        } catch (PDOException $e) {
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }
}
?>