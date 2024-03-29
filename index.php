<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="/css/index.css">
  <link rel="stylesheet" href="/css/global.css">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  
</head>

<body>
  <header>
    <img id="header-logo" src="./assets/Logo256px.png" alt="OPG Commerce logo" width="64" height="64">

    <div id="buscaSimples" action="/" class="search-bar">
      <input type="text" placeholder="Pesquise aqui" id="pesquisa" name="pesquisa">
      <button id="buscaAvancada">
        <img id="search-bar-img" src="./assets/busca-avancada.png" alt="">
      </button>
      
      
    </div>
    <form id="buscaAvancadaForm" action="buscaAvancada.php">
      <input class="inpAvancados" type="text" id="titulo" name="titulo" placeholder="Titulo">
      <input class="inpAvancados" type="text" id="descricao" name="descricao"placeholder="Descricao">
      <input class="inpAvancados" type="text" id="preco" name="preco" placeholder="Valor Mínimo">
      <input class="inpAvancados" type="date" id="data" name="data">
      <select class="inpAvancados" name="estado" id="estado" name="estado" placeholder="Estado">
        <option value="">Estado</option>
        <option value="SP">SP</option>
        <option value="RJ">MG</option>
        <option value="MG">RJ</option>
      </select>
    </form>
    <button id="header-button" type="button">Entrar</button>

  </header>

  <nav>
  <?php 
    session_start();
      $auth = isset($_SESSION['auth']);
      if($auth){
        
        echo '<button id="header-button-logout" type="button" onclick="window.location = \'/controller/logout.php\'">sair</button>';
        echo '<button id="header-button" type="button" onclick="window.location = \'/view/DashboardAnunciante\'">Dashboard</button>';
      }else{
        echo '<button id="header-button" type="button" onclick="window.location = \'/view/login.html\'">Entrar</button>';
      }
    ?>
  </nav>
  
  <div class="landing-container">
    
    <section class="card-container">
      <template id="template">
        <div class="product-card">
          <img class="product-card-image" src="images/{{imagePath}}" alt="">
          <div class="product-card-info-container">
            <p class="product-card-title">{{titulo}}</p>
            <p class="product-card-description">{{descricao}}</p>
            <p class="product-card-price">R$ {{preco}}</p>
            <p class="product-card-code">{{codigo}}</p>
          </div>
          <div class="product-card-button-container">
            <button class="product-card-button" id="btnCompra" name="btnCompra">Comprar</button>
          </div>
        </div>
      </template>
    </section>
  </div>

  <aside id="categories-aside">
    <div class="aside-category"><img src="./assets/futebol-americano.png" alt="Esporte e Lazer"></div>
    <div class="aside-category"><img src="./assets/carro.png" alt="Esporte e Lazer"></div>
    <div class="aside-category"><img src="./assets/pet-house.png" alt="Esporte e Lazer"></div>
    <div class="aside-category"><img src="./assets/fone-de-ouvido.png" alt="Esporte e Lazer"></div>
    <div class="aside-category"><img src="./assets/smartphone.png" alt="Esporte e Lazer"></div>
    <div class="aside-category"><img src="./assets/cabide.png" alt="Esporte e Lazer"></div>
  </aside>
  <footer>
    <!--
    <a href="https://www.flaticon.com/br/icones-gratis/futebol" title="futebol ícones">Futebol ícones criados por Smashicons - Flaticon</a>
    <a href="https://www.flaticon.com/br/icones-gratis/carro" title="carro ícones">Carro ícones criados por Kiranshastry - Flaticon</a>
    <a href="https://www.flaticon.com/br/icones-gratis/lugar" title="lugar ícones">Lugar ícones criados por Freepik - Flaticon</a>
    <a href="https://www.flaticon.com/br/icones-gratis/musica" title="música ícones">Música ícones criados por IYAHICON - Flaticon</a>
    <a href="https://www.flaticon.com/br/icones-gratis/fones-de-ouvido" title="fones de ouvido ícones">Fones de ouvido ícones criados por smashingstocks - Flaticon</a>
    <a href="https://www.flaticon.com/br/icones-gratis/smartphone" title="smartphone ícones">Smartphone ícones criados por Anatoly - Flaticon</a>
    <a href="https://www.flaticon.com/br/icones-gratis/guarda-roupa" title="guarda roupa ícones">Guarda roupa ícones criados por kornkun - Flaticon</a>
    -->
    <p>&copy;copyright all rights reserved 2022</p>
  </footer>

  <script>

    let anuncios = [];
    let offset = 6;

    function pesquisaAvancadaAnuncio(){
      
          
      let titulo = document.querySelector("#titulo").value;
      let descricao = document.querySelector("#descricao").value;
      let preco = document.querySelector("#preco").value;
      let data = document.querySelector("#data").value;
      let estado = document.querySelector("#estado").value;

      xhr = new XMLHttpRequest();
      xhr.open("GET", "/controller/buscaAvancada.php?titulo=" + titulo + "&descricao=" + descricao + "&preco=" + preco + "&data=" + data + "&estado=" + estado);

      xhr.responseType = "json";
      xhr.onload = function () {
        if (xhr.status != 200 || xhr.response === null) {
          console.log("A resposta não pode ser obtida ");
          console.log(xhr.status);
          return;
        }
        anuncios = xhr.response;
        renderAnuncios(anuncios);
      }
      xhr.send();
    }
    
    function pesquisaAnuncio(pesquisa) {
      anuncios = [];
      
      const cards = document.querySelectorAll(".product-card");

      for (let card of cards) {
        card.remove();
      }

      let xhr = new XMLHttpRequest();
      xhr.open("GET", "/controller/pesquisaAnuncio.php?titulo=" + pesquisa);
      xhr.responseType = "json";
      xhr.onload = function () {
        if (xhr.status != 200 || xhr.response === null) {
          console.log("A resposta não pode ser obtida ");
          console.log(xhr.status);
          return;
      }
        anuncios = xhr.response;
        renderAnuncios(anuncios);
        
      }
      xhr.send();
    }

    function renderAnuncios(anuncios){
      
      const card = document.querySelector(".card-container");
      const cards = document.querySelectorAll(".product-card");
      for (let card of cards) {
        card.remove();
      }

      if(anuncios.length == 0){
        card.innerHTML = "<p>Nenhum anúncio encontrado</p>";
        return;
      }else{
        for (let anuncio of anuncios) {
          let html = template.innerHTML
            .replace("{{imagePath}}", anuncio.imagePath)
            .replace("{{titulo}}", anuncio.titulo)
            .replace("{{descricao}}", anuncio.descricao)
            .replace("{{codigo}}", anuncio.codigo)
            .replace("{{preco}}", anuncio.preco);
          card.insertAdjacentHTML("beforeend", html);
        };
      }
      
      const btnCompra = document.querySelectorAll(".product-card-button");

      btnCompra.forEach((btn) => {
        btn.onclick = () => {
          const codigo = btn.parentElement.parentElement.querySelector(".product-card-code").innerText;

          redirectDetalhesAnuncio(codigo);
        };
      });
    }

    window.onload = function () {
      pesquisaAnuncio("");
      const inputPesquisa = document.querySelector("#pesquisa");
      inputPesquisa.onkeyup = () => pesquisaAnuncio(inputPesquisa.value);

      const btnBuscaAvancada = document.querySelector("#buscaAvancada");
      btnBuscaAvancada.onclick = () => {
        document.getElementById('buscaAvancadaForm').style.display = "inline-block";
        document.getElementById('pesquisa').style.display = "none";
        document.getElementById('buscaSimples').style.display = "none";

      const impBuscaAvanvada = document.querySelectorAll(".inpAvancados");
      impBuscaAvanvada.forEach((inp) => {
        inp.onkeyup = () => {
          pesquisaAvancadaAnuncio();
        };
      });
      }
    }

    function redirectDetalhesAnuncio(codigo) {
    
      window.location.href = "/view/detalhesAnuncio.html?codigo=" + codigo;
    }
      

    window.onscroll = function () {
      if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
        loadAnuncios();
      }
    };

    function loadAnuncios() {
      let xhr = new XMLHttpRequest();
      xhr.open("GET", "/controller/maisAnuncios.php?offset=" + offset);
      offset += 6;
      xhr.responseType = "json";
      xhr.onload = function () {
        if (xhr.status != 200 || xhr.response === null) {
          console.log("A resposta não pode ser obtida ");
          console.log(xhr.status);
          return;
      }
        retornoJson = xhr.response;
        if(retornoJson.length != 0 && retornoJson != null){
          for(let anuncio of retornoJson){
            anuncios.push(anuncio);
          }
        }
      }
      xhr.send();
      renderAnuncios(anuncios);
    }

  </script>
</body>

</html>