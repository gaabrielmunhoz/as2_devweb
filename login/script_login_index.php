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

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Erro de login | ToDoTasks</title>
  <meta http-equiv="refresh" content="3;url=../login/index.html">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="height: 100vh;">
  <div class="text-center">
    <div class="spinner-border text-success mb-3" role="status">
      <span class="sr-only">Carregando...</span>
    </div>
    <h4><?php echo $mensagem; ?></h4>
    <p>Você será redirecionado para a página de login...</p>
  </div>
</body>
</html>
