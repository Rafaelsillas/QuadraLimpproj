// Obtém os elementos HTML
const ajudaButton = document.getElementById("ajudaButton");
const ajudaPopup = document.getElementById("ajudaPopup");
const fecharPopup = document.getElementById("fecharPopup");

// Mostra o pop-up de ajuda ao clicar no botão
ajudaButton.addEventListener("click", () => {
    ajudaPopup.style.display = "block";
});

// Fecha o pop-up ao clicar no botão de fechar
fecharPopup.addEventListener("click", () => {
    ajudaPopup.style.display = "none";
});

// Fecha o pop-up ao clicar fora dele
window.addEventListener("click", (event) => {
    if (event.target === ajudaPopup) {
        ajudaPopup.style.display = "none";
    }
});