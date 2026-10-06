<?php
require_once __DIR__ . '/../config/database.php';

$db = Database::conectar();

if ($db) {
    echo "Funciona ";
}
?>