<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Controle de Estoque</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/main.css" rel="stylesheet">
</head>
<body>

<!-- Ícone do menu -->
<div id="menuToggle" onclick="toggleSidebar()">☰</div>

<!-- Menu lateral -->
<div id="sidebar">
  <h4>Menu</h4>
  <a href="index.php">Dashboard</a>
  <a href="produtos.php">Produtos</a>
  <a href="estoque.php">Estoque</a>
  <a href="relatorios.php">Relatórios</a>
  <a href="#">Sair</a>
</div>

<div id="sidebar">
  <a href="#" >Produtos</a>
  <a href="#" onclick="carregarPagina('estoque.html')">Estoque</a>
  <a href="#" onclick="carregarPagina('relatorios.html')">Relatórios</a>
</div>

<!-- Painel principal -->
<div class="painel row" id="painel">
  <h4>📦 Produtos Disponíveis</h4>

<div class="mb-3 mt-3">
  <label for="buscaEstoque" class="form-label">Buscar por nome:</label>
  <input type="text" id="buscaEstoque" class="form-control" placeholder="Digite para buscar..." />
</div>

<table class="table table-bordered table-striped mt-3">
  <thead class="table-secondary">
    <tr style='text-align:center'>
      <th>Código</th>
      <th style='text-align:left'>Produto</th>
      <th>Categoria</th>
      <th>Disponível</th>
      <th>Custo</th>
      <th>Venda</th>
    </tr>
  </thead>
  <tbody id="tabela-produtos">
    <!-- Preenchido via JS -->
  </tbody>
</table>

<script src="js/app_dispEstoque.js"></script>
<script src="js/sidebar.js"></script>

</body>
</html>
