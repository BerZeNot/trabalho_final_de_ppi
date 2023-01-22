<?php
if (isset($_GET['cep'])){
    $cep = $_GET['cep'];

    $address = array(
        "cep" => "38408-216",
        "bairro" => "Santa Mônica",
        "cidade" => "Uberlândia",
        "estado" => "MG"
    );

    if($cep == '38408-216')
        echo json_encode($address);
    else {
        $address = array(
            "cep" => "",
            "bairro" => "",
            "cidade" => "",
            "estado" => ""
        );

        echo json_encode($address);
    }
        
}

?>