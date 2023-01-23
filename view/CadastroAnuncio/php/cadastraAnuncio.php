<?php

session_start();

$auth = $_SESSION['auth'] ?? false;
if(!$auth){
    http_response_code(403);
    $html = <<<HTML
    <h1>Forbidden</h1>
    <p>Você não tem permissão para acessar este recurso!
    HTML;
    die($html);
}

require "../conexaoMysql.php";
$pdo = mysqlConnect();

$titulo = $_POST["titulo"] ?? "";
$descricao = $_POST["descricao"] ?? "";
$preco = $_POST["preco"] ?? "";
$dataHora = $_POST["dataHora"] ?? "";
$cep = $_POST["cep"] ?? "";
$bairro = $_POST["bairro"] ?? "";
$cidade = $_POST["cidade"] ?? "";
$estado = $_POST["estado"] ?? "";
$codCategoria = $_POST["codCategoria"] ?? "";
$codAnunciante = $_SESSION['codigo'];
try {

  $sql = <<<SQL
  INSERT INTO cliente (titulo, descricao, preco, dataHora, 
  cep, bairro, cidade, estado, codCategoria, codAnunciante)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
  SQL;

  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    $titulo, $descricao, $preco, $dataHora,
    $cep, $bairro, $cidade, $estado, $codCategoria, $codAnunciante
  ]);
  
  exit();
} 
catch (Exception $e) {  
  //error_log($e->getMessage(), 3, 'log.php');
  if ($e->errorInfo[1] === 1062)
    exit('Dados duplicados: ' . $e->getMessage());
  else
    exit('Falha ao cadastrar os dados: ' . $e->getMessage());
}
