<?php

class Anuncio{
  public $codigo;
  public $titulo;
  public $descricao;
  public $preco;
  public $dataHora;
  public $cep;
  public $bairro;
  public $cidade;
  public $estado;
  public $codCategoria;
  public $codAnunciante;
  public $imagePath;
  public $nomeCategoria;
  public $nomeAnunciante;

  public function __construct($codigo, $titulo, $descricao, $preco, $dataHora, $cep, $bairro, $cidade, $estado, $codCategoria, $codAnunciante, $imagePath, $nomeCategoria, $nomeAnunciante){
    $this->codigo = $codigo;
    $this->titulo = $titulo;
    $this->descricao = $descricao;
    $this->preco = $preco;
    $this->dataHora = $dataHora;
    $this->cep = $cep;
    $this->bairro = $bairro;
    $this->cidade = $cidade;
    $this->estado = $estado;
    $this->codCategoria = $codCategoria;
    $this->codAnunciante = $codAnunciante;
    $this->imagePath = $imagePath;
    $this->nomeCategoria = $nomeCategoria;
    $this->nomeAnunciante = $nomeAnunciante;
  }
}

function retornaAnuncio($codigo){
  require_once($_SERVER['DOCUMENT_ROOT'] . "/database/dbConnector.php");
  $pdo = getConnection();

  try {
    $sql = <<<SQL
    SELECT codigo, titulo, descricao, preco, dataHora, cep, bairro, cidade, estado, codCategoria, codAnunciante
    FROM anuncio where codigo =  ? 
    SQL;
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$codigo]);
    $row = $stmt->fetch();

    $anuncio = null;
    if (!$row) {
      return null;
    }
      $sqlImage = <<<SQL
      SELECT NomeArqFoto
      FROM foto where codigoAnuncio = ? limit 1
      SQL;
      $stmtImage = $pdo->prepare($sqlImage);
      $stmtImage->execute([$row['codigo']]);
      
      $rowImage = $stmtImage->fetch();
      $imagePath = $rowImage['NomeArqFoto'];

      if($imagePath == null){
        $imagePath = "default.png";
      }

      $sqlCategoria = <<<SQL
      SELECT nome
      FROM categoria where codigo = ?
      SQL;
      $stmtCategoria = $pdo->prepare($sqlCategoria);
      $stmtCategoria->execute([$row['codCategoria']]);
      $rowCategoria = $stmtCategoria->fetch();

      $sqlAnunciante = <<<SQL
      SELECT nome
      FROM anunciante where codigo = ?
      SQL;
      $stmtAnunciante = $pdo->prepare($sqlAnunciante);
      $stmtAnunciante->execute([$row['codAnunciante']]);
      $rowAnunciante = $stmtAnunciante->fetch();

      $anuncio = new Anuncio($row['codigo'], $row['titulo'], $row['descricao'], $row['preco'], $row['dataHora'], $row['cep'], $row['bairro'], $row['cidade'], $row['estado'], $row['codCategoria'], $row['codAnunciante'], $imagePath, $rowCategoria['nome'], $rowAnunciante['nome']);
      return $anuncio;
  }catch (Exception $e) {
    exit('Falha inesperada: ' . $e->getMessage());
  }
} 

$codigo = $_GET['codigo'] ?? '';
$anuncio = retornaAnuncio($codigo);
header('Content-type: application/json');
echo json_encode($anuncio);
?>