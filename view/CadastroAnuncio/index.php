<?php

session_start();

if(!$_SESSION['auth']){
  http_response_code(403);
  $response = <<<RES
  <h1>Forbidden</h1>
  <p>Você não tem permissão para acessar esta página!</p>
  RES;
  die($response);
}

$nome = $fn = explode(" ", $_SESSION['nome'])[0];

$categorias = buscaCategorias();

function buscaCategorias(){

  $categorias  = array(
    "1" => "Veículo",
    "2" => "Eletroeletrônico",
    "3" => "Imóvel",
    "4" => "Móvel",
    "5" => "Vestuário",
    "6" => "Outro",
  );

  return $categorias;

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="/view/CadastroAnuncio/css/index.css">
  <link rel="stylesheet" href="../../css/global.css">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <title>Cadastro Anúncio</title>
</head>

<body>
  <header>
    <div class="row">
      <div class="col">
        <a href="../index.php"><img id="header-logo" src="../../assets/Logo256px.png" alt="OPG Commerce logo" width="64" height="64"></a>
      </div>
      <div class="col" id="header-user">
        <img id="header-logo" src="../../assets/user 2.png" alt="User Logo" width="64" height="64">
        <p><?php echo $nome; ?></p>
      </div>
    </div>
  </header>

  <nav>
  <button id="header-button-logout" type="button" onclick="window.location = '/controller/logout.php'">sair</button>
  </nav>
  
  <main class="container">
    <form enctype="multipart/form-data" action="./php/cadastraAnuncio.php" method="post">
      <fieldset>
        <legend>Dados do anúncio</legend>
        <div class="row">
          <div class="col-md-6">
            <div>
              <label class="form-label" for="titulo">Título</label>
              <input class="form-control" type="text" name="titulo" id="titulo" required>
            </div>
            <div>
              <label class="form-label" for="preco">Preço</label>
              <input class="form-control" type="text" name="preco" id="preco" required>
            </div>
            <div>
              <label class="form-label" for="categoria">Categoria</label>
              <select class="form-select" name="categoria" id="categoria" required>
                
              <?php
                foreach($categorias as $value => $name){
                  echo <<<HTML
                    <option value="$value">$name</option>;
                  HTML;
                }
              ?>

              </select>
            </div>
          </div>
          <div class="col-md-6">
            <label for="descricao">Descrição</label>
            <textarea class="form-control" name="descricao" id="descricao" cols="30" rows="7" placeholder="Descreva o produto" required></textarea>
          </div>
        </div>
      </fieldset>
      <hr>
      <fieldset class="mt-3">
        <legend>Dados de endereço</legend>
        <div class="row">
          <div class="col-md-2">
            <div>
              <label class="form-label" for="cep">CEP</label>
              <input class="form-control" type="text" name="cep" id="cep" placeholder="38400-100" required>
            </div>
          </div>
          <div class="col-md-4">
            <div>
              <label class="form-label" for="bairro">Bairro</label>
              <input class="form-control" type="text" name="bairro" id="bairro" placeholder="Santa Mônica" required>
            </div>
          </div>
          <div class="col-md-4">
            <div>
              <label class="form-label" for="cidade">Cidade</label>
              <input class="form-control" type="text" name="cidade" id="cidade" placeholder="Uberlândia" required>
            </div>
          </div>
          <div class="col-md-2">
            <div>
              <label class="form-label" for="estado">Estado</label>
              <input class="form-control" type="text" name="estado" id="estado" placeholder="MG" required>
            </div>
          </div>
          <div class="col-md-6">

          </div>
        </div>
      </fieldset>
      <hr>
      <fieldset class="mt-3">
        <legend>Outros dados</legend>
        <div class="row">
          <div class="col-md-6">
            <label class="form-label" for="imagens">Imagens</label>
            <input class="form-control" type="file" name="imagens" id="imagens" multiple required>
          </div>
          <div class="col-md-6">
            <br>
            <button class="mt-2 btn btn-primary" type="submit">Cadastrar Anúncio</button>
          </div>
        </div>
      </fieldset>
    </form>
  </main>

</body>
<script src="/view/CadastroAnuncio/js/index.js"></script>
</html>