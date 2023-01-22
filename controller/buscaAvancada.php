<?php


class Anuncio{
    public $codigo;
    public $titulo;
    public $descricao;
    public $preco;
    public $dataHora;
    public $estado;
    public $imagePath;
    public function __construct($codigo, $titulo, $descricao, $preco, $dataHora,  $estado,  $imagePath){
      $this->codigo = $codigo;
      $this->titulo = $titulo;
      $this->descricao = $descricao;
      $this->preco = $preco;
      $this->dataHora = $dataHora;
      $this->estado = $estado;
        $this->imagePath = $imagePath;
    }
  }

  function pesquisaAvancada($titulo, $descricao, $preco,  $dataHora, $estado){
    require_once($_SERVER['DOCUMENT_ROOT'] . "/database/dbConnector.php");
    $pdo = getConnection();
  
    try {
      $sql = <<<SQL
      SELECT codigo, titulo, descricao, preco, dataHora,  estado
      FROM anuncio where titulo like ? and descricao like ? and preco > ? and dataHora like ? and estado like ? limit 6
      SQL;
    
      try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["%$titulo%", "%$descricao%", $preco, "%$dataHora%", "%$estado%"]);

        $row = $stmt->fetch();
        if (!$row) {
          return null;
        }
        $anuncios = array();
        while ($row) {
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
          $desc = (substr($row['descricao'], 0, 35)) . '...' ;
            $anuncios[] = new Anuncio($row['codigo'], $row['titulo'], $desc, $row['preco'], $row['dataHora'], $row['estado'], $imagePath);
          $row = $stmt->fetch();
        }
        
        return $anuncios;
      } 
      catch (Exception $e) {
        exit('Falha inesperada: ' . $e->getMessage());
      }
    } 
    catch (Exception $e) {
      exit('Falha inesperada: ' . $e->getMessage());
    }
  }

if(!empty($_GET)) {
    $titulo = $_GET['titulo'] ?? '';
    $descricao = $_GET['descricao'] ?? '';
    $preco = $_GET['preco'] ?? 10000;
    $dataHora = $_GET['data'] ?? '';
    $estado = $_GET['estado'] ?? '';

    $anuncios = pesquisaAvancada( $titulo, $descricao, $preco, $dataHora, $estado);
    if($anuncios != null){
        echo json_encode($anuncios);
    } else {
        http_response_code(400);
        echo json_encode(
            getResponseTemplate(false, ["Não foi possível encontrar anúncios com este título"])
        );
  }
}