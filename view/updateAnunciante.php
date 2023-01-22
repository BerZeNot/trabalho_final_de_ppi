<?php

//corrigir
require "../conexaoMysql.php";
$pdo = mysqlConnect();

$id = $_POST["id"] ?? "";
$nome = $_POST["nome"] ?? "";
$cpf = $_POST["cpf"] ?? "";
$telefone = $_POST["telefone"] ?? "";
$senha = $_POST["senha"] ?? "";

$hashsenha = password_hash($senha, PASSWORD_DEFAULT);
try {

  //Considerar aqui fazer um select para o caso de o usuário enviar os campos todos vazios, mesmo tendo sido pré-preenchidos no cadastro.

  $sql = <<<SQL
  UPDATE employees 
  SET nome = ?,
  cpf = ?,
  telefone ?,
  senha ?
  WHERE codigo = ?;
  SQL;

  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    $nome, $cpf, $telefone, $hashsenha, $id
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
