<?php
// Permite requisições de outras origens (CORS) e trata OPTIONS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Preflight request
    http_response_code(204);
    exit;
}

// Lê o corpo da requisição JSON
$input = json_decode(file_get_contents("php://input"), true);

// Validação mínima
$required = ['codColaborador', 'codProduto', 'quantidade'];
foreach ($required as $r) {
    if (!isset($input[$r]) || $input[$r] === '') {
        http_response_code(400);
        echo json_encode(['erro' => "Campo obrigatório ausente: $r"]);
        exit;
    }
}

// Caminho do banco (ajuste conforme seu ambiente)
// Use o caminho correto: .mdb ou .accdb
$db_path = realpath('C:\SHARMAQ\SHOficina\Estoque.accdb');
// Se seu arquivo for Dados.mdb troque a linha acima.

if (!$db_path) {
    http_response_code(500);
    echo json_encode(['erro' => 'Arquivo Access não encontrado no servidor. Verifique o caminho.']);
    exit;
}

// Se o MDB/ACCDB tiver senha, defina aqui:
// $db_pwd = '!(&&!!)&';
$db_pwd = ''; // deixe vazio se não houver senha

try {
    $driver = "Driver={Microsoft Access Driver (*.mdb, *.accdb)}";
    $dsn = "odbc:$driver;Dbq=$db_path";
    if (!empty($db_pwd)) {
        $dsn .= ";PWD=$db_pwd";
    }

    $conn = new PDO($dsn);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mapear valores do JSON
    $codCol = $input['codColaborador'];
    $colaborador = $input['colaborador'] ?? null;
    $codProd = $input['codProduto'];
    $produto = $input['produto'] ?? null;
    $quantidade = (int)$input['quantidade'];
    $os = $input['os'] ?? null;
    $serial = $input['serial'] ?? null;
    $observacao = $input['observacao'] ?? null;

    // Ajuste os nomes das colunas abaixo conforme sua tabela Access
    $sql = "INSERT INTO Log ([Colaborador], [Cod_Produto], [Produto], [Quantidade], [OrdemServico], [Serial])
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $colaborador,
        $codProd,
        $produto,
        $quantidade,
        $os,
        $serial,
    ]);

    echo json_encode(['sucesso' => 'Dados salvos com sucesso!']);

} catch (PDOException $e) {
    http_response_code(500);
    // Retorna mensagem de erro (útil para debug). Em produção, esconda detalhes sensíveis.
    echo json_encode(['erro' => 'Erro ao salvar: ' . $e->getMessage()]);
    exit;
}
