<?php
require "../../../database/connection/conexaoMysql.php";

$pdo = mysqlConnect();

$interesseId = $_POST["interesseId"] ?? "";

try {

  $sql = <<<SQL
  DELETE FROM interesse
  WHERE codigo = ?
  LIMIT 1
  SQL;

  $stmt = $pdo->prepare($sql);
  $stmt->execute([$interesseId]);

  // Adicionar redirecionamento para lista de anuncios

  // header("location:");
  exit();
} 
catch (Exception $e) {  
  exit('Falha inesperada: ' . $e->getMessage());
}
