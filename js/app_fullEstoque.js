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
    fetch("codes/estoque_comp.php")
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
    const classeEstoque = (parseInt(prod.Disponivel) === 0) ? 'estoque-zero' : '';

    tbody.innerHTML += `
      <tr class="${classeEstoque}" style='text-align:center'>
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