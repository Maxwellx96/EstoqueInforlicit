<?php
$db_path = realpath('C:\SHARMAQ\SHOficina\Estoque.accdb');
if (!$db_path) {
    die("Arquivo MDB não encontrado.");
}

$dsn = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=$db_path;";

try {
    $conn = new PDO($dsn);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conectado com sucesso!";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
