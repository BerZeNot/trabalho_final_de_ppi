<?php


function excluirAnuncio($codigo){
    require_once($_SERVER['DOCUMENT_ROOT'] . "/database/dbConnector.php");
    $pdo = getConnection();
  
      
    
      try {
        $sqlFoto = <<<SQL
        Delete from foto where codigoAnuncio = ?
        SQL;
        try {
            $stmtFoto = $pdo->prepare($sqlFoto);
            $stmtFoto->execute([$codigo]);

            $sql = <<<SQL
            Delete from anuncio where codigo = ?
            SQL;
        
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$codigo]);

        } catch (Exception $e) {
            exit('Falha ao excluir foto: ' . $e->getMessage());
        }

      } 
      catch (Exception $e) {
        exit('Falha ao excluir anuncio: ' . $e->getMessage());
      }
  }

if(!empty($_GET)) {
    $codigo = $_GET['codigo'] ?? '';

    excluirAnuncio($codigo);
    header("Location: /view/listaAnuncios.php");
}
?>