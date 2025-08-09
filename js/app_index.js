  document.addEventListener("DOMContentLoaded", () => {
    carregarProdutos();
     });

  let todosProdutos = []; // Mantém a lista completa em memória
    
  function carregarProdutos() {
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
  console.error("Erro de rede:", err);
  alert("Erro ao conectar ao servidor. Veja o console.");
});
  }

  function renderTabela(lista) {
    const tbody = document.getElementById("tabela-retiradas");
    tbody.innerHTML = "";

    lista.forEach(prod => {
      tbody.innerHTML += `
        <tr style='text-align:center'>
          <td>${prod.Data} - ${prod.Hora}</td>
          <td>${prod.Colaborador}</td>
          <td style='text-align:left'>${prod.Nome}</td>
          <td>${prod.Quantidade}</td>
          <td>${prod.OrdemServico}</td> 
          <td>${prod.Serial}</td> 
        </tr>
      `;
    });
  }

  function filtrarTabela(termo) {
    const filtrados = todosProdutos.filter(p =>
      p.NomeProduto.toLowerCase().includes(termo)
    );
    renderTabela(filtrados);
  }