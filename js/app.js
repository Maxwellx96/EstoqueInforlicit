function carregarPagina(nome) {
  const painel = document.getElementById("painel");
  const arquivo = `page/${nome}.html`;

  // Atualiza o hash da URL (sem recarregar a página)
  window.location.hash = nome;

  fetch(arquivo)
    .then(res => {
      if (!res.ok) throw new Error("Erro ao carregar: " + arquivo);
      return res.text();
    })
    .then(html => {
      painel.innerHTML = html;
    })
    .catch(err => {
      painel.innerHTML = `<div class="alert alert-danger">${err.message}</div>`;
    });
}

// Quando a página é carregada (ou atualizada), verifica o hash na URL
document.addEventListener("DOMContentLoaded", () => {
  const hash = window.location.hash.replace("#", "");

  if (hash) {
    carregarPagina(hash); // Ex: #estoque → estoque.html
  } else {
    carregarPagina("home"); // Padrão: home.html
  }
});
