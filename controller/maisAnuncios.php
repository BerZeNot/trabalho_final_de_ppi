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
  
    public function __construct($codigo, $titulo, $descricao, $preco, $dataHora, $cep, $bairro, $cidade, $estado, $codCategoria, $codAnunciante, $imagePath){
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
    }
  }

  function maisAnuncios($offset){
    require_once($_SERVER['DOCUMENT_ROOT'] . "/database/dbConnector.php");
    $pdo = getConnection();
    
    try {
      $sql = <<<SQL
      SELECT codigo, titulo, descricao, preco, dataHora, cep, bairro, cidade, estado, codCategoria, codAnunciante
      FROM anuncio limit 6 offset ?
      SQL;
    
      try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["$offset"]);
        $row = $stmt->fetch();

        $anuncios = array();
        if (!$row) return $anuncios;
        
        while ($row != null) {
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
            $anuncios[] = new Anuncio(
                $row['codigo'], $row['titulo'], $desc,
                $row['preco'], $row['dataHora'], $row['cep'], 
                $row['bairro'], $row['cidade'], $row['estado'], 
                $row['codCategoria'], $row['codAnunciante'], $imagePath);
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
    $offset = $_GET['offset'] ?? '';

    $anuncios = maisAnuncios($offset);
    if($anuncios != null){
        echo json_encode($anuncios);
    } else {
        http_response_code(400);
        echo json_encode(
            getResponseTemplate(false, ["Não foi possível encontrar anúncios com este título"])
        );
}
}

function getResponseTemplate($success = true, $messages = []) {
    return array(
        "success" => $success,
        "messages" => $messages
    );
}