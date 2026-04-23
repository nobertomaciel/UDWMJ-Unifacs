<?php
return [
    ['GET', '/clientes', 'getClientes'],
    ['GET', '/clientes/{id}', 'getClienteById'],
    ['POST', '/clientes', 'createCliente'],
    ['PUT', '/clientes/{id}', 'updateCliente'],
    ['PATCH', '/clientes/{id}', 'patchCliente'],
    ['DELETE', '/clientes/{id}', 'deleteCliente'],
];
?>