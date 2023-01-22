<?php
require ("../database/dbConnector.php");
require ("../model/Anunciante.php");
require ("../util/util.php");

header('Content-Type: application/json; charset=utf-8');

if(!empty($_POST)) {
    $email = $_POST['email'] ?? "";
    $password = $_POST['password'] ?? "";
    
    $response = findAnuncianteByEmail($email);
    if($response['success']){
        $anunciante = $response['content'];
        
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $savedPasswordHash = $anunciante->getPassword();
        
        $passwordsMatch = password_verify($password, $savedPasswordHash);

        if($passwordsMatch){
            session_start();
            $_SESSION['codigo'] = $anunciante->getId();
            $_SESSION['nome'] = $anunciante->getName();
            $_SESSION['cpf'] = $anunciante->getCpf();
            $_SESSION['email'] = $anunciante->getEmail();
            $_SESSION['telefone'] = $anunciante->getTelephone();
            $_SESSION['auth'] = true;
            
            $response['content'] = array("redirectPath" => "/");
            echo json_encode($response);
        } else {
            array_push($response['messages'], "Usuário ou senha incorretos");
            $response['success'] = false;
            $response['content'] = null;
            echo json_encode($response);
        }       

    } else {
        echo json_encode($response);
    }

} else {
    http_response_code(400);
    echo json_encode(
        getResponseTemplate(false, ["É necessário fornecer os dados de login"])
    );
}


function findAnuncianteByEmail($email){
    $pdo = getConnection();

    $query = <<<SQL
    SELECT * FROM anunciante
    WHERE email = ?
    SQL;
    
    $response = getResponseTemplate(true, [], null);

    try {
        $stmt = $pdo->prepare($query);
        if(!$stmt->execute([$email])) {
            throw new Exception("Falha ao buscar anunciante");
        }


        if($row = $stmt->fetch()){
            $anunciante = new Anunciante(
                $row['codigo'],
                $row['nome'],
                $row['cpf'],
                $row['email'],
                $row['senha'],
                $row['senha'],
                $row['telefone']
            );
            $response['content'] = $anunciante;
            return $response;
        } else {
            $response['success'] = false;
            array_push($response['messages'], "Usuário ou senha incorretos");
            return $response;
        }

    } catch (Exception $e) {
        $response['success'] = false;
        array_push($response['messages'], $e->getMessage());
        return $response;
    }
}
?>