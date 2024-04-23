const body = document.querySelector("body");
const sidebar = body.querySelector(".sidebar");
const toggle = body.querySelector(".toggle");
const searchBtn = body.querySelector(".search-box");
const modeSwitch = body.querySelector(".toggle-switch");
const modeText = body.querySelector(".mode-text");
const subMenu = document.getElementById("subMenu");

// Verifica se há um valor armazenado no Local Storage para o modo (claro ou escuro)
const storedMode = localStorage.getItem("mode");
if (storedMode === "dark") {
  body.classList.add("dark");
  modeText.innerText = "Modo Claro";
} else {
  modeText.innerText = "Modo Escuro";
}

toggle.addEventListener("click", () => {
  sidebar.classList.toggle("close");
});

modeSwitch.addEventListener("click", () => {
  body.classList.toggle("dark");
  // Salva o estado do modo no Local Storage
  if (body.classList.contains("dark")) {
    localStorage.setItem("mode", "dark");
    modeText.innerText = "Modo Claro";
  } else {
    localStorage.setItem("mode", "light");
    modeText.innerText = "Modo Escuro";
  }
});

function togglePerfil() {
  subMenu.classList.toggle("open-menu");
}

document.addEventListener("DOMContentLoaded", function () {
  const modoIcone = document.getElementById("modoIcone");
  const body = document.body; // Defina 'body' para referenciar o elemento HTML do corpo

  // Recupere o valor armazenado no localStorage e aplique o modo
  const storedIcon = localStorage.getItem("modoIcone");
  if (storedIcon === "dark") {
    body.classList.add("dark");
  }

  modoIcone.addEventListener("click", () => {
    // Coloque o código existente aqui para alternar o modo e atualizar o Local Storage
    body.classList.toggle("dark");
    // Atualize o localStorage com o modo atual
    if (body.classList.contains("dark")) {
      localStorage.setItem("modoIcone", "dark");
    } else {
      localStorage.removeItem("modoIcone");
    }
  });
});

document.getElementById("seletorArquivos").addEventListener("click", function () {
  document.getElementById("inputArquivo").click()
});
