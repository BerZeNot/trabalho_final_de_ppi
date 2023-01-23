<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Ex2</title>
    <style>
        #header-button {
          display: inline;
          float: right;
          margin-right: 64px;
          width: 160px;
          height: 48px;
          margin-top: 25px;
          background: rgb(66, 70, 77);
          border-radius: 10px;
          border: 0;
          padding: 0 16px;
          color: #fafafa;
          transition: background-color 0.2s;
    
    
        }
    
        header {
          height: 100px;
          background-color: #A9A9A9;
          display: block;
          position: relative;
        }
    
        #header-logo {
          display: inline;
          margin-left: 64px;
          margin-top: 12px;
        }
    
    
        footer {
          display: block;
          position: fixed;
          background-color: #A9A9A9;
          width: 100%;
          text-align: center;
          height: 100px;
          bottom: 0;
          margin: auto;
          left: 0;
        }
    
        footer p {
          padding: 24px 0;
        }

        #header-button-logout {
            display: inline;
            float: right;
            margin-right: 10px;
            width: 100px;
            height: 48px;
            margin-top: 25px;
            background: rgb(195, 86, 53);
            border-radius: 10px;
            border: 0;
            padding: 0 16px;
            color: #fafafa;
            transition: background-color 0.2s;


}
      </style>
</head>


<body>
    <header>
        <a href="/index.html">
        <img id="header-logo" src="../assets/Logo256px.png" alt="OPG Commerce logo" width="64" height="64">    
        </a>
    </header>

    <nav>
        <button id="header-button-logout" type="button" onclick="window.location = '/controller/logout.php'">sair</button>
        <button id="header-button" type="button" onclick="window.location = '/view/DashboardAnunciante'">Dashboard</button>;
    </nav>
  
    
    <table class="table table-striped">
        <theader class="thead">
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Titulo</th>
                <th scope="col">Data</th>
                <th scope="col">Interesses</th>
                <th scope="col">Excluir</th>
            </tr>
        </thead>
        <tbody>

        <?php 
        require_once($_SERVER['DOCUMENT_ROOT'] . "/database/dbConnector.php");
        $pdo = getConnection();

        session_start();
        $codigo = $_SESSION['codigo'];
        
        try {
            $sql = <<<SQL
            SELECT codigo, titulo, dataHora FROM anuncio where codAnunciante = ? order by codigo
            SQL;
            
            try {
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$codigo]);

                $row = $stmt->fetch();
                if (!$row) {
                return null;
                }
                while ($row) {
                    echo "<tr>";
                    echo "<td>" . $row['codigo'] . "</td>";
                    echo "<td>" . $row['titulo'] . "</td>";
                    echo "<td>" . $row['dataHora'] . "</td>";
                    echo "<td><a href='/view/listaInteresses.php?codigo=" . $row['codigo'] . "'>Ver Interesses</a></td>";
                    echo "<td><a href='/controller/excluirAnuncio.php?codigo=" . $row['codigo'] . "'>Excluir</a></td>";
                    echo "</tr>";
                $row = $stmt->fetch();
                }
            } 
            catch (Exception $e) {
                exit('Falha inesperada: ' . $e->getMessage());
            }
            } 
            catch (Exception $e) {
            exit('Falha inesperada: ' . $e->getMessage());
            }
        ?>
        </tbody>
    </table>
    
    <footer>
        <!--
        <a href="https://www.flaticon.com/br/icones-gratis/futebol" title="futebol ícones">Futebol ícones criados por Smashicons - Flaticon</a>
        <a href="https://www.flaticon.com/br/icones-gratis/carro" title="carro ícones">Carro ícones criados por Kiranshastry - Flaticon</a>
        <a href="https://www.flaticon.com/br/icones-gratis/lugar" title="lugar ícones">Lugar ícones criados por Freepik - Flaticon</a>
        <a href="https://www.flaticon.com/br/icones-gratis/musica" title="música ícones">Música ícones criados por IYAHICON - Flaticon</a>
        <a href="https://www.flaticon.com/br/icones-gratis/fones-de-ouvido" title="fones de ouvido ícones">Fones de ouvido ícones criados por smashingstocks - Flaticon</a>
        <a href="https://www.flaticon.com/br/icones-gratis/smartphone" title="smartphone ícones">Smartphone ícones criados por Anatoly - Flaticon</a>
        <a href="https://www.flaticon.com/br/icones-gratis/guarda-roupa" title="guarda roupa ícones">Guarda roupa ícones criados por kornkun - Flaticon</a>
        -->
        <p>&copy;copyright all rights reserved 2022</p>
    </footer>
</body>

</html>