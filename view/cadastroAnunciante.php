<?php
session_start();

$auth = $_SESSION['auth'] ?? false;
$edit = $_GET['edit'] ?? false;
if(isset($_GET['edit']) && !$auth){
    http_response_code(403);
    $html = <<<HTML
    <h1>Forbidden</h1>
    <p>Você não tem permissão para acessar este recurso!
    HTML;
    die($html);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/cadastroAnunciante.css">
    <title>Cadastrar Anunciante</title>
    <style>
        #header-button {
          display: inline;
          float: right;
          margin-right: 64px;
          width: 160px;
          height: 48px;
          margin-top: 25px;
          background: rgb(66, 70, 77);
          border-radius: 10px;
          border: 0;
          padding: 0 16px;
          color: #fafafa;
          transition: background-color 0.2s;
    
    
        }
    
        header {
          height: 100px;
          background-color: #A9A9A9;
          display: block;
          position: relative;
        }
    
        #header-logo {
          display: inline;
          margin-left: 64px;
          margin-top: 12px;
        }
    
    
        footer {
          display: block;
          position: fixed;
          background-color: #A9A9A9;
          width: 100%;
          text-align: center;
          height: 100px;
          bottom: 0;
          margin: auto;
          left: 0;
        }
    
        footer p {
          padding: 24px 0;
        }
      </style>
</head>


<body>
    
<header>
    <a href="/index.html">
    <img id="header-logo" src="../assets/Logo256px.png" alt="OPG Commerce logo" width="64" height="64">    
    </a>
</header>

    <main>
        <div class="form-wrapper">
            <?php
            
            if(!$edit) {
                echo <<<HTML
                    <h1 class="title">Cadastrar Anunciante</h1>
                    <form name="cadastroAnunciante" method="post">
                    <div>
                        <label for="name">Nome: </label>
                        <input type="text" name="name" id="name">
                        <span class="msg span-name"></span>
                    </div>
                    <div>
                        <label for="cpf">CPF: </label>
                        <input type="text" name="cpf" id="cpf">
                        <span class="msg span-cpf"></span>
                    </div>
                    <div>
                        <label for="email">Email: </label>
                        <input type="email" name="email" id="email">
                        <span class="msg span-email"></span>
                    </div>
                    <div>
                        <label for="password">Senha: </label>
                        <input type="password" name="password" id="password">
                        <span class="msg span-password"></span>
                    </div>
                    <div>
                        <label for="confirm_password">Confirmar Senha: </label>
                        <input type="password" name="confirm_password" id="confirm_password">
                        <span class="msg span-confirm-password"></span>
                    </div>
                    <div>
                        <label for="phone">Telefone: </label>
                        <input type="tel" name="phone" id="phone">
                        <span class="msg span-phone"></span>
                    </div>
                    <div>
                        <button id="btn-cadastrar" type="button">Cadastrar</button>
                    </div>
                </form>
                HTML;
            } else {
                $nome = htmlspecialchars($_SESSION['nome']);
                $cpf = htmlspecialchars($_SESSION['cpf']);
                $email = htmlspecialchars($_SESSION['email']);
                $telefone = htmlspecialchars($_SESSION['telefone']);

                echo <<<HTML
                <h1 class="title">Atualização de dados</h1>
                <form name="cadastroAnunciante" method="post">
                    <div>
                        <label for="name">Nome: </label>
                        <input type="text" name="name" id="name" value="$nome">
                        <span class="msg span-name"></span>
                    </div>
                    <div>
                        <label for="cpf">CPF: </label>
                        <input type="text" name="cpf" id="cpf" value="$cpf">
                        <span class="msg span-cpf"></span>
                    </div>
                    <div>
                        <label for="email">Email: </label>
                        <input type="email" name="email" id="email" value="$email">
                        <span class="msg span-email"></span>
                    </div>
                    <div>
                        <label for="password">Senha: </label>
                        <input type="password" name="password" id="password">
                        <span class="msg span-password"></span>
                    </div>
                    <div>
                        <label for="confirm_password">Confirmar Senha: </label>
                        <input type="password" name="confirm_password" id="confirm_password">
                        <span class="msg span-confirm-password"></span>
                    </div>
                    <div>
                        <label for="phone">Telefone: </label>
                        <input type="tel" name="phone" id="phone" value="$telefone">
                        <span class="msg span-phone"></span>
                    </div>
                    <div>
                        <button id="btn-salvar" type="button">Salvar</button>
                    </div>
                </form>
            HTML;
            }
            ?>
            <div class="success"></div>
        </div>
    </main>
    <script src="./js/cadastroAnunciante.js"></script>
    

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