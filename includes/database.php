<?php

$db = mysqli_connect(
    $_ENV['DB_HOST'], 
    $_ENV['DB_USER'], 
    $_ENV['DB_PASS'], 
    $_ENV['DB_BD']
);


if (!$db) {
    echo "Error no se pudo conectar";
    exit;
}