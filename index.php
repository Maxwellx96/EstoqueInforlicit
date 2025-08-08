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

<!-- Painel principal -->
<div class="painel row" id="painel">
  <!-- Formulário -->
  <div class="col-md-4 form-section">
    <div class="text-center">
      <img src="https://inforlicit.com.br/wp-content/themes/inforlicit/img/inforlicit.svg" class="logo" alt="Inforlicit Logo">
    </div>
    <form id="estoqueForm">
      <label>Cód. Colaborador</label>
      <input type="text" class="form-control" name="codColaborador">

      <label>Colaborador</label>
      <input type="text" class="form-control" name="colaborador" disabled>

      <label>Cód. Produto</label>
      <input type="text" class="form-control" name="codProduto">

      <label>Produto</label>
      <input type="text" class="form-control" name="produto" disabled>

      <label>Quantidade</label>
      <input type="number" class="form-control" name="quantidade" min="1" value="1">

      <label>Ordem de Serviço</label>
      <input type="text" class="form-control" name="os">

      <label>Serial</label>
      <input type="text" class="form-control" name="serial">

      <label>Observação</label>
      <textarea class="form-control" name="observacao" rows="3"></textarea>

      <button type="button" class="btn btn-retirar w-100 mt-2" onclick="retirarProduto()">Retirar Produto</button>
    </form>
  </div>

  <!-- Histórico -->
  <div class="col-md-8">
    <h5>Histórico de Retiradas</h5>
    <div class="table-responsive historico">
      <table class="table table-bordered table-striped" id="tabelaHistorico">
        <thead class="table-secondary">
          <tr>
            <th>Data</th>
            <th>Colaborador</th>
            <th>Produto</th>
            <th>Qtd</th>
            <th>O.S.</th>
            <th>Serial</th>
          </tr>
        </thead>
        <tbody id="tabela-retiradas">
          <!-- Histórico será inserido aqui -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    carregarProdutos();
     });

  let todosProdutos = []; // Mantém a lista completa em memória
    
function carregarProdutos(tentativa = 1) {
  fetch("codes/retiradas.php")
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
      console.error(`Erro de rede (tentativa ${tentativa}):`, err);

      if (tentativa < 5) { // número máximo de tentativas
        console.log("Tentando novamente em 3 segundos...");
        setTimeout(() => carregarProdutos(tentativa + 1), 3000);
      } else {
        alert("Não foi possível carregar os dados após várias tentativas.");
      }
    });
}


  function renderTabela(lista) {
    const tbody = document.getElementById("tabela-retiradas");
    tbody.innerHTML = "";

    lista.forEach(prod => {
      tbody.innerHTML += `
        <tr style='text-align:center'>
          <td>${prod.Data}</td>
          <td>${prod.Colaborador}</td>
          <td style='text-align:left'>${prod.Nome}</td>
          <td>${prod.Quantidade}</td>
          <td>${prod.OrdemServico}</td>
          <td>${prod.Serial}</td>
        </tr>
      `;
    });
  }

</script>

<script>
  function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('active');
  }
</script>


</body>
</html>
