<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Ex2</title>
    <style>
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

    </style>
</head>

<header>
    <a href="/index.html">
    <img id="header-logo" src="../assets/Logo256px.png" alt="OPG Commerce logo" width="64" height="64">    
    </a>
</header>

<body>
    
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
</body>
</html>