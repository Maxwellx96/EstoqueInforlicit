<?php
require("conn_ret.php");

try {
    $conn = new PDO($dsn);
    $conn->setAttribute(attribute: PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION);

    // Ajuste para os nomes reais da sua tabela
    $sql = "SELECT * FROM Log"; 
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
