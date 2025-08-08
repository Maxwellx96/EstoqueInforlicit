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



<script>
  document.addEventListener("DOMContentLoaded", () => {
    carregarProdutos();

    // Adiciona filtro dinâmico no campo de busca
    document.getElementById("buscaEstoque").addEventListener("input", function () {
      const termo = this.value.toLowerCase();
      filtrarTabela(termo);
    });
  });

  let todosProdutos = []; // Mantém a lista completa em memória

  function carregarProdutos() {
    fetch("codes/listar-produtos.php")
      .then(res => res.json())
      .then(data => {
        if (data.erro) {
          console.error("Erro:", data.erro);
          alert("Erro ao carregar dados: " + data.erro);
          return;
        }

        todosProdutos = data;
        renderTabela(todosProdutos);
      })
      .catch(err => {
  console.error("Erro de rede:", err);
  console.log("Erro ao conectar ao servidor. Veja o console.");
  window.location.reload();
});
  }

  function renderTabela(lista) {
    const tbody = document.getElementById("tabela-produtos");
    tbody.innerHTML = "";

    lista.forEach(prod => {
      tbody.innerHTML += `
        <tr style='text-align:center'>
          <td>${prod.Codigo}</td>
          <td style='text-align:left'>${prod.Nome}</td>
          <td>${prod.Categoria}</td>
          <td>${prod.Disponivel}</td>
          <td>R$ ${prod.Custo}</td>
          <td>R$ ${prod.Venda}</td>
        </tr>
      `;
    });
  }

  function filtrarTabela(termo) {
    const filtrados = todosProdutos.filter(p =>
      p.Nome.toLowerCase().includes(termo)
    );
    renderTabela(filtrados);
  }
</script>

</div>

<script>
  function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('active');
  }
</script>


</body>
</html>
