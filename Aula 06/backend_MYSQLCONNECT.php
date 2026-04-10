<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$input = file_get_contents("php://input");

$data = json_decode($input, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["status" => "erro", "mensagem" => "JSON inválido"]);
    exit;
}

include_once "bd.php";

if($conexao = mysqli_connect($host, $user, $pass, $banco)){        
        $sql = "INSERT INTO clientes (nome, cep, logradouro, bairro, localidade, uf) VALUES ('".$data['nome']."', '".$data['cep']."', '".$data['logradouro']."', '".$data['bairro']."', '".$data['localidade']."', '".$data['uf']."')";
        $result = mysqli_query($conexao,$sql);
        if($result){
            $msg = ["status" => "sucesso","mensagem" => "Dados inseridos no banco"];
        }
        else{
            $msg = ["status" => "erro","mensagem" => mysqli_error($conexao)];
        }
        echo json_encode($msg, JSON_PRETTY_PRINT);
}
else{
    $msg = ["status" => "erro","mensagem" => "Erro ao inserir dados no banco"];
    echo json_encode($msg, JSON_PRETTY_PRINT);
}
?>