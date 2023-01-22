document.addEventListener("DOMContentLoaded", () => {

    document.getElementById("bt-login")
        .addEventListener("click", tryLogin);
    
    document.getElementById("bt-signup")
        .addEventListener("click", signUp);
});

async function tryLogin(){
    let form = document.querySelector("form");

    let valid = validaDadosDoForm(form);

    if(!valid)
        return;

    const formData = new FormData(form);

    const options = {
        method: "POST",
        body: formData
    }

    const response = await fetch("/controller/login.php", options);
    const data = await response.json();
    if(data.success){
        window.location = data.content.redirectPath;
    } else {
        document.querySelector(".message-box").innerText = data.messages[0];
    }
}

function signUp(){
    window.location = "/view/cadastroAnunciante.php";
}

function validaDadosDoForm(form){
    cleanMessages();
    
    let valid = true;
    
    if(form.email.value == ""){
        valid = false;
        document.querySelector(".span-email").innerText = "Digite o e-mail.";
    }

    if(form.password.value == ""){
        valid = false;
        document.querySelector(".span-password").innerText = "Digite a senha.";
    }

    return valid;
}

function cleanMessages() {
    document.querySelectorAll(".msg").forEach(msg => {
        msg.innerText = "";
    });
}