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
  <h4>📅 Relatório de Retiradas por Mês</h4>
  <div class="row g-2 mb-1">
    <div class="col-md-3">
      <label>Mês</label>
      <select class="form-select" id="mesFiltro">
        <option value="06">Junho</option>
        <option value="07">Julho</option>
        <option value="08">Agosto</option>
      </select>
    </div>
    <div class="col-md-3 d-flex align-items-center">
      <button class="btn btn-secondary w-100" onclick="filtrar()">Filtrar</button>
    </div>
  </div>

  <table class="table table-bordered table-striped mt-2">
    <thead class="table-secondary">
      <tr>
        <th>Data</th>
        <th>Colaborador</th>
        <th>Produto</th>
        <th>Qtd</th>
        <th>O.S.</th>
      </tr>
    </thead>
    <tbody id="resultadoFiltro">
      <tr><td>06/06/2025</td><td>Pedro</td><td>Correia Epson L4150</td><td>1</td><td>25884</td></tr>
      <tr><td>10/06/2025</td><td>Wellington</td><td>Kit Pickup L3150</td><td>1</td><td>25902</td></tr>
    </tbody>
  </table>
</div>

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
    fetch("codes/relatorios.php")
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
  alert("Erro ao conectar ao servidor. Veja o console.");
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

<script>
  function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('active');
  }
</script>


</body>
</html>
