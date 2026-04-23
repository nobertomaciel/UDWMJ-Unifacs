<?php

function getClientes() {
    jsonResponse(service_getClientes());
}

function getClienteById($id) {
    jsonResponse(service_getClienteById($id));
}

function createCliente() {
    $data = json_decode(file_get_contents("php://input"), true);
    jsonResponse(service_createCliente($data), 201);
}

function updateCliente($id) {
    $data = json_decode(file_get_contents("php://input"), true);
    jsonResponse(service_updateCliente($id, $data));
}

function patchCliente($id) {
    $data = json_decode(file_get_contents("php://input"), true);
    jsonResponse(service_patchCliente($id, $data));
}

function deleteCliente($id) {
    service_deleteCliente($id);
    jsonResponse(null, 204);
}

function jsonResponse($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json');

    if ($data !== null) {
        echo json_encode($data);
    }
}
?>