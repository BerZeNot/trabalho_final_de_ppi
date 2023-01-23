<?php
require ("../model/Anunciante.php");
require ("../util/util.php");
session_start();
// Início do tratamento da requisição
header('Content-Type: application/json; charset=utf-8');
if(!empty($_POST)) {
    $name             = $_POST['name'] ?? "";
    $cpf              = $_POST['cpf'] ?? "";
    $email            = $_POST['email'] ?? "";
    $password         = $_POST['password'] ?? "";
    $confirm_password = $_POST['confirm_password'] ?? "";
    $phone            = $_POST['phone'] ?? "";
    
    $update = $_GET['update'] ?? false;
    
    if($update){
        $anunciante = new Anunciante($_SESSION['codigo'], $name, $cpf, $email, $password, $confirm_password, $phone);
    } else {
        $anunciante = new Anunciante(0, $name, $cpf, $email, $password, $confirm_password, $phone);
    }
    
    $validation = $anunciante->isValid();
    

    if(!$validation['valid']){
        http_response_code(400);     
        echo json_encode(getResponseTemplate(false, $validation['messages']));
    } else {

        if($update){
            echo json_encode(updateAnunciante($anunciante));
        } else {
            echo json_encode(saveAnunciante($anunciante));
        }
    }

} else {
    http_response_code(400);
    echo json_encode(
        getResponseTemplate(false, ["É necessário fornecer os dados para o cadastro do anunciante"])
    );
}

function saveAnunciante(Anunciante $adv){
    require_once($_SERVER['DOCUMENT_ROOT'] . "/database/dbConnector.php");
    $pdo = getConnection();
    
    $advExists = anuncianteExists($adv, $pdo);
    if($advExists){
        return getResponseTemplate(false, ["Já existe um anunciante cadastrado com estes dados"]);
    }

    $query = <<<SQL
    INSERT INTO anunciante (nome, cpf, email, senha, telefone) 
    VALUES (?, ?, ?, ?, ?);
    SQL;
    
    try {
        $statement = $pdo->prepare($query);
        if(!$statement->execute($adv->getParamsToSave())){
            throw new Exception("Falha ao cadastrar o anunciante");
        }
        return getResponseTemplate(true,["Anunciante cadastrado(a) com sucesso"]);
    } catch(Exception $e) {
        return getResponseTemplate(false,[$e->getMessage()]);
    }
}

function updateAnunciante(Anunciante $adv){
    require_once($_SERVER['DOCUMENT_ROOT'] . "/database/dbConnector.php");
    
    $pdo = getConnection();
    
    $query = <<<SQL
    UPDATE anunciante 
    SET nome = ?, cpf = ?, senha = ?, telefone = ? 
    where codigo = ?;
    SQL;
    
    try {
        $statement = $pdo->prepare($query);
        $params = $adv->getParamsToUpdate();
        array_push($params, $_SESSION['codigo']);
        
        if(!$statement->execute($params)){
            throw new Exception("Falha ao cadastrar o anunciante");
        }
        return getResponseTemplate(true,["Anunciante Atualizado(a) com sucesso"]);
    } catch(Exception $e) {
        return getResponseTemplate(false,[$e->getMessage()]);
    }
}

function anuncianteExists(Anunciante $adv, PDO $pdo){
    $email = $adv->getEmail();
    $cpf = $adv->getCpf();

    $query = <<<SQL
    SELECT COUNT(nome) as existe
    FROM anunciante 
    WHERE email = ?
        OR cpf = ?;
    SQL;

    $statement = $pdo->prepare($query);
    $statement->execute([$email, $cpf]);
    $row = $statement->fetch();
    $existe = $row['existe'];

    return $existe;
}

?>