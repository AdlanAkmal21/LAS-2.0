const sign_in_btn = document.querySelector("#sign-in-btn");
const forget_btn = document.querySelector("#forget-btn");
const container = document.querySelector(".container");

forget_btn.addEventListener("click", () => {
    container.classList.add("forget-mode");
});

sign_in_btn.addEventListener("click", () => {
    container.classList.remove("forget-mode");
});
