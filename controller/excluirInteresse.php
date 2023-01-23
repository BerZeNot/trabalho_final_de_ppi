<?php


function excluirInteresse($codigo){
    require_once($_SERVER['DOCUMENT_ROOT'] . "/database/dbConnector.php");
    $pdo = getConnection();
    
      try {
        $sql = <<<SQL
        Delete from interesse where codigo = ?
        SQL;
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$codigo]);
            return true;

        } catch (Exception $e) {
            exit('Falha ao excluir : ' . $e->getMessage());
        }

      } 
      catch (Exception $e) {
        exit('Falha ao excluir anuncio: ' . $e->getMessage());
      }
  }

function getCodigoAnuncio($codigo){
    require_once($_SERVER['DOCUMENT_ROOT'] . "/database/dbConnector.php");
    $pdo = getConnection();
    
      try {
        $sql = <<<SQL
        SELECT codAnuncio FROM interesse where codigo = ?
        SQL;
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$codigo]);
            $row = $stmt->fetch();
            return $row['codAnuncio'];

        } catch (Exception $e) {
            exit('Falha ao excluir : ' . $e->getMessage());
        }

      } 
      catch (Exception $e) {
        exit('Falha ao excluir anuncio: ' . $e->getMessage());
      }
  }
if(!empty($_GET)) {
    $codigo = $_GET['codigo'] ?? '';
    $codAnuncio = getCodigoAnuncio($codigo);
     excluirInteresse($codigo);
    header("Location: /view/listaInteresses.php?codigo=$codAnuncio");
}
?>