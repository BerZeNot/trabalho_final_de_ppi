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

class Categoria
{
  public $id;
  public $nome;
  public $descricao;

  function __construct($id, $nome, $descricao)
  {
    $this->id = $id;
    $this->nome = $nome;
    $this->descricao = $descricao;
  }
}

require "../../../database/connection/conexaoMysql.php";
$pdo = mysqlConnect();

try {
  $sql = <<<SQL
  SELECT codigo, nome, descricao
  FROM categoria
  SQL;

  $stmt = $pdo->query($sql);

  $categorias = null;

  while($row = $statement->fetch()) {

    $categoria = new Categoria($row['codigo'], $row['nome'], $row['descricao']);

    $categorias[] = $categoria;
  }

    header('Content-type: application/json');
    echo json_encode($categorias);
} 
catch (Exception $e) {
  exit('Ocorreu uma falha: ' . $e->getMessage());
}
?>