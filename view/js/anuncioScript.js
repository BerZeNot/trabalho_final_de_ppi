var tempo = 3500;

window.onload = function () { 
    const urlSearchParams = new URLSearchParams(window.location.search);
    $codigo = Object.fromEntries(urlSearchParams.entries()).codigo;
    buscaAnuncio($codigo);
}

function btnInteresse() {
    let codigo = document.getElementById('codigo').innerHTML;
    document.getElementById('interesse').style.display = "block";
    document.getElementById('tenhoInteresse').style.display = "none";
    document.getElementById("idAnuncio").value = codigo;
 }

function buscaAnuncio(codigo){
        xhr= new XMLHttpRequest();
        xhr.open("GET", "/controller/buscaAnuncio.php?codigo=" + codigo, true);
        xhr.responseType = "json";
        xhr.onload = function(){
            if (xhr.status == 200){
                var anuncio = xhr.response;
                document.getElementById("titulo").innerHTML = anuncio.titulo;
                document.getElementById("descricao").innerText = anuncio.descricao;
                document.getElementById("preco").innerHTML = "$ " + anuncio.preco;
                document.getElementById("cep").innerHTML = anuncio.cep;
                document.getElementById("bairro").innerHTML = anuncio.bairro;
                document.getElementById("cidade").innerHTML = anuncio.cidade;
                document.getElementById("estado").innerHTML = anuncio.estado;
                document.getElementById("categoria").innerHTML = anuncio.nomeCategoria;
                document.getElementById("anunciante").innerHTML = anuncio.nomeAnunciante;
                document.getElementById("imagem").src = "/images/" +anuncio.imagePath;
                document.getElementById("codigo").innerHTML = anuncio.codigo;

            }else{
                alert("Erro ao carregar anuncio");
            }
        }
        xhr.onerror = function () {
            console.error("Erro de rede - requisição não finalizada");
        };
        xhr.send();
}

