<?php
class Endereco
{
  public $cep;
  public $estado;
  public $bairro;
  public $cidade;

  function __construct($cep, $estado, $bairro, $cidade)
  {
    $this->estado = $cep;
    $this->estado = $estado;
    $this->bairro = $bairro;
    $this->cidade = $cidade;
  }
}

require "../../../database/connection/conexaoMysql.php";
$pdo = mysqlConnect();

$cep = $_GET["cep"] ?? "";

try {
  $sql = <<<SQL
  SELECT bairro, cidade, estado
  FROM baseEnderecosAjax
  WHERE cep = $cep
  SQL;

  $stmt = $pdo->query($sql);


  while($row = $statement->fetch()) {

    $endereco = new Endereco($row['cep'], $row['estado'], $row['bairro'], $row['cidade']);
    }

    header('Content-type: application/json');
    echo json_encode($endereco);
} 
catch (Exception $e) {
  exit('Ocorreu uma falha: ' . $e->getMessage());
}
?>