<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

// Caminho do banco Access (.accdb)
$db_path = realpath('C:\SHARMAQ\SHOficina\Estoque.accdb');

if (!$db_path) {
    echo json_encode(['erro' => 'Arquivo ACCDB não encontrado.']);
    exit;
}

$dsn = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=$db_path;";

?>