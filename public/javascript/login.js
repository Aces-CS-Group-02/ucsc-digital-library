const formButton = document.getElementById("hide-btn");
const pass = document.getElementById("password");

formButton.addEventListener("click", () => {
    if (pass.type === "password") {
        pass.type = "text";
        formButton.innerHTML = `<i class="fas fa-eye"></i>`;
    } else {
        pass.type = "password";
        formButton.innerHTML = `<i class="fas fa-eye-slash"></i>`;
    }
});

document.querySelector(".inputStyle").addEventListener("focus", () => {
    document.querySelector(".form-password").classList.toggle("add-border");
});

document.querySelector(".inputStyle").addEventListener("blur", () => {
    document.querySelector(".form-password").classList.toggle("add-border");
});