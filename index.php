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
    <input type="text" class="form-control" id="codColaborador" name="codColaborador">

    <label>Colaborador</label>
    <input type="text" class="form-control" id="colaborador" name="colaborador" disabled>

    <label>Cód. Produto</label>
    <input type="text" class="form-control" id="codProduto" name="codProduto">

    <label>Produto</label>
    <input type="text" class="form-control" id="produto" name="produto" disabled>

    <label>Quantidade</label>
    <input type="number" class="form-control" id="quantidade" name="quantidade" min="1" value="1">

    <label>Ordem de Serviço</label>
    <input type="text" class="form-control" id="os" name="os">

    <label>Serial</label>
    <input type="text" class="form-control" id="serial" name="serial">

    <label>Observação</label>
    <textarea class="form-control" id="observacao" name="observacao" rows="3"></textarea>

    <button type="submit" class="btn btn-retirar w-100 mt-2">Retirar Produto</button>
  </form>

  <!-- Mensagem de retorno -->
  <div id="message" style="display:none; margin-top:10px;"></div>

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

<script src="js/app_index.js"></script>
<script>
document.getElementById('estoqueForm').addEventListener('submit', async function (e) {
  e.preventDefault();

  const btn = this.querySelector('button[type="submit"]');
  btn.disabled = true;
  const messageEl = document.getElementById('message');
  messageEl.style.display = 'none';

  // Pegamos os valores manualmente (disabled também tem .value)
  const dados = {
    codColaborador: document.getElementById('codColaborador').value.trim(),
    colaborador: document.getElementById('colaborador').value.trim(),
    codProduto: document.getElementById('codProduto').value.trim(),
    produto: document.getElementById('produto').value.trim(),
    quantidade: parseInt(document.getElementById('quantidade').value, 10) || 0,
    os: document.getElementById('os').value.trim(),
    serial: document.getElementById('serial').value.trim(),
    observacao: document.getElementById('observacao').value.trim()
  };

  // Validações simples
  if (!dados.codColaborador) {
    showMessage('Preencha o código do colaborador.', true);
    btn.disabled = false;
    return;
  }
  if (!dados.codProduto) {
    showMessage('Preencha o código do produto.', true);
    btn.disabled = false;
    return;
  }
  if (dados.quantidade <= 0) {
    showMessage('Quantidade deve ser maior que zero.', true);
    btn.disabled = false;
    return;
  }

  try {
    const resp = await fetch('codes/cadItem.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(dados)
    });

    const json = await resp.json();

    if (!resp.ok) {
      // Caso o PHP retorne 4xx/5xx com JSON { erro: '...' }
      const err = json.erro || JSON.stringify(json);
      showMessage('Erro: ' + err, true);
    } else if (json.sucesso) {
      showMessage(json.sucesso, false);
      document.getElementById('estoqueForm').reset();
    } else if (json.erro) {
      showMessage('Erro: ' + json.erro, true);
    } else {
      showMessage('Resposta inesperada do servidor.', true);
      console.log('Resposta:', json);
    }
  } catch (error) {
    console.error('Fetch error:', error);
    showMessage('Erro de conexão com o servidor. Tente novamente.', true);
  } finally {
    btn.disabled = false;
  }

  function showMessage(text, isError = false) {
    messageEl.style.display = 'block';
    messageEl.innerText = text;
    messageEl.style.color = isError ? '#721c24' : '#155724';
    messageEl.style.background = isError ? '#f8d7da' : '#d4edda';
    messageEl.style.border = '1px solid ' + (isError ? '#f5c6cb' : '#c3e6cb');
    messageEl.style.padding = '8px';
    messageEl.style.borderRadius = '4px';
  }
});
</script>

<script src="js/sidebar.js"></script>

</body>
</html>
