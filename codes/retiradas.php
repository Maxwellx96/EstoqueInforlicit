<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

// Caminho do banco Access (.accdb)
$db_path = realpath('//192.168.1.200/SHOficina/Estoque.accdb');

if (!$db_path) {
    echo json_encode(['erro' => 'Arquivo ACCDB não encontrado.']);
    exit;
}

$dsn = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=$db_path;";

try {
    $conn = new PDO($dsn);
    $conn->setAttribute(attribute: PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION);

    $meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    $dataAtual = date('j');
    $mesNome = $meses[$dataAtual - 1];

    // Ajuste para os nomes reais da sua tabela
    $sql = "SELECT * FROM Log WHERE mes = '$mesNome' ORDER BY Data Desc"; 
    $stmt = $conn->query($sql);
    $produtos = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $produtoNome = $row['Produto'] ?? null;
  
   // Sanitiza e converte encoding, se necessário
    if ($produtoNome !== null) {
        $produtoNome = mb_convert_encoding($produtoNome, 'UTF-8', 'ISO-8859-1');
        $produtoNome = preg_replace('/[^\PC\s]/u', '', $produtoNome); // remove caracteres não imprimíveis
        $produtoNome = trim($produtoNome);
    }

    $produtos[] = [
        'Nome' => $produtoNome,
        'Data' => $row['Data'],
        'Colaborador' => $row['Colaborador'],
        'Quantidade' => $row['Quantidade'],
        'OrdemServico' => $row['OrdemServico'],
        'Serial' => $row['Serial']
    ];
}
    echo json_encode($produtos);

} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro: ' . $e->getMessage()]);
}
?>
