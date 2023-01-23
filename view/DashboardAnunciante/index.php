<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="/view/DashboardAnunciante/css/index.css">
  <link rel="stylesheet" href="/css/global.css">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <title>Anunciante</title>
</head>
<body>
  <header>
    <div class="row">
      <div class="col">
        <a href="../../index.php"><img id="header-logo" src="../../assets/Logo256px.png" alt="OPG Commerce logo" width="64" height="64">
      </a>
      </div>
      <div class="col" id="header-user">
        <img id="header-logo" src="../../assets/user 2.png" alt="User Logo" width="64" height="64">
        
      </div>
    </div>
  </header>

  <nav>
  <?php 
    session_start();
      $auth = isset($_SESSION['auth']);
      if($auth){
        echo '<button id="header-button-logout" type="button" onclick="window.location = \'/controller/logout.php\'">sair</button>';
      }
    ?>
  </nav>

  <div class="container text-center">
    <div class="items-container">
      <a href="/view/cadastroAnunciante.php?edit=true">
        <div class="card-container">
          <p>Alterar Cadastro</p>
        </div>
      </a>
      <a href="/view/cadastroAnuncio">
        <div class="card-container">
          <p>Cadastrar novo Anúncio</p>
        </div>
      </a>
      <a href="/view/listaAnuncios.php">
        <div class="card-container">
          <p>Listar Anúncios</p>
        </div>
      </a>
      
      
      
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

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
</body>
</html>