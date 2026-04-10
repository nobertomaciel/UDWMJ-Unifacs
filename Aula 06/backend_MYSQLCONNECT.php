<?php
header("Access-Control-Allow-Origin: *"); // Permite acesso de qualquer origem
header("Access-Control-Allow-Methods: POST"); // Permite apenas o método POST
header("Set-Cookie: flavor=choco; SameSite=None; Secure"); // Configura o cookie com SameSite=None e Secure
header("Content-Type: application/json"); // Define o tipo de conteúdo como JSON

$input = file_get_contents("php://input"); // Lê os dados JSON enviados pelo cliente

$data = json_decode($input, true); // Decodifica o JSON para um array associativo
if (json_last_error() !== JSON_ERROR_NONE) { // Verifica se houve um erro na decodificação do JSON
    echo json_encode(["status" => "erro", "mensagem" => "JSON inválido"]); // Retorna uma mensagem de erro em formato JSON
    exit; // Encerra a execução do script em caso de erro, mas antes envia a resposta de erro para o cliente
}

include_once "bd.php"; // Inclui o arquivo de configuração do banco de dados, que contém as variáveis $host, $banco, $user e $pass

if($conexao = mysqli_connect($host, $user, $pass, $banco)){     // Tenta estabelecer uma conexão com o banco de dados usando as credenciais fornecidas    
        $sql = "INSERT INTO clientes (nome, cep, logradouro, bairro, localidade, uf) VALUES ('".$data['nome']."', '".$data['cep']."', '".$data['logradouro']."', '".$data['bairro']."', '".$data['localidade']."', '".$data['uf']."')"; // Prepara a consulta SQL para inserir os dados recebidos do cliente na tabela "clientes"
        $result = mysqli_query($conexao,$sql); // Executa a consulta SQL e armazena o resultado em $result
        if($result){ // Verifica se a consulta foi executada com sucesso
            $msg = ["status" => "sucesso","mensagem" => "Dados inseridos no banco"];
        }
        else{
            $msg = ["status" => "erro","mensagem" => mysqli_error($conexao)];
        }
        echo json_encode($msg, JSON_PRETTY_PRINT); // Retorna uma resposta em formato JSON indicando o status da operação (sucesso ou erro) e a mensagem correspondente, formatada de maneira legível
}
else{
    $msg = ["status" => "erro","mensagem" => "Erro ao inserir dados no banco"];
    echo json_encode($msg, JSON_PRETTY_PRINT);
}
?>