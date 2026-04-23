<?php
function getConnection() {
    $host = "";
    $banco = "";
    $user = "";
    $pass = "";
    global $conn;
    if (!$conn) {
        $conn = mysqli_connect($host, $user, $pass, $banco);
        if (!$conn) {
            jsonResponse(['error' => 'Erro na conexão com banco'], 500);
            exit;
        }
        mysqli_set_charset($conn, "utf8");
    }
    return $conn;
}
?>