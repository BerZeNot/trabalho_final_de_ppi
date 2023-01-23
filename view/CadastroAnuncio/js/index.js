document.addEventListener("DOMContentLoaded", () => {
    const fieldCEP = document.querySelector("#cep");
    fieldCEP.addEventListener("change", () => buscaEndereco(fieldCEP.value))
})

async function buscaEndereco(cep) {
    
    if(cep.length != 9)
        return;

    try {
        const res = await fetch(`/view/CadastroAnuncio/php/BuscaEndereco.php?cep=${cep}`);
        
        if(!res.ok)
            throw new Error("Falha inesperada: " + res.status);
        
        const data = await res.json();
        
        if(data.cep != "") {
            document.querySelector("#cep").value = data.cep;
            document.querySelector("#bairro").value = data.bairro;
            document.querySelector("#cidade").value = data.cidade;
            document.querySelector("#estado").value = data.estado;
        } else {
            document.querySelector("#cep").value = "";
            document.querySelector("#bairro").value = "";
            document.querySelector("#cidade").value = "";
            document.querySelector("#estado").value = "";
        }
    } catch (error) {
        console.error(error);
    }   
}