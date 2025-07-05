<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../banco_de_dados/conecta_bd.php";

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login_usuario = $_POST["login_usuario"];
    $senha_usuario = $_POST["senha_usuario"];

    $sql = "SELECT * FROM usuarios WHERE login_usuario = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $login_usuario);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    $usuario = mysqli_fetch_assoc($resultado);
    
    if ($usuario) {
        if (password_verify($senha_usuario, $usuario["senha_usuario"])) {
            $_SESSION["login_usuario"] = $usuario["login_usuario"];
            $_SESSION["nome_usuario"] = $usuario["nome_usuario"];
            header("Location: ../menu/menu.php");
            exit();
        } else {
            $mensagem = "Senha incorreta.";
        }
    } else {
        $mensagem = "Usuário não encontrado.";
    }
}
?>
