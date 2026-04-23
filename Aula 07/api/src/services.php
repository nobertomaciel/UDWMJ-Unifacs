<?php

function service_getClientes() {
    return model_getClientes();
}

function service_getClienteById($id) {
    $cliente = model_getClienteById($id);

    if (!$cliente) {
        jsonResponse(['error' => 'Cliente não encontrado'], 404);
        exit;
    }

    return $cliente;
}

function service_createCliente($data) {
    if (empty($data['nome']) || empty($data['cpf'])) {
        jsonResponse(['error' => 'Nome e CPF obrigatórios'], 400);
        exit;
    }

    return model_insertCliente($data);
}

function service_updateCliente($id, $data) {
    return model_updateCliente($id, $data);
}

function service_patchCliente($id, $data) {
    $cliente = model_getClienteById($id);

    if (!$cliente) {
        jsonResponse(['error' => 'Cliente não encontrado'], 404);
        exit;
    }

    $data = array_merge($cliente, $data);
    return model_updateCliente($id, $data);
}

function service_deleteCliente($id) {
    model_deleteCliente($id);
}
?>