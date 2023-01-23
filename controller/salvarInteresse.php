<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/database/dbConnector.php");
$pdo = getConnection();

class Interesse {
  private $mensagem;
  private $dataHora;
  private $contato;
  private $codAnuncio;

  function __construct( $mensagem, $dataHora, $contato, $codAnuncio){
    $this->mensagem = $mensagem;
    $this->dataHora = $dataHora;
    $this->contato = $contato;
    $this->codAnuncio = $codAnuncio;
  }

  function getContato(){ return $this->contato; }
  
function isValid(){
  $validation = array(
      "valid" => true,
      "messages" => []
  );
  
  if($this->mensagem == ""){
      $validation ['valid'] = false;
      array_push($validation['messages'], "Informe a mensagem");            
  }
  
  return $validation;
}

function getParamsToSave(){
  $params = [
      $this->mensagem,
      $this->dataHora ,
      $this->contato ,
      $this->codAnuncio
  ];

  return $params;
}
}


header('Content-Type: application/json; charset=utf-8');
if(!empty($_POST)) {
    $mensagem         = $_POST['mensagem'] ?? "";
    $dataHora         =  date('Y-m-d H:i:s');
    $contato          = $_POST['contato'] ?? "";
    $codAnuncio       = $_POST['idAnuncio'] ?? "";

    
    $interesse = new Interesse( $mensagem, $dataHora, $contato, $codAnuncio);
    $validation = $interesse->isValid();
    
    if(!$validation['valid']){
        http_response_code(400);     
        echo json_encode(getResponseTemplate(false, $validation['messages']));
    } else {
        echo json_encode(saveInteresse($interesse));
    }

} else {
    http_response_code(400);
    echo json_encode(
        getResponseTemplate(false, ["É necessário fornecer os dados para o cadastro do interesse"])
    );
}


function saveInteresse(Interesse $int){
  require_once($_SERVER['DOCUMENT_ROOT'] . "/database/dbConnector.php");
  $pdo = getConnection();
  
  $intExists = InteresseExists($int, $pdo);
  if($intExists){
      return getResponseTemplate(false, ["Já existe um Interesse cadastrado com estes dados"]);
  }

  $query = <<<SQL
  INSERT INTO interesse (mensagem, dataHora, contato, codAnuncio)
  VALUES (?, ?, ?, ?);
  SQL;
  
  try {
      $statement = $pdo->prepare($query);
      if(!$statement->execute($int->getParamsToSave())){
          throw new Exception("Falha ao cadastrar o Interesse");
      }
      return getResponseTemplate(true,["Interesse cadastrado(a) com sucesso"]);
  } catch(Exception $e) {
      return getResponseTemplate(false,[$e->getMessage()]);
  }
}

function interesseExists(Interesse $int, PDO $pdo){
  $contato = $int->getContato();

  $query = <<<SQL
  SELECT COUNT(*) AS existe
  FROM interesse 
  WHERE contato = ?;
  SQL;

  $statement = $pdo->prepare($query);
  $statement->execute([$contato]);
  $row = $statement->fetch();
  $existe = $row['existe'];
  return $existe;
}

function getResponseTemplate($success = true, $messages = []) {
  return array(
      "success" => $success,
      "messages" => $messages
  );
}

?>