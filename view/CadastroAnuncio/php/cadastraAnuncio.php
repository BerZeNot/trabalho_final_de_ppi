<?php

//corrigir
require "../../database/dbConnector.php";
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
$codAnunciante = $_POST["codAnunciante"] ?? "";
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
  exit('Falha inesperada: ' . $e->getMessage());
}
