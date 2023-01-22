<?php
require "../../../database/connection/conexaoMysql.php";

$pdo = mysqlConnect();

$id = $_POST["id"] ?? "";

try {

  $sql = <<<SQL
  DELETE FROM anuncio
  WHERE codigo = ?
  LIMIT 1
  SQL;

  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id]);

  // Adicionar redirecionamento para lista de anuncios

  // header("location:");
  exit();
} 
catch (Exception $e) {  
  exit('Falha inesperada: ' . $e->getMessage());
}
