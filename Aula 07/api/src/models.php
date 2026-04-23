<?php

function model_getClientes() {
    $conn = getConnection();

    $result = mysqli_query($conn, "SELECT * FROM clientes");

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function model_getClienteById($id) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, "SELECT * FROM clientes WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function model_insertCliente($data) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn,
        "INSERT INTO clientes (nome, cep, logradouro, bairro, localidade, uf, cpf) VALUES (?, ?, ?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sssssss",
        $data['nome'],
        $data['cep'],
        $data['logradouro'],
        $data['bairro'],
        $data['localidade'],
        $data['uf'],
        $data['cpf'],
    );

    if (!mysqli_stmt_execute($stmt)) {
        jsonResponse(['error' => 'Erro ao inserir'], 500);
        exit;
    }

    $id = mysqli_insert_id($conn);
    return model_getClienteById($id);
}

function model_updateCliente($id, $data) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn,
        "UPDATE clientes SET nome=?, cep=?, logradouro=?, bairro=?, localidade=?, uf=?, cpf=? WHERE id=?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sssssssi",
        $data['nome'],
        $data['cep'],
        $data['logradouro'],
        $data['bairro'],
        $data['localidade'],
        $data['uf'],
        $data['cpf'],
        $id
    );

    mysqli_stmt_execute($stmt);

    return model_getClienteById($id);
}

function model_deleteCliente($id) {
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, "DELETE FROM clientes WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}
?>