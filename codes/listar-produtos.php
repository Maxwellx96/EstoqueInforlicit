<?php
require("conn.php");

try {
    $conn = new PDO($dsn);
    $conn->setAttribute(attribute: PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION);

    // Ajuste para os nomes reais da sua tabela
    $sql = "SELECT * FROM ITENS WHERE ESTOQUE_DISP > 0"; 
    $stmt = $conn->query($sql);
    $produtos = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $nome = $row['NOME'] ?? null;
    $disp = $row['ESTOQUE_DISP'];
    $custo = $row['CUSTO'];
    $venda = $row['VENDA'];
    
    $disp = number_format($disp,0,'.','');
    $custo = number_format($custo,2,',','');
    $venda = number_format($venda,2,',','');
    // Sanitiza e converte encoding, se necessário
    if ($nome !== null) {
        $nome = mb_convert_encoding($nome, 'UTF-8', 'ISO-8859-1');
        $nome = preg_replace('/[^\PC\s]/u', '', $nome); // remove caracteres não imprimíveis
        $nome = trim($nome);
    }

    $produtos[] = [
        'Nome' => $nome,
        'Codigo' => $row['NUMERO'],
        'Categoria' =>$row['GRUPO'],
        'Disponivel' =>$disp,
        'Custo' => $custo,
        'Venda' => $venda
    ];
}


    echo json_encode($produtos);

} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro: ' . $e->getMessage()]);
}
?>
