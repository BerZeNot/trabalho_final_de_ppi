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
</head>
<body>
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
</body>
</html>